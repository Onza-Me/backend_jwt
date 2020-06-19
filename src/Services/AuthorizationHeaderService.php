<?php


namespace OnzaMe\JWT\Services;


use Illuminate\Http\Request;

class AuthorizationHeaderService
{
    protected Request $request;
    protected string $authorizationToken = '';
    protected string $authorizationHeaderFieldname = 'Authorization';
    protected string $authorizationHeaderValuePrefix = 'Bearer ';
    protected string $isTokenValid = '';
    protected AccessTokenService $accessTokenService;

    public function __construct(Request $request, AccessTokenService $accessTokenService)
    {
        $this->request = $request;
        $this->accessTokenService = $accessTokenService;
    }

    public function getAuthorizationToken()
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

    public function isValid()
    {
        if (!empty($this->isTokenValid)) {
            return $this->isTokenValid === 'valid';
        }

        return $this->accessTokenService->isValid($this->getAuthorizationToken());
    }
}
