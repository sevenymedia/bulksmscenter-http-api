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
}
