<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class IsAdmin
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (!auth()->check() || auth()->user()->role !== 'ROLE_ADMIN') {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}
