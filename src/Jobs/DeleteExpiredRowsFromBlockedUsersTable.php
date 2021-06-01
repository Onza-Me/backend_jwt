<?php

namespace OnzaMe\JWT\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OnzaMe\JWT\Models\BlockedTokensUserId;
use OnzaMe\JWT\Services\BlockedTokensTokensUserIdsIdsService;

class DeleteExpiredRowsFromBlockedUsersTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app(BlockedTokensTokensUserIdsIdsService::class)->deleteExpiredIds();
    }
}
