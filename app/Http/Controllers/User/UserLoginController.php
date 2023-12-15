<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserLoginController extends Controller
{

    /**
     * index
     * Show Login Page
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('User/Login');
    }

    /**
     * store
     * Login User
     * @param UserLoginRequest $credentials
     * @return RedirectResponse
     */
    public function store(UserLoginRequest $credentials): RedirectResponse
    {
        if (Auth::attempt($credentials->only(['username', 'password'])) === true) {
            request()->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.'
        ]);
    }

    /**
     * destroy
     * Logout user
     * @return Application|Redirector|\Illuminate\Foundation\Application|RedirectResponse
     */
    public function destroy(): Application|RedirectResponse|Redirector|\Illuminate\Foundation\Application
    {
        Auth::logout();

        request()->session()->invalidate();
        
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
