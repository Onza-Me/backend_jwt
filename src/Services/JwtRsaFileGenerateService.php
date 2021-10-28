<?php
namespace OnzaMe\JWT\Services;

use OnzaMe\JWT\Contracts\RSAKeys;
use OnzaMe\JWT\Services\Contracts\FileSaver;
use OnzaMe\JWT\Services\Contracts\JwtRsaGenerator;

/**
 *
 */
class JwtRsaFileGenerateService implements JwtRsaGenerator
{
    protected JwtRsaGenerator $jwtRsaGenerator;
    protected FileSaver $fileSaver;
    protected array $configs;

    /**
     * @param FileSaver $fileSaver
     */
    public function __construct(JwtRsaGenerateService $jwtRsaGenerator, FileSaver $fileSaver)
    {
        $this->jwtRsaGenerator = $jwtRsaGenerator;
        $this->fileSaver = $fileSaver;
        $this->configs = config('jwt.rsa');
    }

    public function generate(): RSAKeys
    {
        $path = $this->configs['path'];

        $rsaKeys = $this->jwtRsaGenerator->generate();

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $this->fileSaver
            ->save(
                $path.'/'.$this->configs['private_filename'],
                $rsaKeys->privateKey()
            );
        $this->fileSaver
            ->save(
                $path.'/'.$this->configs['public_filename'],
                $rsaKeys->publicKey()
            );

        return $rsaKeys;
    }
}
