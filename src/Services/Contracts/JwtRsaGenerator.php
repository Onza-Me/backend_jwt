<?php

namespace OnzaMe\JWT\Services\Contracts;

use OnzaMe\JWT\Contracts\RSAKeys;

/**
 * Generate files with RSA keys  for JWT RS256
 */
interface JwtRsaGenerator
{
    public function generate(): RSAKeys;
}
