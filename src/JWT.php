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
     * JWT constructor.
     */
    public function __construct()
    {
        $this->getSecret();
    }

    /**
     * @return string
     */
    private function getSecret(): string
    {
        if (!empty($this->secret)) {
            return $this->secret;
        }
        return $this->secret = config('jwt.secret');
    }

    public function encode($token = [], string $key = null, $alg = 'HS256')
    {
        $key = $key ?? $this->getSecret();

        return FirebaseJWT::encode($token, $key, $alg);
    }

    public function decode($jwt, string $key = null, array $algs = ['HS256'])
    {
        $key = $key ?? $this->getSecret();
        $tokenArray = null;

        try {
            $tokenArray = (array) FirebaseJWT::decode($jwt, $key, $algs);
        } catch (ExpiredException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            if ($ex->getMessage() != 'Algorithm not allowed') {
                logs()->error($ex->getMessage());
            }
        }

        return $tokenArray;
    }

    public function isValid(string $token, $key = null, $algs = ['HS256']): bool
    {
        try {
            $this->decode($token, $key, $algs);
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
