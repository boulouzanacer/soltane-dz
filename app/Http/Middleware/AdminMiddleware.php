<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $role = (string) $request->session()->get('role', '');
        $isAdmin = (int) $request->session()->get('is_admin', 0) === 1 || $role === 'fournisseur';
        if (! $isAdmin) {
            abort(403);
        }

        return $next($request);
    }
}
