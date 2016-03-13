<?php namespace BulkSmsCenter;

class Message
{
    const TYPE_DIRECT = 'direct';
    const TYPE_PREMIUM = 'premium';

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
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
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
     */
    public function setRoute($route)
    {
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
     * @param string $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }
}
