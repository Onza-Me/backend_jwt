<?php
namespace OnzaMe\JWT\Services;

use phpseclib\Crypt\RSA;
use OnzaMe\JWT\RSAKeysWithoutFile;
use OnzaMe\JWT\Contracts\RSAKeys;
use OnzaMe\JWT\Services\Contracts\JwtRsaGenerator;

/**
 *
 */
class JwtRsaGenerateService implements JwtRsaGenerator
{
    protected array $configs;

    public function __construct()
    {
        $this->configs = config('jwt.rsa');
    }

    public function generate(): RSAKeys
    {
        $keySize = $this->configs['key_size'];

        $rsa = new RSA();

         [
             'privatekey' => $privateKey,
             'publickey' => $publicKey
         ] = $rsa->createKey($keySize);

        return new RSAKeysWithoutFile($publicKey, $privateKey);
    }
}
