<?php

namespace App\Providers;

use App\Http\Controllers\User\UserOAuthController;
use App\Models\User;
use App\Service\Api\Socialite\SocialiteGoogle;
use App\Service\Api\Socialite\SocialiteService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        App::when(UserOAuthController::class)
            ->needs(SocialiteService::class)
            ->give(function () {
                $requestedProvider = request()->route('provider');
                $availableProviders = [
                    'google' => new SocialiteGoogle()
                ];

                if (array_key_exists($requestedProvider, $availableProviders) === true) {
                    return $availableProviders[$requestedProvider];
                }

                abort(404);
            });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
