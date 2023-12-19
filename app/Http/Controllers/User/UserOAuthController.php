<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\Api\Socialite\SocialiteService;

class UserOAuthController extends Controller
{

    /**
     * @var SocialiteService $socialiteService
     */
    private SocialiteService $socialiteService;

    /**
     * __construct
     * @param SocialiteService $socialiteService
     */
    public function __construct(SocialiteService $socialiteService)
    {
        $this->socialiteService = $socialiteService;
    }

    /**
     * login
     * Go to provider's login page
     * @return mixed
     */
    public function login()
    {
        return $this->socialiteService->redirect();
    }

    /**
     * callback
     * Callback action after successful authentication
     * @return mixed
     */
    public function callback()
    {
        $result = $this->socialiteService->handleCallback();
        return redirect($result['auth'] === true ? '/' : '/register');
    }
}
