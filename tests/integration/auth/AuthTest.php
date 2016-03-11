<?php

class AuthTest extends BaseTest {

    /**
     * @var \BulkSmsCenter\Client
     */
    protected $client;

    public function setUp()
    {
        parent::setup();
        $this->client = new \BulkSmsCenter\Client($this->auth,$this->mockClient);
    }

}
