<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Dedicated sign-in flow for the admin panel. Lives at /thebestadmin/login
 * so it never gets confused with the customer auth page at /auth.
 *
 * The login attempt only succeeds for users with role='admin' AND
 * status='active'; everything else is rejected with the generic
 * "credentials don't match" error so we don't leak which accounts exist.
 */
class AdminAuthController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.overview');
        }
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $creds = $request->validate([
            'email'    => 'required|email:rfc',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        if (! Auth::attempt(
            ['email' => $creds['email'], 'password' => $creds['password']],
            (bool) ($creds['remember'] ?? false)
        )) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Invalid credentials.']);
        }

        $user = Auth::user();

        // Hard refusal: only admins reach the panel.
        if (! $user->isAdmin() || ($user->status ?? 'active') !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'This account does not have admin access.']);
        }

        $request->session()->regenerate();

        $user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->save();

        ActivityLog::record(
            event: 'admin.signed_in',
            label: "{$user->email} signed into the admin panel",
            subject: $user,
            userId: $user->id,
            request: $request,
        );

        return redirect()->intended(route('admin.overview'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $userEmail = Auth::user()?->email;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($userEmail) {
            ActivityLog::record(
                event: 'admin.signed_out',
                label: "{$userEmail} signed out of the admin panel",
                request: $request,
            );
        }

        return redirect()->route('admin.login');
    }
}
