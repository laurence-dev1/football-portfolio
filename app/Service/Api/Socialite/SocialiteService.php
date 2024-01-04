<?php

namespace App\Service\Api\Socialite;

use App\Events\UserRegistered;
use App\Models\SocialiteLogin;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class SocialiteService
{

    /**
     * @var string $provider
     */
    protected string $provider;

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
        $this->provider = $provider;
        $this->socialiteProvider = Socialite::driver($provider);
    }

    /**
     * redirectToProvider
     * Redirect to provider's page
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return $this->socialiteProvider->redirect();
    }

    /**
     * handleCallback
     * Handle callback from provider
     * @return bool
     */
    public abstract function handleCallback(): bool;

    /**
     * handleUser
     * Process oauth user
     * @return User|bool
     */
    protected function handleUser(): User|bool
    {
        $userFromProvider = $this->socialiteProvider->user();
        $userModel = User::where('email', $userFromProvider->email);

        if ($userModel->exists() === true) {
            return $this->processExistingUser($userModel) === true
                ? $userModel->first()
                : false;
        }

        return $this->processNewUser();
    }

    /**
     * processExistingUser
     * DB Process for existing oauth users
     * @param Builder $userModel
     * @return bool
     */
    protected function processExistingUser(Builder $userModel): bool
    {
        $userFromProvider = $this->socialiteProvider->user();

        try {
            DB::beginTransaction();

            SocialiteLogin::where('provider', $this->provider)
                ->where('user_id', $userModel->first()->id)
                ->where('provider_user_id', $userFromProvider->id)
                ->update([
                    'access_token'  => $userFromProvider->token,
                    'refresh_token' => $userFromProvider->refreshToken
                ]);

            // update (if any)
            $userModel->update([
                'name'  => $userFromProvider->name,
                'email' => $userFromProvider->email
            ]);

        } catch (Exception $exception) {

            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * processNewUser
     * DB Process for new oauth users
     * @return User|bool
     */
    protected function processNewUser(): User|bool
    {
        $userFromProvider = $this->socialiteProvider->user();

        try {
            DB::beginTransaction();

            $createdUser = User::create([
                'name'     => $userFromProvider->name,
                'username' => $this->generateUniqueUsername($userFromProvider->name),
                'email'    => $userFromProvider->email
            ]);

            SocialiteLogin::create([
                'user_id'          => $createdUser->id,
                'provider'         => $this->provider,
                'provider_user_id' => $userFromProvider->id,
                'access_token'     => $userFromProvider->token,
                'refresh_token'    => $userFromProvider->refreshToken
            ]);

        } catch (Exception $exception) {

            DB::rollBack();
            return false;
        }

        DB::commit();

        UserRegistered::dispatch($createdUser);
        return $createdUser;
    }

    /**
     * generateUniqueUsername
     * Generate the initial username to be saved
     * @param string $name
     * @return string
     */
    protected function generateUniqueUsername(string $name): string
    {
        $generatedUsername = preg_replace('/\s+/', '', strtolower($name));
        return $generatedUsername . rand(10000000, 99999999); // append random generated 8x integer
    }
}
