<?php

namespace Ophportunidades\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class IdException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} must be a valid ID',
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} must not be a valid ID',
        )
    );
}
