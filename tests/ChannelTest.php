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

use Mockery;
use PHPUnit_Framework_TestCase;
use Rinvex\Authy\Token as AuthyToken;
use Illuminate\Notifications\Notification;
use Rinvex\Authy\Response as AuthyResponse;
use NotificationChannels\Authy\AuthyChannel;
use NotificationChannels\Authy\AuthyMessage;
use GuzzleHttp\Psr7\Response as HttpResponse;

class ChannelTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        // Prepare Responses
        $httpResponse = new HttpResponse(200, [], json_encode(['success' => true]));
        $authyResponse = new AuthyResponse($httpResponse);

        // Mock Authy Token
        $authyToken = Mockery::mock(AuthyToken::class);
        $authyToken->shouldReceive('send')
               ->once()
               ->with(12345, 'sms', false, null, null)
               ->andReturn($authyResponse);

        // Send Notification
        $channel = new AuthyChannel($authyToken);
        $result = $channel->send(new TestNotifiable(), new TestNotification());

        $this->assertTrue($result);
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForAuthy()
    {
        return 12345;
    }
}

class TestNotification extends Notification
{
    public function toAuthy($notifiable)
    {
        return AuthyMessage::create();
    }
}
