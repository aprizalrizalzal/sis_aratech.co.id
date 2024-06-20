<?php

namespace App\Http\Middleware;

use App\Models\Footer;
use App\Models\Header;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareInertiaData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::share([
            'headers' => fn () => Header::all(),
            'footers' => fn () => Footer::all(),
        ]);

        return $next($request);
    }
}
