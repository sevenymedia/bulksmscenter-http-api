<?php namespace BulkSmsCenter;

use BulkSmsCenter\Exceptions\ClientException;

class Client
{
    const VERSION = '0.1';

    const RESPONSE_KEY__CODE = 'APIcode';
    const RESPONSE_KEY__CREDITS = 'APIcredits';
    const RESPONSE_KEY__ID = 'APIsmsID';

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

    protected function apiCode()
    {
        $key = static::RESPONSE_KEY__CODE;
        $response = $this->getHttpClient()->getApiResponse();
        if (isset($response[$key])) {
            return $response[$key];
        }
        return 0000;
    }

    protected function validApiCode($code = 1000)
    {
        $apiCode = $this->apiCode();
        return (int)$apiCode === (int)$code;
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

        $httpClient = $this->getHttpClient();
        $message = $this->getMessage();
        if ($httpClient->runCommand('sms_send_sms',[
            'to' => $message->getRecipient(),
            'message' => $message->getBody(),
            'from' => $message->getSender(),
            'route' => $message->getRoute(),
        ]) === false) {
            return false;
        }

        $response = $httpClient->getApiResponse();
        if ($this->validApiCode() === false) {
            throw new ClientException("Got an invalid API code ({$response[static::RESPONSE_KEY__CODE]})");
        }

        $message->setId($response[static::RESPONSE_KEY__ID])->setSent();
        return true;
    }

    public function getBalance()
    {
        $httpClient = $this->getHttpClient();
        if ($httpClient->runCommand('get_credits') === false) {
            return false;
        }

        $response = $httpClient->getApiResponse();
        if ($this->validApiCode() === false) {
            throw new ClientException("Got an invalid API code ({$response[static::RESPONSE_KEY__CODE]})");
        } elseif (isset($response[$key = static::RESPONSE_KEY__CREDITS])) {
            return (float)$response[$key];
        }

        return false;
    }
}
