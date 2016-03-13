<?php namespace BulkSmsCenter\Tests;

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

    public function testAddHosts()
    {
        $httpClient = new \BulkSmsCenter\HttpClient($this->mockAuth);
        $httpClient->setHosts([]);
        $this->assertEquals([$host = 'api.google.nl',],$httpClient->addHosts($host)->getHosts());
    }

//    public function testInvalidCommand()
//    {
//        $httpClient = new \BulkSmsCenter\HttpClient($this->mockAuth);
//        $this->expectException($this->exception,\BulkSmsCenter\Exceptions\HttpClientException::CODE__NO_OK_RECEIVED);
//        $httpClient->runCommand('test_command');
//    }
}
