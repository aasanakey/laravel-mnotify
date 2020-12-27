<?php
namespace Tests;

use Orchestra\Testbench\TestCase;
use Sanakey\Mnotify\Message;

class MessageTest extends TestCase
{

    protected function setUp():void
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_create_message()
    {
        $message = (new Message())
                ->sender_id("Test id")
                ->title("Test Message")
                ->message("This is a test message from mnotify api package");
        $data = $message->toArray();
        $this->assertArrayHasKey('sender_id',$data);
        $this->assertEquals("Test id",$data['sender_id']);
        $this->assertArrayHasKey('title',$data);
        $this->assertEquals("Test Message",$data['title']);
        $this->assertArrayHasKey('message',$data);
        $this->assertEquals("This is a test message from mnotify api package",$data['message']);

    }
}