<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanEditProfile
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->canEditProfile()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'You do not have permission to change your profile.');
        }

        return $next($request);
    }
}
