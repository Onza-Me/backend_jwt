<?php

namespace OnzaMe\JWT;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OnzaMe\JWT\Skeleton\SkeletonClass
 */
class JWTFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'domda_backend_laravel_package_template';
    }
}
