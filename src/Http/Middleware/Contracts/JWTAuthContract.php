<?php


namespace OnzaMe\JWT\Http\Middleware\Contracts;


interface JWTAuthContract
{
    public function handle($request, \Closure $next);
}
