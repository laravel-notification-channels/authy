<?php


namespace NotificationChannels\Authy\Test;

use PHPUnit\Framework\TestCase;
use NotificationChannels\Authy\AuthyMessage;

class MessageTest extends TestCase
{
    /** @var \NotificationChannels\Authy\AuthyMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();

        $this->message = new AuthyMessage();
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = AuthyMessage::create();

        $this->assertInstanceOf(AuthyMessage::class, $message);
    }

    /** @test */
    public function it_has_default_tokens_not_forced_over_cellphone_network()
    {
        $this->assertEquals(false, $this->message->force);
    }

    /** @test */
    public function it_can_force_the_token_over_cellphone_network()
    {
        $this->message->force();

        $this->assertEquals(true, $this->message->force);
    }

    /** @test */
    public function it_can_set_token_sending_method()
    {
        $this->message->method('call');

        $this->assertEquals('call', $this->message->method);
    }

    /** @test */
    public function it_can_set_token_sending_action()
    {
        $this->message->action('login');

        $this->assertEquals('login', $this->message->action);
    }

    /** @test */
    public function it_can_set_token_sending_action_message()
    {
        $this->message->actionMessage('Login Code');

        $this->assertEquals('Login Code', $this->message->actionMessage);
    }

    /** @test */
    public function it_has_default_tokens_sent_as_sms()
    {
        $this->assertEquals('sms', $this->message->method);
    }
}
