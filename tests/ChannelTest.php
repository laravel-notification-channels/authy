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
use Rinvex\Authy\Token as AuthyToken;
use Illuminate\Notifications\Notification;
use NotificationChannels\Authy\AuthyChannel;
use NotificationChannels\Authy\AuthyMessage;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $this->app['config']->set('services.authy.secret', 'AuthySecretKey');

        $client = Mockery::mock(HttpClient::class);
        $url = 'https://api.authy.com/protected/json/sms/12345';
        $response = new Response(200, [], json_encode(['success' => true]));
        $params = [
            'http_errors' => false,
            'headers'     => ['X-Authy-API-Key' => 'AuthySecretKey'],
            'query'       => [
                'force'         => false,
                'action'        => null,
                'actionMessage' => null,
            ],
        ];
        $client->shouldReceive('get')
               ->once()
               ->with($url, $params)
               ->andReturn($response);

        $authyToken = new AuthyToken($client, config('services.authy.secret'));
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
