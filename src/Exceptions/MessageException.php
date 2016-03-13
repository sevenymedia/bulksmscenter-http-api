<?php namespace BulkSmsCenter\Exceptions;

/**
 * Class MessageException
 *
 * @package BulkSmsCenter\Exceptions
 */
class MessageException extends BulkSmsCenterException
{
    const CODE__INVALID_API_CODE = 1000;
    const CODE__INVALID_ROUTE = 1001;

    const MESSAGE__INVALID_API_CODE = ClientException::MESSAGE__INVALID_API_CODE;
    const MESSAGE__INVALID_ROUTE = 'Invalid route';
}
