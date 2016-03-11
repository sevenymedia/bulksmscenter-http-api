<?php namespace BulkSmsCenter;

class Auth {

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $username;

    public function __construct($username,$password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }/**
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
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
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
