<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Periksa apakah pengguna sudah masuk dan memiliki peran yang sesuai
        if (Auth::check() && Auth::user()->hasRole($role)) {
            return $next($request);
        }

        abort(Response::HTTP_FORBIDDEN);
    }
}
