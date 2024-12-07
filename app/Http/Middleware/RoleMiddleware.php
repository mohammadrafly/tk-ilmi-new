<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function handle(Request $request, Closure $next, $action, $resource): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role_id = Auth::user()->role_id;

        $role = Role::with('permissions')->find($role_id);

        $hasPermission = $role->hasPermission($action, $resource);

        if ($hasPermission) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'You do not have permission to perform this action.');
    }
}
