<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\Api\Socialite\SocialiteService;
use Illuminate\Http\RedirectResponse;

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
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(): RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
    {
        return $this->socialiteService->redirectToProvider();
    }

    /**
     * callback
     * Callback action after successful authentication
     * @return RedirectResponse
     */
    public function callback(): RedirectResponse
    {
        return redirect($this->socialiteService->handleCallback() === true ? '/' : '/register');
    }
}
