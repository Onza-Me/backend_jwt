<?php

namespace OnzaMe\JWT\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use OnzaMe\JWT\Services\Contracts\BlockedTokensUserIdsServiceContract;

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
        app(BlockedTokensUserIdsServiceContract::class)->deleteExpiredIds();
    }
}
