<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /* a list of exception types with their corresponding custom log levels. @var array<class-string<\throwable>, \psr\log\loglevel::*> */
    protected $levels = [

    ];

    /* a list of the exception types that are not reported. @var array<int, class-string<\throwable>> */
    protected $dontReport = [

    ];

    /* a list of the inputs that are never flashed to the session on validation exceptions. @var array<int, string> */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /* register the exception handling callbacks for the application. @return void */
    public function register()
    {
        $this->reportable(function (Throwable $e) {

        });
    }
}
