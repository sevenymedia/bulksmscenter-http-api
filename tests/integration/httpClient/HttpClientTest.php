<?php

class HttpClientTest extends BaseTest
{
    public function testConstructor()
    {
        $httpClient = new \BulkSmsCenter\HttpClient($this->mockAuth);
        $this->assertInstanceOf("{$this->namespace}\HttpClient",$httpClient);
    }
}
