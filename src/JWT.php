<?php

namespace OnzaMe\JWT;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT as FirebaseJWT;
use OnzaMe\JWT\Contracts\JWTContract;

/**
 * Class JWT
 * @package OnzaMe\JWT
 */
class JWT implements JWTContract
{
    protected string $secret = '';

    /**
     * @param string|null $key
     * @return string
     */
    private function getSecret(string $key = null): string
    {
        if (!is_null($key)) {
            return $key;
        }
        if (!empty($this->secret)) {
            return $this->secret;
        }
        return $this->secret = config('jwt.secret');
    }

    public function encode(array $token = [], string $key = null, $alg = 'HS256'): string
    {
        return FirebaseJWT::encode($token, $this->getSecret($key), $alg);
    }

    /**
     * @param string $jwt
     * @param string|null $key
     * @param array|string[] $algs
     * @return array|null
     */
    public function decode(string $jwt, string $key = null, array $algs = ['HS256']): array
    {
        return (array) FirebaseJWT::decode($jwt, $this->getSecret($key), $algs);
    }

    public function isValid(string $jwt, string $key = null, array $algs = ['HS256']): bool
    {
        try {
            $this->decode($jwt, $key, $algs);
        } catch (\Exception $ex) {
            return false;
        }
        return true;
    }

    public function setLeeway(int $leeway)
    {
        FirebaseJWT::$leeway = $leeway;
    }
}
