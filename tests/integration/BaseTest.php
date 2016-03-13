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
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockMessage;

    /**
     * @var string
     */
    protected $namespace = 'BulkSmsCenter';

    public function expectException($exception)
    {
        if (version_compare(PHPUnit_Runner_Version::id(),'5.2') === -1) {
            $this->setExpectedException($exception);
        } else {
            parent::expectException($exception);
        }
    }

    public function setUp()
    {
        $this->mockAuth = $this->getMockBuilder('\\'.$this->namespace.'\\Auth')->setConstructorArgs([
            'YOUR_USERNAME',
            'YOUR_PASSWORD',
        ])->getMock();
        $this->mockClient = $this->getMockBuilder('\\'.$this->namespace.'\\HttpClient')->getMock();
        $this->mockMessage = $this->getMockBuilder('\\'.$this->namespace.'\\Message')->getMock();
    }

    public function testEnvDefault()
    {
        $this->assertTrue(env('TEST_NON_EXISTING_VARIABLE',true));
    }

    public function testEnvEmpty()
    {
        $this->assertEmpty(env('TEST_EMPTY'));
    }

    public function testEnvFalse()
    {
        $this->assertFalse(env('TEST_FALSE'));
    }

    public function testEnvNull()
    {
        $this->assertNull(env('TEST_NULL'));
    }

    public function testEnvQuotes()
    {
        $key = 'TEST_QUOTES';
        $value = 'quotes';
        putenv($key.'="'.$value.'"');
        $this->assertEquals($value,env($key));
    }

    public function testEnvTrue()
    {
        $this->assertTrue(env('TEST_TRUE'));
    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('setAuth');
        $this->mockClient->expects($this->atLeastOnce())->method('setUserAgent');
        $client = new \BulkSmsCenter\Client($this->mockAuth,$this->mockClient);
    }
}
