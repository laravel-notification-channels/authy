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

namespace NotificationChannels\Authy\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    protected $message = 'In order to send notification via Authy you need to add credentials '.
                         'in the `authy` key of `config/services.php` config file.';
}
