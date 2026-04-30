@extends('layouts.app')

@section('title', 'Sign in or create an account — Digirisers')
@section('description', 'Sign in to your Digirisers account, or create a new account to access the Shop and your dashboard.')
@section('robots', 'noindex,follow')

@php
  $activeTab = session('activeTab', $activeTab ?? 'login');
@endphp

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    /* ============================================================
       Auth page — scoped (.au-*)
       ============================================================ */
    body { background: #f5f8ff; }

    .au-shell {
      min-height: calc(100svh - 64px);
      display: flex; align-items: center; justify-content: center;
      padding: 48px 20px;
      position: relative; overflow: hidden;
    }
    .au-shell::before {
      content: ""; position: absolute; inset: 0;
      background:
        radial-gradient(ellipse 60% 60% at 30% 20%, rgba(96,165,250,.18), transparent 60%),
        radial-gradient(ellipse 50% 50% at 80% 80%, rgba(30,58,138,.14), transparent 60%);
      pointer-events: none;
    }

    .au-grid {
      position: relative; z-index: 1;
      width: 100%; max-width: 1080px;
      display: grid; grid-template-columns: 1fr 1fr;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 28px;
      box-shadow:
        0 50px 120px -40px rgba(11, 16, 32, .35),
        0 8px 24px -8px rgba(11, 16, 32, .08);
      overflow: hidden;
      animation: au-rise .55s ease both;
    }
    @keyframes au-rise {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Pitch panel (left) */
    .au-pitch {
      position: relative; overflow: hidden;
      background: var(--ink);
      color: #fff;
      padding: 44px 40px 40px;
      display: flex; flex-direction: column;
    }
    .au-pitch::before {
      content: ""; position: absolute; top: -200px; left: -100px;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(59,130,246,.55), transparent 60%);
      pointer-events: none; filter: blur(40px);
    }
    .au-pitch::after {
      content: ""; position: absolute; bottom: -180px; right: -120px;
      width: 420px; height: 420px;
      background: radial-gradient(circle, rgba(96,165,250,.35), transparent 65%);
      pointer-events: none; filter: blur(40px);
    }
    .au-logo {
      display: inline-flex; align-items: center; gap: 10px;
      font-size: 1.18rem; font-weight: 700; color: #fff;
      letter-spacing: -0.02em; text-decoration: none;
      position: relative; z-index: 1;
    }
    .au-logo span { color: #60a5fa; }
    .au-pitch h2 {
      position: relative; z-index: 1;
      font-size: clamp(1.7rem, 2.6vw, 2.2rem);
      color: #fff; margin: 36px 0 14px;
      letter-spacing: -0.025em; line-height: 1.1;
    }
    .au-pitch h2 .serif-italic { color: #93c5fd; }
    .au-pitch > p {
      position: relative; z-index: 1;
      color: rgba(255,255,255,.7); font-size: 1rem; line-height: 1.55;
      margin: 0 0 28px; max-width: 380px;
    }
    .au-points {
      position: relative; z-index: 1;
      list-style: none; margin: auto 0 0; padding: 0;
      display: grid; gap: 12px;
    }
    .au-points li {
      display: flex; align-items: flex-start; gap: 12px;
      font-size: .92rem; color: rgba(255,255,255,.85);
    }
    .au-points li svg {
      flex-shrink: 0; margin-top: 1px;
      width: 22px; height: 22px; padding: 4px;
      border-radius: 50%; background: rgba(255,255,255,.08); color: #93c5fd;
    }

    /* Form panel (right) */
    .au-form {
      padding: 44px 40px 40px;
      display: flex; flex-direction: column; justify-content: center;
    }
    .au-tabs {
      display: inline-flex; padding: 4px; background: #f1f5f9;
      border-radius: 999px; margin-bottom: 24px;
      align-self: flex-start;
    }
    .au-tab {
      padding: 8px 18px; font-family: inherit; font-size: .88rem; font-weight: 600;
      color: var(--soft); background: transparent; border: 0; cursor: pointer;
      border-radius: 999px; transition: all .2s ease;
    }
    .au-tab.active {
      background: var(--ink); color: #fff;
      box-shadow: 0 4px 10px -3px rgba(11,16,32,.4);
    }

    .au-panel { display: none; }
    .au-panel.active { display: block; animation: au-panel-in .35s ease both; }
    @keyframes au-panel-in { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

    .au-panel h3 { font-size: 1.5rem; margin: 0 0 6px; letter-spacing: -0.02em; color: var(--ink); }
    .au-panel > p { font-size: .9rem; color: var(--soft); margin: 0 0 20px; }

    .au-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .au-field { display: grid; gap: 4px; margin-bottom: 12px; }
    .au-field label { font-size: .76rem; font-weight: 600; color: var(--muted); }
    .au-field input {
      width: 100%; padding: 11px 13px;
      border: 1.5px solid var(--line); border-radius: 10px;
      font: inherit; font-size: .92rem; color: var(--ink); background: #fff;
      transition: border-color .2s ease, box-shadow .2s ease;
    }
    .au-field input:focus {
      outline: none; border-color: var(--blue-500);
      box-shadow: 0 0 0 4px rgba(59,130,246,.18);
    }
    .au-field .au-error {
      display: block; font-size: .76rem; color: #b91c1c; margin-top: 4px;
    }

    .au-row-between {
      display: flex; align-items: center; justify-content: space-between;
      margin: 4px 0 18px; font-size: .82rem;
    }
    .au-remember { display: inline-flex; align-items: center; gap: 7px; color: var(--muted); cursor: pointer; }
    .au-remember input { width: 15px; height: 15px; accent-color: var(--blue-600); }
    .au-forgot { color: var(--blue-700); text-decoration: none; font-weight: 600; }
    .au-forgot:hover { color: var(--blue-900); }

    .au-submit {
      width: 100%; padding: 13px 20px;
      border: 0; border-radius: 12px;
      font: inherit; font-size: .95rem; font-weight: 600;
      color: #fff;
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      box-shadow: 0 12px 28px -10px rgba(37,99,235,.55);
      cursor: pointer;
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      transition: transform .15s ease, box-shadow .25s ease;
    }
    .au-submit:hover { transform: translateY(-1px); box-shadow: 0 18px 36px -10px rgba(37,99,235,.6); }

    .au-foot { font-size: .82rem; color: var(--soft); text-align: center; margin: 18px 0 0; }
    .au-foot a { color: var(--blue-700); font-weight: 600; }

    .au-flash {
      background: #ecfeff; border: 1px solid #67e8f9;
      color: #0e7490; padding: 10px 14px; border-radius: 10px;
      font-size: .88rem; margin-bottom: 16px;
    }
    .au-error-box {
      background: #fef2f2; border: 1px solid #fecaca;
      color: #b91c1c; padding: 10px 14px; border-radius: 10px;
      font-size: .85rem; margin-bottom: 16px;
    }

    /* Continue with Google */
    .au-google {
      display: flex; align-items: center; justify-content: center; gap: 10px;
      width: 100%; padding: 11px 16px;
      border: 1.5px solid var(--line); border-radius: 12px;
      background: #fff; color: var(--ink);
      font: inherit; font-size: .92rem; font-weight: 600;
      text-decoration: none; cursor: pointer;
      transition: border-color .2s ease, box-shadow .2s ease, transform .15s ease;
      margin-bottom: 18px;
    }
    .au-google:hover {
      border-color: var(--ink);
      box-shadow: 0 6px 18px -10px rgba(11,16,32,.25);
      transform: translateY(-1px);
      color: var(--ink);
    }
    .au-google:active { transform: translateY(0); }
    .au-google svg { flex-shrink: 0; }

    .au-divider {
      display: flex; align-items: center; gap: 14px;
      margin: 0 0 18px;
      font-size: .72rem; font-weight: 600; letter-spacing: .12em;
      text-transform: uppercase;
      color: var(--soft);
    }
    .au-divider::before,
    .au-divider::after {
      content: ""; flex: 1; height: 1px; background: var(--line);
    }

    @media (max-width: 880px) {
      .au-grid { grid-template-columns: 1fr; }
      .au-pitch { padding: 36px 28px 32px; }
      .au-form  { padding: 32px 28px 28px; }
      .au-row { grid-template-columns: 1fr; gap: 0; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <div class="au-shell">
    <div class="au-grid">

      <aside class="au-pitch">
        <a href="{{ url('/') }}" class="au-logo">
          <svg viewBox="0 0 40 40" width="28" height="28" aria-hidden="true">
            <rect x="2" y="2" width="36" height="36" rx="10" fill="#3b82f6"/>
            <path d="M10 26 L16 18 L22 24 L30 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="30" cy="12" r="2.5" fill="#fff"/>
          </svg>
          Digirisers<span>.</span>
        </a>

        <h2>Your <span class="serif-italic">growth platform</span> account.</h2>
        <p>Sign in to access the Shop, save your cart across visits, and keep your orders in one place.</p>

        <ul class="au-points">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            Browse 57 priced services
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            Save your cart across devices
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            Faster checkout & order tracking
          </li>
        </ul>
      </aside>

      <section class="au-form">
        <div class="au-tabs" role="tablist" aria-label="Sign in or sign up">
          <button type="button" class="au-tab @if($activeTab === 'login') active @endif" data-tab="login">Sign in</button>
          <button type="button" class="au-tab @if($activeTab === 'signup') active @endif" data-tab="signup">Create account</button>
        </div>

        @if (session('flash'))
          <div class="au-flash">{{ session('flash') }}</div>
        @endif

        {{-- ============ Sign in panel ============ --}}
        <div class="au-panel @if($activeTab === 'login') active @endif" id="panel-login" role="tabpanel">
          <h3>Welcome back.</h3>
          <p>Sign in to access your Shop and dashboard.</p>

          @if ($errors->any() && $activeTab === 'login')
            <div class="au-error-box">{{ $errors->first() }}</div>
          @endif

          <a href="{{ route('auth.google') }}" class="au-google" rel="nofollow">
            <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true">
              <path fill="#4285F4" d="M17.64 9.2c0-.64-.06-1.25-.16-1.84H9v3.48h4.84a4.14 4.14 0 0 1-1.8 2.71v2.26h2.92c1.7-1.57 2.68-3.88 2.68-6.61z"/>
              <path fill="#34A853" d="M9 18c2.43 0 4.47-.81 5.96-2.18l-2.92-2.26c-.81.54-1.84.86-3.04.86-2.34 0-4.32-1.58-5.03-3.7H.96v2.33A9 9 0 0 0 9 18z"/>
              <path fill="#FBBC05" d="M3.97 10.71A5.4 5.4 0 0 1 3.68 9c0-.59.1-1.17.29-1.71V4.96H.96A9 9 0 0 0 0 9c0 1.45.35 2.83.96 4.04l3.01-2.33z"/>
              <path fill="#EA4335" d="M9 3.58c1.32 0 2.5.45 3.44 1.35l2.58-2.58A8.96 8.96 0 0 0 9 0 9 9 0 0 0 .96 4.96l3.01 2.33C4.68 5.16 6.66 3.58 9 3.58z"/>
            </svg>
            Continue with Google
          </a>
          <div class="au-divider">or sign in with email</div>

          <form method="POST" action="{{ route('auth.login') }}" novalidate>
            @csrf
            <div class="au-field">
              <label for="login-email">Email</label>
              <input type="email" id="login-email" name="email" placeholder="you@company.com"
                     value="{{ old('email') }}" autocomplete="email" required>
            </div>
            <div class="au-field">
              <label for="login-password">Password</label>
              <input type="password" id="login-password" name="password" placeholder="••••••••"
                     autocomplete="current-password" required>
            </div>
            <div class="au-row-between">
              <label class="au-remember">
                <input type="checkbox" name="remember" value="1"> Remember me
              </label>
              <span style="font-size:.78rem; color: var(--soft-2);">Forgot? Email info@digirisers.com</span>
            </div>
            <button type="submit" class="au-submit">
              Sign in
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
          </form>
          <p class="au-foot">No account yet? <a href="#" data-switch-tab="signup">Create one</a>.</p>
        </div>

        {{-- ============ Sign up panel ============ --}}
        <div class="au-panel @if($activeTab === 'signup') active @endif" id="panel-signup" role="tabpanel">
          <h3>Create your account.</h3>
          <p>Get instant access to the Shop and your dashboard. Free, takes 30 seconds.</p>

          @if ($errors->any() && $activeTab === 'signup')
            <div class="au-error-box">{{ $errors->first() }}</div>
          @endif

          <a href="{{ route('auth.google') }}" class="au-google" rel="nofollow">
            <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true">
              <path fill="#4285F4" d="M17.64 9.2c0-.64-.06-1.25-.16-1.84H9v3.48h4.84a4.14 4.14 0 0 1-1.8 2.71v2.26h2.92c1.7-1.57 2.68-3.88 2.68-6.61z"/>
              <path fill="#34A853" d="M9 18c2.43 0 4.47-.81 5.96-2.18l-2.92-2.26c-.81.54-1.84.86-3.04.86-2.34 0-4.32-1.58-5.03-3.7H.96v2.33A9 9 0 0 0 9 18z"/>
              <path fill="#FBBC05" d="M3.97 10.71A5.4 5.4 0 0 1 3.68 9c0-.59.1-1.17.29-1.71V4.96H.96A9 9 0 0 0 0 9c0 1.45.35 2.83.96 4.04l3.01-2.33z"/>
              <path fill="#EA4335" d="M9 3.58c1.32 0 2.5.45 3.44 1.35l2.58-2.58A8.96 8.96 0 0 0 9 0 9 9 0 0 0 .96 4.96l3.01 2.33C4.68 5.16 6.66 3.58 9 3.58z"/>
            </svg>
            Continue with Google
          </a>
          <div class="au-divider">or sign up with email</div>

          <form method="POST" action="{{ route('auth.register') }}" novalidate>
            @csrf
            <div class="au-row">
              <div class="au-field">
                <label for="reg-first">First name</label>
                <input type="text" id="reg-first" name="first_name" placeholder="Jane"
                       value="{{ old('first_name') }}" autocomplete="given-name" required>
              </div>
              <div class="au-field">
                <label for="reg-last">Last name</label>
                <input type="text" id="reg-last" name="last_name" placeholder="Doe"
                       value="{{ old('last_name') }}" autocomplete="family-name" required>
              </div>
            </div>
            <div class="au-field">
              <label for="reg-email">Work email</label>
              <input type="email" id="reg-email" name="email" placeholder="jane@company.com"
                     value="{{ old('email') }}" autocomplete="email" required>
            </div>
            <div class="au-row">
              <div class="au-field">
                <label for="reg-phone">Phone</label>
                <input type="tel" id="reg-phone" name="phone" placeholder="+1 555 000 0000"
                       value="{{ old('phone') }}" autocomplete="tel" required>
              </div>
              <div class="au-field">
                <label for="reg-company">Company <span style="color:var(--soft-2); font-weight:500;">(optional)</span></label>
                <input type="text" id="reg-company" name="company" placeholder="Acme Inc."
                       value="{{ old('company') }}" autocomplete="organization">
              </div>
            </div>
            <div class="au-row">
              <div class="au-field">
                <label for="reg-password">Password</label>
                <input type="password" id="reg-password" name="password" placeholder="At least 8 chars"
                       autocomplete="new-password" required>
              </div>
              <div class="au-field">
                <label for="reg-password-c">Confirm</label>
                <input type="password" id="reg-password-c" name="password_confirmation" placeholder="Repeat"
                       autocomplete="new-password" required>
              </div>
            </div>
            <button type="submit" class="au-submit" style="margin-top:6px;">
              Create account
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
          </form>
          <p class="au-foot">Already have an account? <a href="#" data-switch-tab="login">Sign in</a>.</p>
        </div>
      </section>
    </div>
  </div>

@endsection

@push('scripts')
  <script>
    (function () {
      const tabs   = document.querySelectorAll('.au-tab');
      const panels = document.querySelectorAll('.au-panel');
      const switchTo = (which) => {
        tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === which));
        panels.forEach(p => p.classList.toggle('active', p.id === 'panel-' + which));
        try {
          const url = new URL(window.location);
          url.searchParams.set('tab', which);
          window.history.replaceState({}, '', url);
        } catch (_) {}
      };
      tabs.forEach(t => t.addEventListener('click', () => switchTo(t.dataset.tab)));
      document.querySelectorAll('[data-switch-tab]').forEach(a => {
        a.addEventListener('click', (e) => { e.preventDefault(); switchTo(a.dataset.switchTab); });
      });
    })();
  </script>
@endpush
