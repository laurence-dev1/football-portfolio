<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VercelStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // production-env is being served by Vercel (Serverless)
        // Vercel only allows writing on /tmp directory
        if (config('app.env') === 'production') {
            $this->app->useStoragePath('/tmp');
        }
    }
}
