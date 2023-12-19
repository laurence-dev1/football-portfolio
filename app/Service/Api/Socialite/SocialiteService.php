<?php

namespace App\Service\Api\Socialite;

use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class SocialiteService
{

    /**
     * @var Provider $socialiteProvider
     */
    protected Provider $socialiteProvider;

    /**
     * __construct
     * @param string $provider
     */
    public function __construct(string $provider)
    {
        $this->socialiteProvider = Socialite::driver($provider);
    }

    /**
     * redirect
     * Redirect to provider's page
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public abstract function redirect(): RedirectResponse|\Illuminate\Http\RedirectResponse;


    /**
     * handleCallback
     * Handle callback from provider
     * @return array
     */
    public abstract function handleCallback(): array;
}
