<?php

namespace NotificationChannels\Authy;

class AuthyMessage
{
    /**
     * The notification method (sms/call).
     *
     * @var string
     */
    public $method = 'sms';

    /**
     * Determine whether to force the notification over cellphone network.
     *
     * @var bool
     */
    public $force = false;

    /**
     * The notification message action.
     *
     * @var string
     */
    public $action;

    /**
     * The notification message action message.
     *
     * @var string
     */
    public $actionMessage;

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

    /**
     * Indicate that the notification is forced over cellphone network.
     *
     * @return $this
     */
    public function force()
    {
        $this->force = true;

        return $this;
    }

    /**
     * Set the notification action.
     *
     * @param string $action
     *
     * @return $this
     */
    public function action($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Set the notification action message.
     *
     * @param string $actionMessage
     *
     * @return $this
     */
    public function actionMessage($actionMessage)
    {
        $this->actionMessage = $actionMessage;

        return $this;
    }
}
