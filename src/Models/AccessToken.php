<?php

namespace OnzaMe\JWT\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OnzaMe\JWT\Services\Contracts\AccessTokenService;

/**
 * Class Member
 * @package App\Models
 *
 * @property string  $role
 * @property string  $token
 * @property string  $expires_at
 * @property string  $refresh_token
 */
class AccessToken extends Model
{
    protected $appends = [
        'role',
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
     * @param array $payloadForRefresh
     */
    public function __construct(array  $payload = [], array $payloadForRefresh = [])
    {
        $this->payload = $payload;
        $this->role = !empty($payload['user']) && !empty($payload['user']['role']) ? $payload['user']['role'] : null;
        $this->payloadForRefresh = $payloadForRefresh;
        $this->service = app(AccessTokenService::class);
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
