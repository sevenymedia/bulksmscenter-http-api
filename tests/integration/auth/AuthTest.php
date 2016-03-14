<?php namespace BulkSmsCenter\Tests;

class AuthTest extends BaseTest
{
    /**
     * @var \BulkSmsCenter\Client
     */
    protected $client;

    public function testConstructor()
    {
        $auth = new \BulkSmsCenter\Auth(env('TEST_USERNAME'),env('TEST_PASSWORD'));
        $this->assertInstanceOf("{$this->namespace}\Auth",$auth);
    }

    public function testGetPassword()
    {
        $password = 'YOUR_PASSWORD';
        $auth = new \BulkSmsCenter\Auth(env('TEST_USERNAME'),$password);
        $this->assertEquals($password,$auth->getPassword());
    }

    public function testGetUsername()
    {
        $username = 'YOUR_USERNAME';
        $auth = new \BulkSmsCenter\Auth($username,env('TEST_PASSWORD'));
        $this->assertEquals($username,$auth->getUsername());
    }
}
