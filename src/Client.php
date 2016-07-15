<?php namespace BulkSmsCenter;

use BulkSmsCenter\Exceptions\ClientException;

/**
 * Class Client
 *
 * @package sevenymedia/bulksmscenter-http-api
 */
class Client
{
    /**
     * Contains package version
     *
     * @var string
     */
    const VERSION = '1.0.7';

    /**
     * Response key for the API code
     *
     * @var string
     */
    const RESPONSE_KEY__CODE = 'APIcode';

    /**
     * Response key for API credits
     *
     * @var string
     */
    const RESPONSE_KEY__CREDITS = 'APIcredits';

    /**
     * Response key for API message ID
     *
     * @var string
     */
    const RESPONSE_KEY__ID = 'APIsmsID';

    /**
     * Response key for the API status
     *
     * @var string
     */
    const RESPONSE_KEY__STATUS = 'APIstatus';

    /**
     * Direct route value
     * 1.2 credits
     * Delivery guarantee of 99.99%.
     *
     * @var string
     */
    const ROUTE_DIRECT = 'direct';

    /**
     * Premium route value
     * 1 credit
     * Delivery guarantee of 99%.
     *
     * @var string
     */
    const ROUTE_PREMIUM = 'premium';

    /**
     * Contains an instance of HttpClient
     *
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Contains an instance of Message
     *
     * @var Message
     */
    protected $message;

    /**
     * Contains data which will be posted to the API
     *
     * @var array
     */
    protected $postData;

    /**
     * Returns a stringified PHP version
     *
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

    /**
     * Returns the API code from the latest request
     *
     * @return int
     */
    protected function apiCode()
    {
        $key = static::RESPONSE_KEY__CODE;
        $response = $this->getHttpClient()->getApiResponse();
        if (isset($response[$key])) {
            return $response[$key];
        }
        return 0000;
    }

    /**
     * Checks if the given API code matches the API code from the latest request
     *
     * @param int $code
     *
     * @return bool
     */
    protected function validApiCode($code = 1000)
    {
        $apiCode = $this->apiCode();
        return (int)$apiCode === (int)$code;
    }

    /**
     * Client constructor.
     *
     * @param Auth|null $auth
     * @param HttpClient|null $httpClient
     */
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

    /**
     * Get an instance of HttpClient
     *
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient ?: $this->httpClient = new HttpClient();
    }

    /**
     * Set the HttpClient instance to use in the request
     *
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
     * Get the Message instance
     *
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Clear the Message instance
     *
     * @return $this
     */
    public function clearMessage()
    {
        $this->message = null;
        return $this;
    }

    /**
     * Set the Message instance to use in the request
     *
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
     * Send the given message, if no Message instance given than the instance from the object will be used
     *
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
            throw new ClientException(ClientException::MESSAGE__NO_MESSAGE_SET,ClientException::CODE__NO_MESSAGE_SET);
        }

        $httpClient = $this->getHttpClient();
        $message = $this->getMessage();
        if ($httpClient->runCommand('sms_send_sms',[
            'to' => $message->getRecipient(),
            'message' => $message->getBody(),
            'from' => $message->getSender(),
            'route' => $message->getType(),
        ]) === false) {
            return false;
        }

        $response = $httpClient->getApiResponse();
        if ($this->validApiCode() === false) {
            throw new ClientException(
                sprintf(ClientException::MESSAGE__INVALID_API_CODE,$response[static::RESPONSE_KEY__CODE]),
                ClientException::CODE__INVALID_API_CODE
            );
        }

        $message->setId($response[static::RESPONSE_KEY__ID])->setSent();
        return true;
    }

    /**
     * Get amount of remaining credits from the API
     *
     * @return bool|float
     * @throws ClientException
     * @throws Exceptions\HttpClientException
     */
    public function getBalance()
    {
        $httpClient = $this->getHttpClient();
        if ($httpClient->runCommand('get_credits') === false) {
            return false;
        }

        $response = $httpClient->getApiResponse();
        if ($this->validApiCode() === false) {
            throw new ClientException(
                sprintf(ClientException::MESSAGE__INVALID_API_CODE,$response[static::RESPONSE_KEY__CODE]),
                ClientException::CODE__INVALID_API_CODE
            );
        } elseif (isset($response[$key = static::RESPONSE_KEY__CREDITS])) {
            return (float)$response[$key];
        }

        return false;
    }

    /**
     * Get the delivery status of the given Message ID
     *
     * @param $messageId
     *
     * @return bool|int
     * @throws ClientException
     * @throws Exceptions\HttpClientException
     */
    public function getMessageStatus($messageId)
    {
        $httpClient = $this->getHttpClient();
        if ($httpClient->runCommand('sms_get_dlr',[
            'smsid' => $messageId,
        ]) === false) {
            return false;
        }

        $response = $httpClient->getApiResponse();
        if ($this->validApiCode() === false) {
            throw new ClientException(
                sprintf(ClientException::MESSAGE__INVALID_API_CODE,$response[static::RESPONSE_KEY__CODE]),
                ClientException::CODE__INVALID_API_CODE
            );
        } elseif (isset($response[$key = static::RESPONSE_KEY__STATUS])) {
            return (int)$response[$key];
        }

        return false;
    }
}
