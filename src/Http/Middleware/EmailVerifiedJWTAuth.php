<?php

namespace OnzaMe\JWT\Http\Middleware;

class EmailVerifiedJWTAuth extends AbstractJWTAuth
{
    public function isValid(): bool
    {
        return $this->service->isValid() && $this->service->isEmailVerified();
    }
}
