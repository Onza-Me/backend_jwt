<?php


namespace OnzaMe\JWT\Exceptions;

use Exception;
use Throwable;

class BackendAuthModelsNoInstalledException extends Exception
{
    public function __construct($message = 'Please load package `onza-me/backend_auth_models` for using this method.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
