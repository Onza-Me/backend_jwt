<?php

namespace OnzaMe\JWT;

use Illuminate\Support\Facades\Facade;

class JWTFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jwt';
    }
}
