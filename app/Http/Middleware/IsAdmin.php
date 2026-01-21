<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah login DAN role-nya ADMIN
        if (Auth::check() && Auth::user()->role === 'ADMIN') {
            return $next($request);
        }

        // Kalau bukan admin, tendang ke dashboard atau halaman error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses Admin.');
    }
}
