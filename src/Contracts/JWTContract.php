<?php


namespace OnzaMe\JWT\Contracts;

interface JWTContract
{
    public function encode($token = [], string $key = null, $alg = 'HS256');
    public function decode($jwt, string $key = null, array $algs = ['HS256']);
    public function setLeeway(int $leeway);
}
