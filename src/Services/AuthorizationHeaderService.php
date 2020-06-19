<?php


namespace OnzaMe\JWT\Services;


use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use OnzaMe\JWT\Exceptions\AuthTokenInvalidException;
use OnzaMe\JWT\Exceptions\BackendAuthModelsNoInstalledException;
use OnzaMe\JWT\Exceptions\InvalidDataInTokenException;

class AuthorizationHeaderService
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

    public function getAccessToken()
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

        $user->id = $decodedToken['user']->id;
        $user->role = $decodedToken['user']->role;
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
    public function isValid()
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
}
