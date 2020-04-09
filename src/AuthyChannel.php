<?php

declare(strict_types=1);

namespace NotificationChannels\Authy;

use Illuminate\Notifications\Notification;
use Rinvex\Authy\Token as AuthyToken;

class AuthyChannel
{
    /**
     * The Authy token instance.
     *
     * @var \Rinvex\Authy\Token
     */
    protected $authyToken;

    /**
     * Create a new Authy channel instance.
     *
     * @param \Rinvex\Authy\Token $authyToken
     */
    public function __construct(AuthyToken $authyToken)
    {
        $this->authyToken = $authyToken;
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

        // Prepare notification message
        $message = $notification->toAuthy($notifiable);

        // Send Authy notification and get the result
        $result = $this->authyToken->send($authyId, $message->method, $message->force, $message->action, $message->actionMessage);

        return $result->succeed();
    }
}
