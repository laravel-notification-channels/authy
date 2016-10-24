<?php

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
     *
     * @return $this
     */
    public function force()
    {
        $this->force = true;

        return $this;
    }

    /**
     * Indicate that the notification is not forced over cellphone network.
     *
     * @return $this
     */
    public function doNotForce()
    {
        $this->force = false;

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
