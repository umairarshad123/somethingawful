<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirect;

class GoogleAuthController extends Controller
{
    /** Redirect the user to the Google OAuth consent screen. */
    public function redirect(): SymfonyRedirect
    {
        return Socialite::driver('google')->redirect();
    }

    /** Handle Google's callback — sign in or create the user, then go to /dashboard. */
    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $e) {
            Log::error('[google-oauth] retrieving user from Google failed', [
                'err'   => $e->getMessage(),
                'class' => $e::class,
            ]);
            return redirect()->route('auth.show')
                ->withErrors(['email' => 'Google sign-in failed: ' . $e->getMessage()]);
        }

        $email = $googleUser->getEmail();
        if (! $email) {
            return redirect()->route('auth.show')
                ->withErrors(['email' => 'Google did not return an email address. Please use email + password.']);
        }

        try {
            // Match by email first to avoid duplicates.
            $user = User::where('email', $email)->first();

            $isNew = false;

            if ($user) {
                // Existing account — link the Google ID and mark verified if not already.
                $user->forceFill([
                    'google_id'         => $user->google_id ?: $googleUser->getId(),
                    'email_verified_at' => $user->email_verified_at ?: now(),
                    'last_login_at'     => now(),
                    'last_login_ip'     => $request->ip(),
                ])->save();
            } else {
                // New account — split Google's name into first / last.
                $raw   = (array) ($googleUser->user ?? []);
                $first = $raw['given_name']  ?? Str::before((string) $googleUser->getName(), ' ');
                $last  = $raw['family_name'] ?? Str::after((string) $googleUser->getName(), ' ');

                $user = User::create([
                    'first_name'        => $first ?: 'Google',
                    'last_name'         => $last  ?: 'User',
                    'email'             => $email,
                    'google_id'         => $googleUser->getId(),
                    'password'          => Hash::make(Str::random(40)),
                    'email_verified_at' => now(),
                    'role'              => 'customer',
                    'signup_source'     => 'google',
                    'last_login_at'     => now(),
                    'last_login_ip'     => $request->ip(),
                ]);
                $isNew = true;
            }

            ActivityLog::record(
                event: $isNew ? 'account.created' : 'account.signed_in',
                label: $isNew ? "Google account created for {$user->email}" : "{$user->email} signed in via Google",
                subject: $user,
                userId: $user->id,
                payload: ['provider' => 'google'],
                request: $request,
            );
        } catch (\Throwable $e) {
            // Most common cause: `users.google_id` column doesn't exist yet
            // (run database/digirisers_install.sql ALTER TABLE on production).
            Log::error('[google-oauth] persisting user failed', [
                'email' => $email,
                'err'   => $e->getMessage(),
                'class' => $e::class,
            ]);
            return redirect()->route('auth.show')
                ->withErrors(['email' => 'Could not finalize your Google sign-in: ' . $e->getMessage()]);
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('flash', "Signed in with Google. Welcome, {$user->first_name}!");
    }
}
