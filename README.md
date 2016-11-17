# Authy Notification Channel for Laravel

@Authy notification channel for @Laravel, with the ability to send in-app, sms, and call verification tokens.

![Authy Notifications](https://rinvex.com/assets/frontend/layout/img/products/laravel-notification-channels-authy.png "Authy Notification")

[![Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/authy.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/laravel-notification-channels/authy)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/laravel-notification-channels/authy.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/authy/)
[![Code Climate](https://img.shields.io/codeclimate/github/laravel-notification-channels/authy.svg?label=CodeClimate&style=flat-square)](https://codeclimate.com/github/laravel-notification-channels/authy)
[![StyleCI](https://styleci.io/repos/70840210/shield?branch=master)](https://styleci.io/repos/70840210)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/9fb954b8-d059-4198-bab9-8f8acb09ae4a.svg?label=SensioLabs&style=flat-square)](https://insight.sensiolabs.com/projects/9fb954b8-d059-4198-bab9-8f8acb09ae4a)
[![Travis](https://img.shields.io/travis/laravel-notification-channels/authy.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/authy)
[![License](https://img.shields.io/packagist/l/laravel-notification-channels/authy.svg?label=License&style=flat-square)](https://github.com/laravel-notification-channels/authy/blob/develop/LICENSE)


## Table Of Contents

- [Usage](#usage)
- [Changelog](#changelog)
- [Support](#support)
- [Contributing & Protocols](#contributing--protocols)
- [Security Vulnerabilities](#security-vulnerabilities)
- [About Rinvex](#about-rinvex)
- [License](#license)

![Authy Notifications](https://rinvex.com/assets/frontend/layout/img/products/laravel-notification-channels-authy.png "Authy Notification")


## Usage

1. Install the package via composer:
    ```shell
    composer require laravel-notification-channels/authy
    ```

2. If you don't have the following lines already, add it to your `config/services.php` file, before the end of the array:

    ```php
    'authy' => [
        'mode' => env('AUTHY_MODE'),
        'keys' => [
            'production' => env('AUTHY_PRODUCTION_KEY'),
            'sandbox' => env('AUTHY_SANDBOX_KEY'),
        ],
    ],
    ```

3. If you haven't already: Register an [Authy](https://www.authy.com) account -> Sign in -> Access [dashboard](https://dashboard.authy.com) -> Create new application -> Copy your API keys (you've two keys, one for production & another for testing/sandbox)

4. If you don't have the following lines already, add it to your project's `.env` file, at the end:

    ```ini
    AUTHY_MODE=production
    AUTHY_PRODUCTION_KEY=AuthyProductionKeyHere
    AUTHY_SANDBOX_KEY=AuthySandboxKeyHere
    ```

    > **Note:** make sure to replace `AuthyProductionKeyHere` & `AuthySandboxKeyHere` with your keys from the previous step.

5. To route Authy notifications to the proper entity, define a `routeNotificationForAuthy` method on your notifiable entity. This should return the **Authy Id** to which the notification should be sent. Example:

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

6. Now you can create notifications that use Authy channel as follows:

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

7. Finally you can consume the notification as follows:

    ```php
    $this->notify(new \App\Notifications\PhoneVerificationNotification('sms', true));
    ```

    > **Note:** don't forget to read through [Authy TOTP API](https://docs.authy.com/totp.html) documentation for further information.

8. Done!


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](http://chat.rinvex.com)
- [Help on Email](mailto:help@rinvex.com)
- [Follow on Twitter](https://twitter.com/rinvex)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to help@rinvex.com. All security vulnerabilities will be promptly addressed.


## About Rinvex

Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That’s how we do our share of advancing humanity.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2016 Rinvex LLC, Some rights reserved.
