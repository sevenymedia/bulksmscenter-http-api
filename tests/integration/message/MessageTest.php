<?php

class MessageTest extends BaseTest
{
    protected function strRandom($length = 16)
    {
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = openssl_random_pseudo_bytes($size);
            $string .= substr(str_replace(['/','+','='],'',base64_encode($bytes)),0,$size);
        }
        return $string;
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
            $key = 'id' => $this->strRandom(),
        ]);
        $this->assertEquals($options[$key],$message->getId());
    }

    public function testSetGetId()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setId($expected = $this->strRandom(32));
        $this->assertEquals($expected,$message->getId());
    }

    public function testSetGetBody()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setBody($expected = $this->strRandom(160));
        $this->assertEquals($expected,$message->getBody());
    }

    public function testSetGetRecipient()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setRecipient($expected = '3161234567890');
        $this->assertEquals($expected,$message->getRecipient());
    }

    public function testSetGetSender()
    {
        $message = new \BulkSmsCenter\Message();
        $message->setSender($expected = '3161234567890');
        $this->assertEquals($expected,$message->getSender());
    }
}
