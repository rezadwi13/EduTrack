<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check() || !in_array(strtolower(auth()->user()->role), array_map('strtolower', $roles))) {
            abort(404);
        }

        return $next($request);
    }
}
