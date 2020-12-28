<?php


namespace OnzaMe\JWT\Services;


use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use OnzaMe\JWT\Exceptions\AuthTokenInvalidException;
use OnzaMe\JWT\Exceptions\InvalidDataInTokenException;
use OnzaMe\JWT\Services\Contracts\AuthorizationHeaderContract;

class AuthorizationHeaderService implements AuthorizationHeaderContract
{
    protected Request $request;
    protected string $authorizationToken = '';
    protected string $authorizationHeaderFieldname = 'Authorization';
    protected string $authorizationHeaderValuePrefix = 'Bearer ';
    protected string $isTokenValid = '';
    protected AccessTokenService $accessTokenService;
    protected array $decodedToken = [];

    public function __construct(Request $request, AccessTokenService $accessTokenService)
    {
        $this->request = $request;
        $this->accessTokenService = $accessTokenService;
    }

    public function getAccessToken(): string
    {
        if (!empty($this->authorizationToken)) {
            return $this->authorizationToken;
        }
        return $this->authorizationToken = $this->extractTokenFromHeader();
    }

    /**
     * @return array
     * @throws InvalidDataInTokenException
     * @throws AuthTokenInvalidException
     */
    public function getDecodedToken(): array
    {
        if (!$this->isValid()) {
            throw new AuthTokenInvalidException();
        }

        return $this->decodedToken;
    }

    /**
     * @return User
     * @throws AuthTokenInvalidException
     * @throws InvalidDataInTokenException
     */
    public function getUser(): User
    {
        $decodedToken = $this->getDecodedToken();
        $userClass = config('jwt.user_class');
        $user = new $userClass();

        $user->id = $decodedToken['user']['id'];
        $user->role = $decodedToken['user']['role'];
        $user->exists = true;

        return $user;
    }

    /**
     * @return string
     */
    private function extractTokenFromHeader(): string
    {
        return str_replace(
            $this->authorizationHeaderValuePrefix,
            '',
            $this->request->header($this->authorizationHeaderFieldname)
        );
    }

    /**
     * @return bool
     * @throws InvalidDataInTokenException
     */
    public function isValid(): bool
    {
        if (!empty($this->isTokenValid)) {
            return $this->isTokenValid === 'valid';
        }

        try {
            $this->decodedToken = $this->accessTokenService->decode($this->getAccessToken());

            if (empty($this->decodedToken['user'])) {
                throw new InvalidDataInTokenException();
            }
            $this->isTokenValid = 'valid';
        } catch (InvalidDataInTokenException $e) {
            throw $e;
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function isPhoneVerified(): bool
    {
        $decodedToken = $this->getDecodedToken();
        return isset($decodedToken['user']['phone_verified']) && $decodedToken['user']['phone_verified'] === true;
    }

    public function isEmailVerified(): bool
    {
        $decodedToken = $this->getDecodedToken();
        return isset($decodedToken['user']['email_verified']) && $decodedToken['user']['email_verified'] === true;
    }
}
