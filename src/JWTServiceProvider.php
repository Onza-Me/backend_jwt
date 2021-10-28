<?php

namespace OnzaMe\JWT;

use Illuminate\Support\ServiceProvider;
use OnzaMe\JWT\Console\PackageCommandsHandler;
use OnzaMe\JWT\Contracts\JWT as JWTContract;
use OnzaMe\JWT\Contracts\RSAKeys as RSAKeysContract;
use OnzaMe\JWT\Services\AccessTokenService;
use OnzaMe\JWT\Services\AuthorizationHeaderService;
use OnzaMe\JWT\Services\AuthUserService;
use OnzaMe\JWT\Services\BlockedTokensTokensUserIdsIdsService;
use OnzaMe\JWT\Services\BlockedTokensUserIdsIdsService;
use OnzaMe\JWT\Services\Contracts\AccessTokenService as AccessTokenServiceContract;
use OnzaMe\JWT\Services\Contracts\AuthorizationHeaderContract;
use OnzaMe\JWT\Services\Contracts\AuthUserService as AuthUserServiceContract;
use OnzaMe\JWT\Services\Contracts\BlockedTokensUserIdsServiceContract;
use OnzaMe\JWT\Services\Contracts\FileSaver;
use OnzaMe\JWT\Services\Contracts\JwtRsaGenerator;
use OnzaMe\JWT\Services\FileSaverService;
use OnzaMe\JWT\Services\JwtRsaFileGenerateService;

class JWTServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/jwt.php' => config_path('jwt.php'),
            ], 'config');
            if (config('app.env') === 'testing') {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            }

            // Registering package commands.
            $this->commands((new PackageCommandsHandler())->getCommands());
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/jwt.php', 'jwt');

        // Register the main class to use with the facade
        $this->app->bind('jwt', JWT::class);

        $this->app->bind(JWTContract::class, 'jwt');
        $this->app->bind(RSAKeysContract::class, RSAKeys::class);
        $this->app->bind(AccessTokenServiceContract::class, AccessTokenService::class);
        $this->app->bind(AuthorizationHeaderContract::class, AuthorizationHeaderService::class);
        $this->app->bind(AuthUserServiceContract::class, AuthUserService::class);
        $this->app->bind(BlockedTokensUserIdsServiceContract::class, BlockedTokensUserIdsIdsService::class);
        $this->app->bind(JwtRsaGenerator::class, JwtRsaFileGenerateService::class);
        $this->app->bind(FileSaver::class, FileSaverService::class);
    }
}
