<?php

namespace App\Service\Api\Socialite;

use Illuminate\Support\Facades\Auth;

class SocialiteFacebook extends SocialiteService
{

    /**
     * PROVIDER
     */
    const PROVIDER = 'facebook';

    /**
     * __construct()
     */
    public function __construct()
    {
        parent::__construct(self::PROVIDER);
    }

    public function handleCallback(): bool
    {
        $user = $this->handleUser();

        if ($user === false) {
            session()->flash('message', 'There has been an error in validating your Facebook account. Kindly refresh the page and try again.');
            return false;
        }

        Auth::login($user);
        return true;
    }
}
