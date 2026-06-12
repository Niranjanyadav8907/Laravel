<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response{
        if (!auth()->check()) {
            abort(403, 'Unauthorized. Please login.');
        }

        $userRole = auth()->user()->role;

        if ($userRole == 1 || $userRole == 2) {
            return $next($request);
        }

        abort(403, 'Access denied. You do not have permission.');
    }
}
