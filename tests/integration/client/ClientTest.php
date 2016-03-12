<?php

class ClientTest extends BaseTest
{
    /**
     * @var \BulkSmsCenter\Client
     */
    protected $client;

    public function setUp()
    {
        parent::setup();
        $this->client = new \BulkSmsCenter\Client($this->mockAuth,$this->mockClient);
    }

    public function testConstructor()
    {
        $client = new \BulkSmsCenter\Client();
        $this->assertInstanceOf("{$this->namespace}\HttpClient",$client->getHttpClient());
        $this->assertInstanceOf("{$this->namespace}\Message",$client->getMessage());
    }

    public function testGetHttpClient()
    {
        $this->assertInstanceOf("{$this->namespace}\HttpClient",$this->client->getHttpClient());
    }

    public function testGetMessage()
    {
        $this->assertInstanceOf("{$this->namespace}\Message",$this->client->getMessage());
    }

    public function testGetBalance()
    {
        $client = new \BulkSmsCenter\Client($auth = new \BulkSmsCenter\Auth(env('USERNAME'),env('PASSWORD')));
        $this->assertInternalType('float',$client->getBalance());
    }
}
