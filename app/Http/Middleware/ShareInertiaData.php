<?php

namespace App\Http\Middleware;

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
        // Mendapatkan semua data header
        $headers = Header::all();

        // Menyediakan data global untuk Inertia
        Inertia::share('headers', $headers);

        return $next($request);
    }
}
