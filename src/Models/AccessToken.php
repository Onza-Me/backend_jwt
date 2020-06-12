<?php

namespace OnzaMe\JWT\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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
    protected AccessTokenService $service;

    /**
     * AccessToken constructor.
     * @param array $payload
     */
    public function __construct(array  $payload = [])
    {
        $this->payload = $payload;
        $this->service = app(AccessTokenService::class);
        $this->generateTokens();
    }

    private function generateTokens()
    {
        $createdAt = Carbon::now();
        $expiresAt = Carbon::now()->addSeconds(config('jwt.access_token_expires_in'));
        $refreshExpiresAt = Carbon::now()->addSeconds(config('jwt.refresh_token_expires_in'));

        $this->expires_at = $expiresAt;
        $this->token = $this->service->generateAccessToken($this->payload, $createdAt, $expiresAt);
        $this->refresh_token = $this->service->generateAccessToken($this->payload, $createdAt, $refreshExpiresAt);
    }
}
