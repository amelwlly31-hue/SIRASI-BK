<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /* the uris that should be excluded from csrf verification. @var array<int, string> */
    protected $except = [

    ];
}
