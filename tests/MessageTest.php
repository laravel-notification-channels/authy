<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Authy Notification Channel for Laravel Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Authy Notification Channel for Laravel Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

namespace NotificationChannels\Authy\Test;

use PHPUnit_Framework_TestCase;
use NotificationChannels\Authy\AuthyMessage;

class MessageTest extends PHPUnit_Framework_TestCase
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
    public function it_can_force_the_token_over_cellphone_network()
    {
        $this->message->force(true);

        $this->assertEquals(true, $this->message->force);
    }

    /** @test */
    public function it_has_default_tokens_not_forced_over_cellphone_network()
    {
        $this->assertEquals(false, $this->message->force);
    }

    /** @test */
    public function it_can_set_token_sending_method()
    {
        $this->message->method('call');

        $this->assertEquals('call', $this->message->method);
    }

    /** @test */
    public function it_has_default_tokens_sent_as_sms()
    {
        $this->assertEquals('sms', $this->message->method);
    }
}
