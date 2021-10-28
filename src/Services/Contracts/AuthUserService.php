<?php

namespace OnzaMe\JWT\Services\Contracts;

interface AuthUserService
{
    public function getAuthorizationToken();
    public function isValid(): bool;
}
