<?php namespace BulkSmsCenter\Exceptions;

/**
 * Class HttpClientException
 *
 * @package BulkSmsCenter\Exceptions
 */
class HttpClientException extends BulkSmsCenterException
{
    const CODE__NO_OK_RECEIVED = 1000;

    const MESSAGE__NO_OK_RECEIVED = "Did not receive '200 OK' from %s (received %s)";
}
