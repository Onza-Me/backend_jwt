<?php

namespace OnzaMe\JWT\Http\Middleware;

class PhoneVerifiedJWTAuth extends AbstractJWTAuth
{
    public function isValid(): bool
    {
        return $this->service->isValid() && $this->service->isPhoneVerified();
    }
}
