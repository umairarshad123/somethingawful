@extends('layouts.app')

@section('title', 'Dashboard — Digirisers')
@section('description', 'Your Digirisers dashboard.')
@section('robots', 'noindex,follow')

@php
  $user = auth()->user();
@endphp

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    body { background: #f5f8ff; }

    .db-shell { padding: 56px 0 80px; min-height: calc(100svh - 64px); }
    .db-grid {
      display: grid; grid-template-columns: 1fr 2fr;
      gap: 24px; max-width: 1180px; margin: 0 auto; padding: 0 24px;
    }
    .db-card {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 18px;
      padding: 26px 24px;
      box-shadow: 0 1px 2px rgba(11,16,32,.04);
    }
    .db-profile { text-align: center; padding: 32px 24px 26px; }
    .db-avatar {
      width: 84px; height: 84px; border-radius: 50%;
      display: grid; place-items: center;
      margin: 0 auto 14px;
      background: linear-gradient(135deg, #3b82f6, #1e3a8a);
      color: #fff; font-size: 1.7rem; font-weight: 700; letter-spacing: -0.02em;
      box-shadow: 0 14px 30px -10px rgba(37,99,235,.5);
    }
    .db-profile h2 { font-size: 1.25rem; margin: 0 0 4px; letter-spacing: -0.02em; color: var(--ink); }
    .db-profile .db-role {
      display: inline-block; font-size: .68rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .12em;
      padding: 4px 10px; border-radius: 999px;
      background: var(--blue-50); color: var(--blue-700);
      margin-bottom: 14px;
    }
    .db-profile .db-role.admin { background: var(--ink); color: #fff; }
    .db-profile .db-meta { font-size: .9rem; color: var(--soft); margin: 0 0 6px; }
    .db-profile .db-meta strong { color: var(--ink); font-weight: 600; }

    .db-logout-form { margin-top: 18px; }
    .db-logout {
      display: inline-flex; align-items: center; justify-content: center; gap: 6px;
      padding: 10px 18px; border-radius: 10px;
      font: inherit; font-size: .88rem; font-weight: 600;
      color: var(--muted); background: #f1f5f9;
      border: 1px solid var(--line); cursor: pointer;
      transition: all .2s ease;
    }
    .db-logout:hover { background: var(--ink); color: #fff; border-color: var(--ink); }

    .db-flash {
      background: #ecfeff; border: 1px solid #67e8f9;
      color: #0e7490; padding: 12px 16px; border-radius: 12px;
      font-size: .92rem; margin-bottom: 18px;
    }

    .db-eyebrow {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
      color: var(--blue-700); background: var(--blue-50);
      padding: 5px 10px; border-radius: 999px; margin-bottom: 14px;
    }
    .db-card h3 { font-size: 1.2rem; margin: 0 0 6px; letter-spacing: -0.02em; color: var(--ink); }
    .db-card > p { font-size: .92rem; color: var(--soft); margin: 0 0 18px; line-height: 1.5; }

    .db-actions {
      display: grid; grid-template-columns: repeat(2, 1fr);
      gap: 12px; margin-top: 6px;
    }
    .db-action {
      display: flex; flex-direction: column; gap: 4px;
      padding: 16px 18px;
      background: var(--bg-soft);
      border: 1px solid var(--line);
      border-radius: 14px;
      text-decoration: none; color: var(--ink);
      transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    .db-action:hover { border-color: var(--blue-300); transform: translateY(-2px); box-shadow: var(--shadow); color: var(--ink); }
    .db-action strong { font-size: .98rem; font-weight: 700; }
    .db-action small { font-size: .82rem; color: var(--soft); }
    .db-action .arr { display: inline-flex; margin-top: 8px; font-size: .82rem; color: var(--blue-700); font-weight: 600; gap: 4px; transition: gap .2s ease; }
    .db-action:hover .arr { gap: 8px; }

    .db-info-grid {
      display: grid; grid-template-columns: repeat(2, 1fr);
      gap: 12px; margin-top: 18px;
    }
    .db-info {
      padding: 14px 16px;
      background: var(--bg-soft); border: 1px solid var(--line); border-radius: 12px;
    }
    .db-info small { display: block; font-size: .68rem; color: var(--soft); text-transform: uppercase; letter-spacing: .08em; font-weight: 600; margin-bottom: 4px; }
    .db-info span { font-size: .94rem; color: var(--ink); font-weight: 500; word-break: break-word; }

    @media (max-width: 880px) {
      .db-grid { grid-template-columns: 1fr; }
      .db-actions, .db-info-grid { grid-template-columns: 1fr; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <div class="db-shell">
    <div class="db-grid">

      <aside class="db-card db-profile">
        <div class="db-avatar">{{ $user->initials }}</div>
        <h2>{{ $user->name }}</h2>
        <span class="db-role @if($user->isAdmin()) admin @endif">
          {{ $user->isAdmin() ? 'Admin' : 'Customer' }}
        </span>
        <p class="db-meta">{{ $user->email }}</p>
        @if ($user->phone)
          <p class="db-meta">{{ $user->phone }}</p>
        @endif
        @if ($user->company)
          <p class="db-meta">{{ $user->company }}</p>
        @endif

        <form class="db-logout-form" method="POST" action="{{ route('auth.logout') }}">
          @csrf
          <button type="submit" class="db-logout">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Sign out
          </button>
        </form>
      </aside>

      <section>
        @if (session('flash'))
          <div class="db-flash">{{ session('flash') }}</div>
        @endif

        <div class="db-card" style="margin-bottom: 18px;">
          <span class="db-eyebrow"><span style="width:6px; height:6px; border-radius:50%; background: var(--blue-600);"></span> Welcome, {{ $user->first_name }}</span>
          <h3>Your account is ready.</h3>
          <p>Browse the Shop, add services to your cart, and we'll handle the rest. Need a custom engagement? Reach out anytime.</p>

          <div class="db-actions">
            <a class="db-action" href="{{ url('/shop') }}">
              <strong>Visit the Shop</strong>
              <small>57 priced services across 8 modules</small>
              <span class="arr">Browse →</span>
            </a>
            <a class="db-action" href="{{ url('/services') }}">
              <strong>Browse Services</strong>
              <small>Read the full platform catalog</small>
              <span class="arr">Explore →</span>
            </a>
            <a class="db-action" href="{{ route('contact') }}">
              <strong>Talk to a strategist</strong>
              <small>Custom scope, free 15-minute call</small>
              <span class="arr">Get in touch →</span>
            </a>
            <a class="db-action" href="{{ route('billing.portal') }}" style="border-color: #4AAE18;">
              <strong style="color:#3a8c12;">Manage billing</strong>
              <small>Cards, invoices, cancel subscriptions</small>
              <span class="arr" style="color:#3a8c12;">Open portal →</span>
            </a>
          </div>
        </div>

        <div class="db-card">
          <h3>Account details</h3>
          <p>This is what we have on file. Reach out if you need to update anything.</p>
          <div class="db-info-grid">
            <div class="db-info"><small>First name</small><span>{{ $user->first_name }}</span></div>
            <div class="db-info"><small>Last name</small><span>{{ $user->last_name }}</span></div>
            <div class="db-info"><small>Email</small><span>{{ $user->email }}</span></div>
            <div class="db-info"><small>Phone</small><span>{{ $user->phone ?: '—' }}</span></div>
            <div class="db-info"><small>Company</small><span>{{ $user->company ?: '—' }}</span></div>
            <div class="db-info"><small>Member since</small><span>{{ $user->created_at?->format('M j, Y') }}</span></div>
          </div>
        </div>
      </section>

    </div>
  </div>

  @include('partials.footer')

@endsection
