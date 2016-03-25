<?php namespace BulkSmsCenter;

/**
 * Class Auth
 *
 * @package sevenymedia/bulksmscenter-http-api
 */
class Auth
{
    /**
     * Contains API password
     *
     * @var string
     */
    protected $password;

    /**
     * Contains API username
     * 
     * @var string
     */
    protected $username;

    /**
     * Auth constructor.
     *
     * @param $username
     * @param $password
     */
    public function __construct($username,$password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * Get API password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set API password
     *
     * @param $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = trim($password);
        return $this;
    }

    /**
     * Get API username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set API username
     *
     * @param $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = trim($username);
        return $this;
    }
}
