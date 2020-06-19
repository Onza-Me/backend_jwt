<?php


namespace OnzaMe\JWT\Exceptions;

use Exception;
use Throwable;

class AuthTokenInvalidException extends Exception
{
    public function __construct($message = 'Authorization token is invalid.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
