<?php

namespace Alfa6661\Firebase\Exceptions;

class CouldNotSendNotification extends \Exception
{
    /**
     * Create service exception.
     *
     * @param $response
     * @return static
     */
    public static function serviceRespondedWithAnError($response)
    {
        return new static('Descriptive error message.');
    }
}
