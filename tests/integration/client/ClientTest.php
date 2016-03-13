<?php

class ClientTest extends BaseTest
{
    /**
     * @var \BulkSmsCenter\Client
     */
    protected $client;

    protected $exception;

    public function setUp()
    {
        parent::setup();
        $this->client = new \BulkSmsCenter\Client($this->mockAuth,$this->mockClient);
        $this->exception = "{$this->namespace}\Exceptions\ClientException";
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

    public function testGetBalanceException()
    {
        $client = new \BulkSmsCenter\Client($this->mockAuth);
        $this->expectException($this->exception);
        $client->getBalance();
    }

    public function testSendWithoutMessage()
    {
        $oldMessage = $this->client->getMessage();
        $this->expectException($this->exception);
        $this->client->clearMessage()->sendMessage();
        $this->client->setMessage($oldMessage);
    }

    public function testSendMessageException()
    {
        $this->expectException($this->exception);
        $this->client->sendMessage($this->mockMessage);
    }
}
