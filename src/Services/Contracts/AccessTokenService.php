<?php

namespace OnzaMe\JWT\Services\Contracts;

use Carbon\Carbon;

interface AccessTokenService
{
    public function generate(array $payload, Carbon $createdAt, Carbon $expiresAt);
    public function decode(string $accessToken);
    public function isValid(string $accessToken);
}
