<?php

namespace App\Service\Api\Socialite;

use App\Events\UserRegistered;
use App\Models\SocialiteLogin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
     * redirect
     * Redirect to provider
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return $this->socialiteProvider->redirect();
    }

    /**
     * handleCallback
     * @return bool
     */
    public function handleCallback(): bool
    {
        $userFromProvider = $this->socialiteProvider->user();

        $userModel = User::where('email', $userFromProvider->email);

        // user is already existing in db
        if ($userModel->exists() === true) {
            SocialiteLogin::where('provider', self::PROVIDER)
                ->where('user_id', $userModel->first()->id)
                ->where('provider_user_id', $userFromProvider->id)
                ->update([
                    'access_token'  => $userFromProvider->token,
                    'refresh_token' => $userFromProvider->refreshToken
                ]);

            Auth::login($userModel->first());
            return true;
        }

        // user not existing
        try {
            DB::beginTransaction();

            $createdUser = User::create([
                'name'     => $userFromProvider->name,
                'username' => $this->generateUniqueUsername($userFromProvider->name),
                'email'    => $userFromProvider->email
            ]);

            SocialiteLogin::create([
                'user_id'          => $createdUser->id,
                'provider'         => self::PROVIDER,
                'provider_user_id' => $userFromProvider->id,
                'access_token'     => $userFromProvider->token,
                'refresh_token'    => $userFromProvider->refreshToken
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('message', 'There has been an error in recording your account. Kindly refresh the page and try again');
            return false;
        }

        DB::commit();
        UserRegistered::dispatch($createdUser);

        Auth::login($createdUser);
        return true;
    }

    /**
     * generateUniqueUsername
     * Generate the initial username to be saved
     * @param string $name
     * @return string
     */
    private function generateUniqueUsername(string $name): string
    {
        $generatedUsername = preg_replace('/\s+/', '', strtolower($name));
        // append random number string (8) from 10000000 - 99999999
        return $generatedUsername . rand(pow(10, 8 - 1), pow(10, 8) - 1);
    }
}
