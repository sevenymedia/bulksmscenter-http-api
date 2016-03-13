<?php namespace BulkSmsCenter\Exceptions;

/**
 * Class ClientException
 *
 * @package BulkSmsCenter\Exceptions
 */
class ClientException extends BulkSmsCenterException
{
    const CODE__INVALID_API_CODE = 1000;
    const CODE__NO_MESSAGE_SET = 1001;

    const MESSAGE__INVALID_API_CODE = 'Got an invalid API code (%s)';
    const MESSAGE__NO_MESSAGE_SET = 'No message set';
}
