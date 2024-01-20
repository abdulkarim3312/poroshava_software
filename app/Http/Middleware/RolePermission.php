<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($roles) {
            if (in_array(auth()->user()->role, explode('-', $roles))) {
                return $next($request);
            }
        }
        return abort('401');

    }
}
