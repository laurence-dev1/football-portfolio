<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (QueryException $queryException) {
            if (str_contains($queryException->getMessage(), 'SQLSTATE[HY000] [2002]') === false) {
                return;
            }

            $message = 'Cannot connect to Database.';
            return request()->isXmlHttpRequest() === true
                ? response()->json([
                    'status' => false,
                    'data'   => ['message' => $message]
                ], 500)
                : response()->view('error', ['message' => $message]);
        });
    }
}
