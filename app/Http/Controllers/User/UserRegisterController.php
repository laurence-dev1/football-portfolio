<?php

namespace App\Http\Controllers\User;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserRegisterController extends Controller
{

    /**
     * index
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('User/Register');
    }

    /**
     * store
     * @param UserRegisterRequest $credentials
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function store(UserRegisterRequest $credentials): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        try {
            $newUser = User::create($credentials->only(['name', 'email', 'username', 'password']));

        } catch (\Exception $exception) {
            return redirect('/register')
                ->withErrors(['name' => 'There has been an error on creating the account. Kindly try again.']);
        }

        UserRegistered::dispatch($newUser);

        Auth::loginUsingId($newUser->id);
        return redirect('/');
    }
}
