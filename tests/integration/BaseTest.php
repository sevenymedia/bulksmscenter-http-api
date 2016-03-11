<?php

class BaseTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \BulkSmsCenter\Auth
     */
    protected $auth;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockClient;

    public function setUp()
    {
        $this->auth = new \BulkSmsCenter\Auth('YOUR_USERNAME','YOUR_PASSWORD');
        $this->mockClient = $this->getMockBuilder("\BulkSmsCenter\HttpClient")->getMock();
    }

    public function testConstructor()
    {
        $client = new \BulkSmsCenter\Client();
        $this->assertInstanceOf('BulkSmsCenter\Message',$client->getMessage());
    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('setUserAgent');
        $client = new \BulkSmsCenter\Client($this->auth,$this->mockClient);
    }

}
