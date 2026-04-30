<?php

namespace App\Http\Controllers;

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
            Log::warning('[google-oauth] callback failed', ['err' => $e->getMessage()]);
            return redirect()->route('auth.show')
                ->withErrors(['email' => 'Google sign-in failed. Please try again or use email + password.']);
        }

        $email = $googleUser->getEmail();
        if (! $email) {
            return redirect()->route('auth.show')
                ->withErrors(['email' => 'Google did not return an email address. Please use email + password.']);
        }

        // Match by email first to avoid duplicates.
        $user = User::where('email', $email)->first();

        if ($user) {
            // Existing account — link the Google ID and mark verified if not already.
            $user->forceFill([
                'google_id'         => $user->google_id ?: $googleUser->getId(),
                'email_verified_at' => $user->email_verified_at ?: now(),
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
            ]);
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('flash', "Signed in with Google. Welcome, {$user->first_name}!");
    }
}
