<?php

namespace OnzaMe\JWT;

/**
 * Class RSAKeys
 * @package namespace OnzaMe\JWT;
 */
class RSAKeys
{
    protected string $path = '';
    protected string $privateKeyFilename = '';
    protected string $publicKeyFilename = '';

    /**
     * RSAKeys constructor.
     * @param string|null $path
     * @param string|null $publicKeyFilename
     * @param string|null $privateKeyFilename
     */
    public function __construct(string $path = null, string $publicKeyFilename = null, string $privateKeyFilename = null)
    {
        $config = config('jwt.rsa');

        $this->path = $path ?? $config['path'];
        $this->privateKeyFilename = $privateKeyFilename ?? $config['private_filename'];
        $this->publicKeyFilename = $publicKeyFilename ?? $config['public_filename'];
    }

    public function privateKey(): string
    {
        return file_get_contents($this->path.'/'.$this->privateKeyFilename);
    }

    public function publicKey(): string
    {
        return file_get_contents($this->path.'/'.$this->publicKeyFilename);
    }
}
