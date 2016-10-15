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
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\Notification;
use NotificationChannels\Authy\AuthyChannel;
use NotificationChannels\Authy\AuthyMessage;
use NotificationChannels\Authy\Exceptions\InvalidConfiguration;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $this->app['config']->set('services.authy.mode', 'production');
        $this->app['config']->set('services.authy.keys.production', 'AuthyKey');

        $response = new Response(200, [], json_encode(['success' => false]));
        $client   = Mockery::mock(HttpClient::class);
        $client->shouldReceive('get')
               ->once()
               ->with('https://api.authy.com/protected/json/sms/12345?api_key=AuthyKey')
               ->andReturn($response);
        $channel = new AuthyChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_is_not_configured()
    {
        $this->expectException(InvalidConfiguration::class);

        $client  = new HttpClient();
        $channel = new AuthyChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
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
