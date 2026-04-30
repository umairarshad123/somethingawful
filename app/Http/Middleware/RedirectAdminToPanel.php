<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Once a user signs in as admin, they live ONLY inside /thebestadmin/*.
 * Any request for the public site (/, /shop, /services, /contact, /auth,
 * /dashboard, etc.) bounces back to /thebestadmin so the admin never sees
 * the customer-facing chrome.
 *
 * Logout posts to admin.logout, which is allowed through, otherwise admins
 * could never sign out.
 */
class RedirectAdminToPanel
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Not signed in, or not an admin? Pass through unchanged.
        if (! $user || ! $user->isAdmin()) {
            return $next($request);
        }

        $path = $request->path(); // no leading slash; '' for /

        // Allowed paths for an authenticated admin.
        $allowed =
            $path === 'thebestadmin' ||
            str_starts_with($path, 'thebestadmin/') ||
            $path === 'auth/logout';        // legacy customer logout still works if it ever fires

        if ($allowed) {
            return $next($request);
        }

        return redirect()->route('admin.overview');
    }
}
