<?php

namespace App\Providers;

use App\Services\EnvironmentVariables;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load the EnvironmentVariables class globally
        $this->app->bind(EnvironmentVariables::class, function () {
            return new EnvironmentVariables();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
