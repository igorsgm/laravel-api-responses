<?php

namespace Igorsgm\LaravelApiResponses;

use Illuminate\Support\ServiceProvider;

class LaravelApiResponsesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-api-responses.php' => config_path('laravel-api-responses.php'),
            ], 'config');

            if (!file_exists(base_path('_ide_helper_macros.php'))) {
                // Publishing ide helper file.
                $this->publishes([
                    __DIR__.'/../_ide_helper_macros.php.stub' => base_path('_ide_helper_macros.php'),
                ]);

                // Adding _ide_helper_macros.php file to .gitignore
                $gitignoreFile = base_path('.gitignore');
                file_put_contents($gitignoreFile, file_get_contents($gitignoreFile) . "\n_ide_helper_macros.php");
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-api-responses.php', 'laravel-api-responses');

        // Register the response Macros
        $this->app->make(LaravelApiResponses::class);
    }
}
