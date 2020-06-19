<?php
/**
 * Created by PhpStorm.
 * User: acrossoffwest
 * Date: 9/6/18
 * Time: 10:53 AM
 */

namespace OnzaMe\JWT\Services;

use OnzaMe\JWT\Contracts\JWTContract;
use OnzaMe\JWT\RSAKeys;
use Carbon\Carbon;

/**
 * Class AccessTokenService
 * @package OnzaMe\JWT\Services
 */
class AccessTokenService
{
    protected JWTContract $jwt;
    protected RSAKeys $rsaKeys;

    public function __construct(JWTContract $jwt, RSAKeys $rsaKeys)
    {
        $this->jwt = $jwt;
        $this->rsaKeys = $rsaKeys;
    }

    /**
     * @param array $payload
     * @param Carbon $createdAt
     * @param Carbon $expiresAt
     * @return mixed
     */
    public function generate(array $payload, Carbon $createdAt, Carbon $expiresAt)
    {
        return $this->jwt->encode(array_merge([
            'iat' => $createdAt->timestamp,
            'exp' => $expiresAt->timestamp
        ], $payload), $this->getPrivateKey(), $this->getAlgo());
    }

    private function getPrivateKey(): string
    {
        return $this->rsaKeys->privateKey();
    }

    private function getPublicKey(): string
    {
        return $this->rsaKeys->publicKey();
    }

    private function getAlgo()
    {
        return config('jwt.rsa.algo');
    }

    /**
     * @param string $accessToken
     * @return mixed
     */
    public function decode(string $accessToken)
    {
        return $this->jwt->decode($accessToken, $this->getPublicKey(), [$this->getAlgo()]);
    }

    /**
     * @param string $accessToken
     * @return mixed
     */
    public function isValid(string $accessToken)
    {
        return $this->jwt->isValid($accessToken, $this->getPublicKey(), [$this->getAlgo()]);
    }
}
