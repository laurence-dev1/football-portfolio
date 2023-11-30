<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{

    /**
     * index
     * Show Login Page
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * store
     * Login User
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $credentials = request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        if (Auth::attempt($credentials) === true) {
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

        return redirect('/login');
    }
}
