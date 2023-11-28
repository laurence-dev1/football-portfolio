<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{

    /**
     * index
     * Show Login Page
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * store
     * Login User
     * @return void
     */
    public function store()
    {

    }

    /**
     * destroy
     * Logout user
     * @return void
     */
    public function destroy()
    {

    }
}
