<?php

namespace NotificationChannels\Authy;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\Notification;
use NotificationChannels\Authy\Exceptions\InvalidConfiguration;

class AuthyChannel
{
    /**
     * The Authy production API endpoint.
     *
     * @var string
     */
    const API_ENDPOINT_PRODUCTION = 'https://api.authy.com';

    /**
     * The Authy sandbox API endpoint.
     *
     * @var string
     */
    const API_ENDPOINT_SANDBOX = 'http://sandbox-api.authy.com';

    /**
     * The HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * The Authy service key.
     *
     * @var string
     */
    protected $key;

    /**
     * The Authy service API endpoint.
     *
     * @var string
     */
    protected $api;

    /**
     * Create a new Slack channel instance.
     *
     * @param \GuzzleHttp\Client $http
     *
     * @throws \NotificationChannels\Authy\Exceptions\InvalidConfiguration
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;

        // Prepare required data
        $mode      = config('services.authy.mode');
        $this->key = config('services.authy.keys.'.$mode);
        $this->api = $mode === 'sandbox' ? static::API_ENDPOINT_SANDBOX : static::API_ENDPOINT_PRODUCTION;

        // Check configuration
        if (! $mode || ! $this->key) {
            throw InvalidConfiguration::missingCredentials();
        }
    }

    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return bool
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $authyId = $notifiable->routeNotificationFor('authy')) {
            return false;
        }

        $message = $notification->toAuthy($notifiable);

        // Prepare required data
        $force = $message->force ? '&force=true' : '';
        $url   = $this->api.'/protected/json/'.$message->method.'/'.$authyId.'?api_key='.$this->key.$force;

        // Send Authy notification
        $response = json_decode($this->http->get($url)->getBody(), true);

        return isset($response['success']) && $response['success'];
    }
}
