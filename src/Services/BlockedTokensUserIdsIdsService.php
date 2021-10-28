<?php


namespace OnzaMe\JWT\Services;


use Carbon\Carbon;
use OnzaMe\JWT\Models\BlockedTokensUserId;
use OnzaMe\JWT\Services\Contracts\BlockedTokensUserIdsServiceContract;

/**
 * Class BlockedTokensTokensUserIdsIdsService
 * @package OnzaMe\JWT\Services
 */
class BlockedTokensUserIdsIdsService implements BlockedTokensUserIdsServiceContract
{
    public function addUserId(int $userId): void
    {
        $expireAt = Carbon::now()->addSeconds(config('jwt.access_token_expires_in'));

        if ($this->exists($userId)) {
            return;
        }

        BlockedTokensUserId::query()->create([
            'user_id' => $userId,
            'expire_at' => $expireAt
        ]);
    }

    public function deleteUserId(int $userId): void
    {
        BlockedTokensUserId::query()
            ->where('user_id', $userId)
            ->delete();
    }

    public function exists(int $userId): bool
    {
        return BlockedTokensUserId::query()
            ->where('user_id', $userId)
            ->exists();
    }

    public function deleteExpiredIds(): void
    {
        BlockedTokensUserId::query()
            ->where('expire_at', '<=', Carbon::now())
            ->delete();
    }
}
