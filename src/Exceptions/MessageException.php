<?php namespace BulkSmsCenter\Exceptions;

/**
 * Class MessageException
 *
 * @package BulkSmsCenter\Exceptions
 */
class MessageException extends BulkSmsCenterException
{
    const CODE__INVALID_ROUTE = 1000;

    const MESSAGE__INVALID_ROUTE = 'Invalid route';
}
