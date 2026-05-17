<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotRole
{
    /**
     * Handle an incoming request.
     *
     * Usage example: middleware('role.redirect:admin')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        if ($user->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}

