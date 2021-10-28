<?php


namespace OnzaMe\JWT\Services;


use Illuminate\Http\Request;
use OnzaMe\JWT\Services\Contracts\AuthUserService as AuthUserServiceContract;

class AuthUserService implements AuthUserServiceContract
{
    protected Request $request;
    protected AccessTokenService $accessTokenService;
    protected string $authorizationHeaderValuePrefix = 'Bearer ';
    protected string $authorizationHeaderFieldname = 'Authorization';

    public function __construct(Request $request, AccessTokenService $accessTokenService)
    {
        $this->request = $request;
        $this->accessTokenService = $accessTokenService;
    }

    public function getAuthorizationToken(): string
    {
        if (!empty($this->authorizationToken)) {
            return $this->authorizationToken;
        }
        return $this->authorizationToken = $this->extractTokenFromHeader();
    }

    private function extractTokenFromHeader(): string
    {
        return str_replace(
            $this->authorizationHeaderValuePrefix,
            '',
            $this->request->header($this->authorizationHeaderFieldname)
        );
    }

    public function isValid(): bool
    {
        if (!empty($this->isTokenValid)) {
            return $this->isTokenValid === 'valid';
        }

        return $this->accessTokenService->isValid($this->getAuthorizationToken());
    }
}
