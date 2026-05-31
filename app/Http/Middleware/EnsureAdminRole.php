<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->canManageUsers()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'You do not have permission to access that page.');
        }

        return $next($request);
    }
}
