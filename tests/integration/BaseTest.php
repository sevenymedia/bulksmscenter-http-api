<?php

class BaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockAuth;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockClient;

    /**
     * @var string
     */
    protected $namespace = 'BulkSmsCenter';

    public function setUp()
    {
        $this->mockAuth = $this->getMockBuilder('\\'.$this->namespace.'\\Auth')->setConstructorArgs([
            'YOUR_USERNAME',
            'YOUR_PASSWORD',
        ])->getMock();
        $this->mockClient = $this->getMockBuilder('\\'.$this->namespace.'\\HttpClient')->getMock();
    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('setAuth');
        $this->mockClient->expects($this->atLeastOnce())->method('setUserAgent');
        $client = new \BulkSmsCenter\Client($this->mockAuth,$this->mockClient);
    }
}
