<?php


namespace OnzaMe\JWT\Http\MIddleware\Contracts;


interface JWTAuthContract
{
    public function handle($request, \Closure $next);
}
