<?php

class HttpClientTest extends BaseTest
{
    public function testConstructor()
    {
        $client = new \BulkSmsCenter\HttpClient($this->mockAuth);
        $this->assertInstanceOf("{$this->namespace}\HttpClient",$client);
    }
}
