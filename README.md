# Authy Notification Channel for Laravel

[Authy](https://www.authy.com) notification channel for [Laravel](https://laravel.com), with the ability to send in-app, sms, and call verification tokens.

[![Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/authy.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/laravel-notification-channels/authy)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/laravel-notification-channels/authy.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/authy/)
[![StyleCI](https://styleci.io/repos/70840210/shield?branch=master)](https://styleci.io/repos/70840210)
[![Travis](https://img.shields.io/travis/laravel-notification-channels/authy.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/authy)
[![License](https://img.shields.io/packagist/l/laravel-notification-channels/authy.svg?label=License&style=flat-square)](https://github.com/laravel-notification-channels/authy/blob/develop/LICENSE)

![Authy Notifications](https://rinvex.com/assets/frontend/layout/img/products/laravel-notification-channels-authy.png "Authy Notification")


## Table Of Contents

- [Usage](#usage)
- [Upgrade](#upgrade)
- [Changelog](#changelog)
- [Support](#support)
- [Contributing & Protocols](#contributing--protocols)
- [Security Vulnerabilities](#security-vulnerabilities)
- [About Rinvex](#about-rinvex)
- [Trademarks](#trademarks)
- [License](#license)


## Usage

1. Install the package via composer:
    ```shell
    composer require laravel-notification-channels/authy
    ```

2. This package requires [`rinvex/laravel-authy`](https://github.com/rinvex/laravel-authy) package, so before proceeding make sure to follow up its [installation](https://github.com/rinvex/laravel-authy#installation) steps first.

3. Next, to route Authy notifications to the proper entity, define a `routeNotificationForAuthy` method on your notifiable entity. This should return the **Authy Id** to which the notification should be sent. Example:

    ```php
    /**
     * Route notifications for the authy channel.
     *
     * @return int
     */
    public function routeNotificationForAuthy()
    {
        return $this->authy_id;
    }
    ```

    > **Note:** as you might thought, this requires an `authy_id` attribute in your notifiable entity, for which you may need to create an additional field in the database table.

4. Now you can create notifications that use Authy channel as follows:

    ```php
    // app/Notifications/PhoneVerificationNotification.php

    namespace App\Notifications;

    use Illuminate\Notifications\Notification;
    use NotificationChannels\Authy\AuthyChannel;
    use NotificationChannels\Authy\AuthyMessage;

    class PhoneVerificationNotification extends Notification
    {
        /**
         * The notification method (sms/call).
         *
         * @var string
         */
        public $method;

        /**
         * Determine whether to force the notification over cellphone network.
         *
         * @var bool
         */
        public $force;

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
         * Create a notification instance.
         *
         * @param string $method
         * @param bool   $force
         * @param string $action
         * @param string $actionMessage
         *
         * @return void
         */
        public function __construct($method = 'sms', $force = false, $action = null, $actionMessage = null)
        {
            $this->method = $method;
            $this->force = $force;
            $this->action = $action;
            $this->actionMessage = $actionMessage;
        }

        /**
         * Get the notification's channels.
         *
         * @param mixed $notifiable
         *
         * @return array|string
         */
        public function via($notifiable)
        {
            return [AuthyChannel::class];
        }

        /**
         * Build the Authy representation of the notification.
         *
         * @return \NotificationChannels\Authy\AuthyMessage
         */
        public function toAuthy()
        {
            $message = AuthyMessage::create()->method($this->method);

            if ($this->force) {
                $message->force();
            }

            if ($this->action) {
                $message->action($action);
            }

            if ($this->actionMessage) {
                $message->actionMessage($actionMessage);
            }

            return $message;
        }
    }
    ```

5. Finally you can consume the notification as follows:

    ```php
    $this->notify(new \App\Notifications\PhoneVerificationNotification('sms', true));
    ```

    > **Note:** don't forget to read through [Authy TOTP API](https://docs.authy.com/totp.html) documentation for further information.

6. Done!


## Upgrade

- **Upgrading To `v2.x` From `v1.x`**

  API implementation is 100% backward compatible, but sandbox API has been dropped since it's officially deprecated. Also note that PHP7 is now required.


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](https://bit.ly/rinvex-slack)
- [Help on Email](mailto:help@rinvex.com)
- [Follow on Twitter](https://twitter.com/rinvex)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [security@rinvex.com](security@rinvex.com). All security vulnerabilities will be promptly addressed.


## About Rinvex

Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That’s how we do our share of advancing humanity.


## Trademarks

- [Authy™](https://www.authy.com) is a trademark of [Twilio Inc.](https://www.twilio.com)
- [Laravel™](https://laravel.com) is a trademark of [TAYLOR OTWELL](http://taylorotwell.com)


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2016-2017 Rinvex LLC, Some rights reserved.
