<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Block any request whose user is not authenticated or whose role isn't 'admin'.
     * Auth-only redirect is already handled by the global guest redirect — this
     * middleware piles on the role check.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('auth.show'));
        }

        if (! $user->isAdmin()) {
            abort(403, 'You do not have access to this area.');
        }

        return $next($request);
    }
}
