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
