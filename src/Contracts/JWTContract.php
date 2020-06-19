<?php


namespace OnzaMe\JWT\Contracts;

interface JWTContract
{
    public function encode(array $token = [], string $key = null, $alg = 'HS256'): string;
    public function decode(string $jwt, string $key = null, array $algs = ['HS256']): array;
    public function isValid(string $jwt, string $key = null, array $algs = ['HS256']): bool;
    public function setLeeway(int $leeway);
}
