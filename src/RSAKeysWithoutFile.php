<?php

namespace OnzaMe\JWT;

use OnzaMe\JWT\Contracts\RSAKeys as RSAKeysContract;

/**
 * Class RSAKeys
 * @package namespace OnzaMe\JWT;
 */
class RSAKeysWithoutFile implements RSAKeysContract
{
    protected string $publicKey;
    protected string $privateKey;

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    public function privateKey(): string
    {
        return $this->privateKey;
    }

    public function publicKey(): string
    {
        return $this->publicKey;
    }
}
