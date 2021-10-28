<?php

namespace OnzaMe\JWT\Contracts;

interface RSAKeys
{
    public function privateKey(): string;
    public function publicKey(): string;
}
