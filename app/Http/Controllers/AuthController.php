<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the combined login + signup page.
     * Accepts ?tab=signup to open the signup tab by default.
     */
    public function show(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth', [
            'activeTab' => $request->query('tab') === 'signup' ? 'signup' : 'login',
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:80',
            'last_name'  => 'required|string|max:80',
            'email'      => 'required|email:rfc|max:200|unique:users,email',
            'phone'      => 'required|string|max:40',
            'company'    => 'nullable|string|max:200',
            'password'   => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'company'    => $data['company'] ?? null,
            'password'   => $data['password'],   // hashed via cast
            'role'       => 'customer',
        ]);

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('flash', "Welcome, {$user->first_name}! Your account is ready.");
    }

    public function login(Request $request): RedirectResponse
    {
        $creds = $request->validate([
            'email'    => 'required|email:rfc',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        $remember = (bool) ($creds['remember'] ?? false);

        if (! Auth::attempt(
            ['email' => $creds['email'], 'password' => $creds['password']],
            $remember
        )) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Those credentials don\'t match our records.'])
                ->with('activeTab', 'login');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('flash', 'Welcome back!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('flash', 'You have been signed out.');
    }
}
