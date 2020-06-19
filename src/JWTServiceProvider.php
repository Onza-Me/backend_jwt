<?php

namespace OnzaMe\JWT;

use Illuminate\Support\ServiceProvider;
use OnzaMe\JWT\Console\PackageCommandsHandler;
use OnzaMe\JWT\Contracts\JWTContract;
use OnzaMe\JWT\Services\AccessTokenService;

class JWTServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'domda_backend_laravel_package_template');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'domda_backend_laravel_package_template');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/jwt.php' => config_path('jwt.php'),
            ], 'config');
            if (config('app.env') === 'testing') {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            }
            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/domda_backend_laravel_package_template'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/domda_backend_laravel_package_template'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/domda_backend_laravel_package_template'),
            ], 'lang');*/

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
    }
}
