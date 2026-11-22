<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string[]  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (empty($roles) || $user->hasRole(...$roles)) {
            return $next($request);
        }

        if ($request->is('penjadwalan') || $request->is('penjadwalan/*')) {
            return redirect()->route('dashboard')->with(
                'error',
                'Halaman penjadwalan hanya dapat diakses oleh Guru BK atau Administrator.'
            );
        }

        abort(403, 'Anda tidak memiliki izin untuk membuka halaman ini.');
    }
}
