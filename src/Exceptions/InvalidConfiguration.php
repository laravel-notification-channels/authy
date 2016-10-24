<?php

namespace NotificationChannels\Authy\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function missingCredentials()
    {
        return new static('You need to add credentials in the `authy` in `config/services.php`.');
    }
}
