<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string|null $permission = null): Response
    {
        // If no permission is specified, allow the request
        if (!$permission) {
            return $next($request);
        }

        // Check if user is authenticated
        if (!$request->user()) {
            return redirect('login');
        }

        // Check if user has the required permission
        if (!$request->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized. Permission required: ' . $permission);
        }

        return $next($request);
    }
}

