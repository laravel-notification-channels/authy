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

namespace NotificationChannels\Authy;

class AuthyMessage
{
    /**
     * Determine whether to force the notification over cellphone network.
     *
     * @var bool
     */
    public $force = false;

    /**
     * The notification method (sms/call).
     *
     * @var string
     */
    public $method = 'sms';

    /**
     * Create a new Authy message instance.
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Indicate that the notification is forced over cellphone network.
     *
     * @param bool $force
     *
     * @return $this
     */
    public function force($force)
    {
        $this->force = $force;

        return $this;
    }

    /**
     * Set the method of the Authy message.
     *
     * @param string $method
     *
     * @return $this
     */
    public function method($method)
    {
        $this->method = $method === 'call' ? 'call' : 'sms';

        return $this;
    }
}
