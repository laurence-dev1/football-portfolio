<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{

    /**
     * index
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * store
     * @param RegisterRequest $credentials
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function store(RegisterRequest $credentials): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        try {
            $newUser = User::create($credentials->only(['name', 'email', 'username', 'password']));

        } catch (\Exception $exception) {
            return redirect('/register')
                ->withErrors(['name' => 'There has been an error on creating the account. Kindly try again.']);
        }

        Auth::loginUsingId($newUser->id);
        return redirect('/');
    }
}
