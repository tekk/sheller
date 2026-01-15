<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Exclude install routes to prevent loop
        if ($request->is('install') || $request->is('install/*') || $request->is('system/*')) {
            return $next($request);
        }

        // Check if installed
        if (!file_exists(storage_path('app/installed'))) {
            return redirect()->route('install.welcome');
        }

        return $next($request);
    }
}
