<?php

class ClientTest extends BaseTest {

    /**
     * @var \BulkSmsCenter\Client
     */
    protected $client;

    public function setUp()
    {
        parent::setup();
        $this->client = new \BulkSmsCenter\Client($this->mockAuth,$this->mockClient);
    }

}