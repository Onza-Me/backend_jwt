<?php

namespace OnzaMe\JWT\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OnzaMe\JWT\JWT;
use OnzaMe\JWT\RSAKeys;
use OnzaMe\JWT\Services\AccessTokenService;

/**
 * Class Member
 * @package App\Models
 *
 * @property string  $token
 * @property string  $expires_at
 * @property string  $refresh_token
 */
class AccessToken extends Model
{
    protected $appends = [
        'token',
        'expires_at',
        'refresh_token'
    ];

    protected $dates = [
        'expires_at'
    ];

    protected array $payload = [];
    protected array $payloadForRefresh = [];
    protected AccessTokenService $service;

    /**
     * AccessToken constructor.
     * @param array $payload
     */
    public function __construct(array  $payload = [], array $payloadForRefresh = [])
    {
        $this->payload = $payload;
        $this->payloadForRefresh = $payloadForRefresh;
        $this->service = new AccessTokenService(new JWT(), new RSAKeys());
        $this->generateTokens();
    }

    private function generateTokens()
    {
        $createdAt = Carbon::now();
        $expiresAt = Carbon::now()->addSeconds(config('jwt.access_token_expires_in'));
        $refreshExpiresAt = Carbon::now()->addSeconds(config('jwt.refresh_token_expires_in'));

        $this->expires_at = $expiresAt;
        $this->token = $this->service->generate($this->payload, $createdAt, $expiresAt);
        $this->refresh_token = $this->service->generate($this->payloadForRefresh, $createdAt, $refreshExpiresAt);
    }
}
