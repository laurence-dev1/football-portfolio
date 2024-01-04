<?php

namespace App\Service\Api\Socialite;

use Illuminate\Support\Facades\Auth;

class SocialiteGoogle extends SocialiteService
{

    /**
     * PROVIDER
     */
    const PROVIDER = 'google';

    /**
     * __construct()
     */
    public function __construct()
    {
        parent::__construct(self::PROVIDER);
    }

    /**
     * handleCallback
     * @return bool
     */
    public function handleCallback(): bool
    {
        $user = $this->handleUser();

        if ($user === false) {
            session()->flash('message', 'There has been an error in validating your Google account. Kindly refresh the page and try again.');
            return false;
        }

        Auth::login($user);
        return true;
    }
}
