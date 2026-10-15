<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /* handle an incoming request. @param \illuminate\http\request $request @param \closure(\illuminate\http\request): (\illuminate\http\response|\illuminate\http\redirectresponse) $next @param string|null ...$guards @return \illuminate\http\response|\illuminate\http\redirectresponse */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
