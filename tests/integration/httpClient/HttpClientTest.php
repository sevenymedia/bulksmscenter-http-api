<?php

use BulkSmsCenter\Exceptions\HttpClientException;

class HttpClientTest extends BaseTest
{
    protected $exception;

    public function setUp()
    {
        parent::setup();
        $this->exception = "{$this->namespace}\Exceptions\HttpClientException";
    }

    public function testConstructor()
    {
        $httpClient = new \BulkSmsCenter\HttpClient($this->mockAuth);
        $this->assertInstanceOf("{$this->namespace}\HttpClient",$httpClient);
    }

    public function testSetGetHosts()
    {
        $httpClient = new \BulkSmsCenter\HttpClient($this->mockAuth);
        $httpClient->setHosts($expected = ['api1.google.nl','api1.google.nl',]);
        $this->assertEquals($expected,$httpClient->getHosts());
    }

//    public function testInvalidCommand()
//    {
//        $httpClient = new \BulkSmsCenter\HttpClient($this->mockAuth);
//        $this->expectException($this->exception,HttpClientException::CODE__NO_OK_RECEIVED);
//        $httpClient->runCommand('test_command');
//    }
}
