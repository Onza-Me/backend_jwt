<?php

namespace OnzaMe\JWT\Http\Middleware;

class JWTAuth extends AbstractJWTAuth
{
   public function isValid(): bool
   {
       return $this->service->isValid();
   }
}
