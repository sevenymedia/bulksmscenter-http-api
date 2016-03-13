<?php namespace BulkSmsCenter;

use BulkSmsCenter\Exceptions\ClientException;

class Client
{
    const VERSION = '0.1';

    const RESPONSE_KEY__CODE = 'APIcode';
    const RESPONSE_KEY__CREDITS = 'APIcredits';

    const ROUTE_DIRECT = 'direct';
    const ROUTE_PREMIUM = 'premium';

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var array
     */
    protected $postData;

    /**
     * @return string
     */
    private function phpVersion()
    {
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.',PHP_VERSION);
            define('PHP_VERSION_ID',($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }
        return 'PHP/'.PHP_VERSION_ID;
    }

    protected function validApiCode($code = 1000)
    {
        $key = static::RESPONSE_KEY__CODE;
        $response = $this->getHttpClient()->getApiResponse();
        switch (true) {
            case !isset($response[$key]):
            case (int)$response[$key] !== $code:
                return false;
            default:
                return true;
        }
    }

    public function __construct(Auth $auth = null,HttpClient $httpClient = null)
    {
        if ($httpClient !== null) {
            $this->setHttpClient($httpClient);
        }
        if ($auth !== null) {
            $this->getHttpClient()->setAuth($auth);
        }
        $this->getHttpClient()->setUserAgent([
            __NAMESPACE__.'/ApiClient/'.static::VERSION,
            $this->phpVersion(),
        ]);
        $this->setMessage(new Message());
    }

    public function getHttpClient()
    {
        return $this->httpClient ?: $this->httpClient = new HttpClient();
    }

    /**
     * @param HttpClient $httpClient
     *
     * @return $this
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function clearMessage()
    {
        $this->message = null;
        return $this;
    }

    /**
     * @param Message $message
     *
     * @return $this
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return bool
     */
    public function sendingPassed()
    {
        return $this->getApiCode() === 1000;
    }

    /**
     * @param Message|null $message
     *
     * @return $this
     * @throws ClientException
     */
    public function sendMessage(Message $message = null)
    {
        if ($message !== null) {
            $this->setMessage($message);
        }
        if (!($message = $this->getMessage()) instanceof Message) {
            throw new ClientException('No message set');
        }

        $request = $this->runCommand('sms_send_sms',[
            'to' => $this->message->getRecipient(),
            'message' => $this->message->getBody(),
            'from' => $this->message->getSender(),
            'route' => $this->route(),
        ]);
        if ($request === false) {
            throw new ClientException('Failed to send message');
        }

        $this->setRawResponse($request->getBody()->getContents());

        $response = $this->getResponse();
        $this->message->setId($response['APIsmsID']);

        return $this;
    }

    public function getApiCode()
    {
        $response = $this->getHttpClient()->getResponse();
        return (isset($response['APIcode']) ? $response['APIcode'] : 0000);
    }

    public function getBalance()
    {
        $httpClient = $this->getHttpClient();
        if ($httpClient->runCommand('get_credits') === false) {
            return false;
        }
        $response = $httpClient->getApiResponse();
        if (isset($response['APIcredits'])) {
            return (float)$response['APIcredits'];
        }
        return false;
    }
}
