<?php


namespace OnzaMe\JWT\Services\Contracts;


use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use OnzaMe\JWT\Services\AccessTokenService;

interface AuthorizationHeaderContract
{
    public function __construct(Request $request, AccessTokenService $accessTokenService);
    public function getAccessToken(): string;
    public function getDecodedToken(): array;
    public function getUser(): User;
    public function isValid(): bool;
    public function isPhoneVerified(): bool;
    public function isEmailVerified(): bool;
}
