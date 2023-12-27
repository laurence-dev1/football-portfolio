<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NotThirdPartyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::user()->isThirdPartyUser() === true) {
            $message = 'Action is not available for Third-Party Users (e.g. users who signed in via Google, Facebook etc.)';
            if ($request->ajax() === true) {
                return response()->json([
                    'status' => false,
                    'data'   => ['message' => $message]
                ], 402);
            }

            return redirect($request->headers->get('referer'), 303)
                ->withErrors(['exception' => $message]);
        }

        return $next($request);
    }
}
