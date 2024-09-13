<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\  omponent\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()->role !== $role) {
            return redirect()->route('dashboard.index')->with('error', 'Akses dilarang.');
        }

        return $next($request);
    }
}
