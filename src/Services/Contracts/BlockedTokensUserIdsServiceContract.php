<?php


namespace OnzaMe\JWT\Services\Contracts;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;

interface BlockedTokensUserIdsServiceContract
{
    public function addUserId(int $userId): void;
    public function deleteUserId(int $userId): void;
    public function exists(int $userId): bool;
    public function deleteExpiredIds(): void;
}
