<?php

class MessageTest extends BaseTest
{
    protected $exception;

    public function setUp()
    {
        parent::setup();
        $this->exception = "{$this->namespace}\Exceptions\MessageException";
    }

    public function testConstructor()
    {
        $message = new \BulkSmsCenter\Message();
        $this->assertInstanceOf("{$this->namespace}\Message",$message);
    }

    public function testConstructorWithOptions()
    {
        $message = new \BulkSmsCenter\Message($options = [
            'key1' => 'value1',
            'key2' => 'value2',
        ]);
        $this->assertEquals($options,$message->getOptions());
    }

    public function testConstructorWithSetterOption()
    {
        $message = new \BulkSmsCenter\Message($options = [
            $key = 'id' => str_random(),
        ]);
        $this->assertEquals($options[$key],$message->getId());
    }

    public function testSetGetId()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setId($expected = str_random(32));
        $this->assertEquals($expected,$message->getId());
    }

    public function testSetGetBody()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setBody($expected = str_random(160));
        $this->assertEquals($expected,$message->getBody());
    }

    public function testSetGetRecipient()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setRecipient($expected = '3161234567890');
        $this->assertEquals($expected,$message->getRecipient());
    }

    public function testSetGetRoute()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setRoute($expected = $message::TYPE_PREMIUM);
        $this->assertEquals($expected,$message->getRoute());
    }

    public function testSetInvalidRoute()
    {
        $message = new \BulkSmsCenter\Message();
        $this->expectException($this->exception);
        $message->setRoute('test');
    }

    public function testSetGetSender()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setSender($expected = '3161234567890');
        $this->assertEquals($expected,$message->getSender());
    }

    public function testSetGetSent()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setSent(true);
        $this->assertTrue($message->getSent());
    }

    public function testGetStatusException()
    {
        $message = new \BulkSmsCenter\Message();
        $this->expectException($this->exception);
        $message->getStatus();
    }
}
