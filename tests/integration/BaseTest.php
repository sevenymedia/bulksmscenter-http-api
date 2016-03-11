<?php

class BaseTest extends PHPUnit_Framework_TestCase {

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockAuth;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockClient;

    public function setUp()
    {
        $this->mockAuth = $this->getMockBuilder("\BulkSmsCenter\Auth")->setConstructorArgs([
            'YOUR_USERNAME',
            'YOUR_PASSWORD',
        ])->getMock();
        $this->mockClient = $this->getMockBuilder("\BulkSmsCenter\HttpClient")->getMock();
    }

    public function testConstructor()
    {
        $client = new \BulkSmsCenter\Client();
        $this->assertInstanceOf('BulkSmsCenter\Message',$client->getMessage());
    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('setAuth');
        $this->mockClient->expects($this->atLeastOnce())->method('setUserAgent');
        $client = new \BulkSmsCenter\Client($this->auth,$this->mockClient);
    }

}
