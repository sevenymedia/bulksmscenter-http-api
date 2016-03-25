<?php namespace BulkSmsCenter;

use BulkSmsCenter\Exceptions\MessageException;

/**
 * Class Message
 *
 * @package sevenymedia/bulksmscenter-http-api
 */
class Message
{
    /**
     * Value of a direct message
     * 1.2 credits
     * Delivery guarantee of 99.99%.
     *
     * @var string
     */
    const TYPE_DIRECT = 'direct';

    /**
     * Value of a premium message
     * 1 credit
     * Delivery guarantee of 99%.
     *
     * @var string
     */
    const TYPE_PREMIUM = 'premium';

    /**
     * Will contain the Message ID received from API
     *
     * @var string
     */
    protected $id;

    /**
     * Will contain the Message body text
     *
     * @var string
     */
    protected $body;

    /**
     * Will contain some options
     * Might be used in the future
     *
     * @var array
     */
    protected $options;

    /**
     * Will contain the Message recipient
     *
     * @var string
     */
    protected $recipient;

    /**
     * Will contain the type of Message (direct/premium)
     *
     * @var string
     */
    protected $type;

    /**
     * Will contain the sender of the Message
     *
     * @var string
     */
    protected $sender;

    /**
     * Will contain the 'sent' status
     *
     * @var boolean
     */
    protected $sent;

    /**
     * Message constructor.
     *
     * @param array $arrOptions
     */
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
     * Return the Message ID received from the API
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the Message ID received from the API
     *
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
     * Returns the Message body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the Message body
     *
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
     * Returns some options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set some options
     *
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
     * Returns the Message recipient
     *
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set the Message recipient
     *
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
     * Returns the Message type (direct/premium)
     *
     * @return string
     */
    public function getType()
    {
        return $this->type ?: $this->setType(static::TYPE_PREMIUM);
    }

    /**
     * Set the Message type (direct/premium)
     *
     * @param $type
     *
     * @return $this
     * @throws MessageException
     */
    public function setType($type)
    {
        if (!in_array($type,[static::TYPE_DIRECT,static::TYPE_PREMIUM,])) {
            throw new MessageException(MessageException::MESSAGE__INVALID_ROUTE,MessageException::CODE__INVALID_ROUTE);
        }
        $this->type = $type;
        return $this;
    }

    /**
     * Get the sender of the Message
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set the sender of the Message
     *
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
     * Returns if Message has been sent
     *
     * @return boolean
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set 'sent' status
     *
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
