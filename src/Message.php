<?php namespace BulkSmsCenter;

use BulkSmsCenter\Exceptions\MessageException;

class Message
{
    const TYPE_DIRECT = 'direct';
    const TYPE_PREMIUM = 'premium';

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $recipient;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var boolean
     */
    protected $sent;

    /**
     * @return HttpClient
     */
    private function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param HttpClient $httpClient
     *
     * @return $this
     */
    private function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    public function __construct(array $arrOptions = [])
    {
        foreach ($arrOptions as $strKey => $mixValue) {
            if (method_exists($this,$strMethod = 'set'.ucfirst($strKey))) {
                $this->$strMethod($mixValue);
                unset($arrOptions[$strKey]);
            }
        }
        $this->setOptions($arrOptions);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $options
     *
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param $recipient
     *
     * @return $this
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route ?: $this->setRoute(static::TYPE_PREMIUM);
    }

    /**
     * @param $route
     *
     * @return $this
     * @throws MessageException
     */
    public function setRoute($route)
    {
        if (!in_array($route,[static::TYPE_DIRECT,static::TYPE_PREMIUM,])) {
            throw new MessageException(MessageException::MESSAGE__INVALID_ROUTE,MessageException::CODE__INVALID_ROUTE);
        }
        $this->route = $route;
        return $this;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param $sender
     *
     * @return $this
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * @param bool $sent
     *
     * @return $this
     */
    public function setSent($sent = true)
    {
        $this->sent = $sent;
        return $this;
    }
}
