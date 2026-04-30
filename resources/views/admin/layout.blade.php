<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="robots" content="noindex,nofollow" />
  <title>@yield('title', 'Admin') · Digirisers</title>

  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Instrument+Serif&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />

  <style>
    :root {
      --ad-side: 248px;
      --ad-side-bg: #0b1020;
      --ad-side-tint: #14193b;
      --ad-side-fg: #d6dcef;
      --ad-side-fg-muted: #8590b8;
      --ad-side-active: #3b82f6;
      --ad-bg: #f7f8fb;
      --ad-card: #ffffff;
      --ad-border: #e5e7eb;
    }
    html, body { background: var(--ad-bg); }
    body { font-family: var(--font); color: var(--ink); margin: 0; min-height: 100vh; }

    .ad-shell { display: grid; grid-template-columns: var(--ad-side) 1fr; min-height: 100vh; }

    /* Sidebar */
    .ad-side {
      background: var(--ad-side-bg); color: var(--ad-side-fg);
      padding: 22px 16px;
      position: sticky; top: 0; align-self: start;
      height: 100vh; overflow-y: auto;
      border-right: 1px solid #1f2447;
    }
    .ad-brand { display: flex; align-items: center; gap: 10px; padding: 6px 10px 24px; color: #fff; font-weight: 700; font-size: 1.05rem; letter-spacing: -0.02em; text-decoration: none; }
    .ad-brand .logo { width: 30px; height: 30px; border-radius: 9px; background: linear-gradient(135deg,#60a5fa,#1e3a8a); display: grid; place-items: center; color: #fff; font-weight: 800; }
    .ad-brand .dot { color: #60a5fa; }
    .ad-brand small { display: block; font-size: .68rem; font-weight: 500; color: var(--ad-side-fg-muted); letter-spacing: .12em; text-transform: uppercase; margin-top: 2px; }

    .ad-section-label { padding: 14px 12px 6px; font-size: .68rem; color: var(--ad-side-fg-muted); letter-spacing: .14em; text-transform: uppercase; font-weight: 700; }
    .ad-nav { list-style: none; margin: 0; padding: 0; display: grid; gap: 2px; }
    .ad-nav a {
      display: flex; align-items: center; gap: 11px;
      padding: 10px 12px; border-radius: 9px;
      color: var(--ad-side-fg); text-decoration: none;
      font-size: .89rem; font-weight: 500;
      transition: background .15s ease, color .15s ease;
    }
    .ad-nav a:hover { background: var(--ad-side-tint); color: #fff; }
    .ad-nav a.active { background: linear-gradient(90deg, rgba(59,130,246,.18), rgba(59,130,246,.04)); color: #fff; box-shadow: inset 2px 0 0 var(--ad-side-active); }
    .ad-nav svg { width: 16px; height: 16px; flex-shrink: 0; opacity: .8; }

    /* Topbar */
    .ad-main { display: flex; flex-direction: column; min-width: 0; }
    .ad-top {
      background: #fff; border-bottom: 1px solid var(--ad-border);
      padding: 14px 32px; display: flex; align-items: center; gap: 16px; justify-content: space-between;
      position: sticky; top: 0; z-index: 30;
    }
    .ad-top h1 { font-size: 1.25rem; margin: 0; letter-spacing: -0.02em; }
    .ad-top .user { display: flex; align-items: center; gap: 10px; padding: 6px 10px 6px 6px; background: #f3f4f7; border-radius: 999px; }
    .ad-top .avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg,#3b82f6,#1e3a8a); color: #fff; font-weight: 700; font-size: .76rem; display: grid; place-items: center; }
    .ad-top .user-name { font-size: .86rem; font-weight: 600; }
    .ad-top form { margin: 0; }
    .ad-top button.signout { background: transparent; border: 0; cursor: pointer; padding: 6px 10px; font-family: inherit; font-size: .82rem; color: var(--soft); border-radius: 8px; }
    .ad-top button.signout:hover { color: var(--ink); background: #eef2f6; }

    /* Toggle for mobile */
    .ad-toggle { display: none; background: transparent; border: 0; cursor: pointer; padding: 6px; }
    .ad-toggle svg { width: 22px; height: 22px; }

    .ad-body { padding: 28px 32px 64px; }

    /* Cards / generic */
    .ad-card { background: var(--ad-card); border: 1px solid var(--ad-border); border-radius: 16px; padding: 22px; }
    .ad-card h3 { margin: 0 0 14px; font-size: 1rem; }

    .ad-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
    .ad-stat { background: #fff; border: 1px solid var(--ad-border); border-radius: 14px; padding: 18px 20px; position: relative; overflow: hidden; }
    .ad-stat::after { content: ""; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #3b82f6, #1e3a8a); }
    .ad-stat .label { font-size: .72rem; color: var(--soft); text-transform: uppercase; letter-spacing: .08em; font-weight: 600; }
    .ad-stat .num { font-size: 1.8rem; font-weight: 800; color: var(--ink); letter-spacing: -0.02em; line-height: 1.1; margin-top: 4px; }
    .ad-stat .delta { font-size: .76rem; color: var(--soft); margin-top: 2px; font-family: var(--font-mono); }
    .ad-stat .delta.up { color: #16a34a; }
    .ad-stat .delta.flat { color: var(--soft); }

    /* Tables */
    .ad-table { width: 100%; border-collapse: collapse; }
    .ad-table th, .ad-table td { padding: 12px 14px; text-align: left; font-size: .88rem; border-bottom: 1px solid var(--line); }
    .ad-table th { background: #fafafa; font-weight: 600; color: var(--soft); font-size: .76rem; text-transform: uppercase; letter-spacing: .04em; }
    .ad-table tbody tr:hover { background: #fafbff; }
    .ad-table td a { color: var(--blue-700); }
    .ad-table-wrap { overflow-x: auto; }

    /* Badges */
    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 999px; font-size: .72rem; font-weight: 600; letter-spacing: .02em; }
    .badge.b-new { background: #eff6ff; color: #1d4ed8; }
    .badge.b-contacted { background: #fef9c3; color: #92400e; }
    .badge.b-qualified { background: #ede9fe; color: #5b21b6; }
    .badge.b-proposal { background: #fff7ed; color: #c2410c; }
    .badge.b-won { background: #dcfce7; color: #15803d; }
    .badge.b-lost { background: #fee2e2; color: #b91c1c; }
    .badge.b-active, .badge.b-onboarding { background: #dcfce7; color: #15803d; }
    .badge.b-paused { background: #fef9c3; color: #92400e; }
    .badge.b-completed { background: #e0e7ff; color: #3730a3; }
    .badge.b-churned { background: #fee2e2; color: #b91c1c; }
    .badge.b-suspended { background: #fee2e2; color: #b91c1c; }
    .badge.b-admin { background: #0b1020; color: #fff; }

    /* Filters bar */
    .ad-filters { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; align-items: center; }
    .ad-filters input, .ad-filters select {
      padding: 9px 12px; font-size: .88rem; font-family: inherit;
      border: 1px solid var(--ad-border); border-radius: 10px;
      background: #fff;
    }
    .ad-filters input:focus, .ad-filters select:focus { outline: none; border-color: var(--blue-500); box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
    .ad-filters .btn-sm { padding: 8px 14px; font-size: .82rem; border-radius: 10px; font-weight: 600; cursor: pointer; border: 1px solid transparent; }
    .ad-filters .btn-sm.primary { background: #0b1020; color: #fff; }
    .ad-filters .btn-sm.ghost { background: #fff; color: var(--ink); border-color: var(--ad-border); }

    /* Pagination */
    .ad-pager { display: flex; gap: 4px; margin-top: 18px; flex-wrap: wrap; }
    .ad-pager a, .ad-pager span { padding: 7px 12px; font-size: .82rem; border: 1px solid var(--ad-border); border-radius: 8px; background: #fff; color: var(--ink); }
    .ad-pager a:hover { background: #f4f6fa; }
    .ad-pager span[aria-current] { background: #0b1020; color: #fff; border-color: #0b1020; }
    .ad-pager .disabled { color: var(--soft-2); pointer-events: none; }

    /* Two-column detail layout */
    .ad-detail { display: grid; grid-template-columns: 1.5fr 1fr; gap: 18px; }
    .ad-detail .field { display: grid; grid-template-columns: 140px 1fr; gap: 8px; padding: 10px 0; border-bottom: 1px dashed var(--line); font-size: .9rem; }
    .ad-detail .field:last-child { border-bottom: 0; }
    .ad-detail .field strong { color: var(--soft); font-weight: 500; font-size: .82rem; text-transform: uppercase; letter-spacing: .06em; }

    /* Activity timeline */
    .timeline { list-style: none; padding: 0; margin: 0; }
    .timeline li { display: grid; grid-template-columns: 24px 1fr; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--line); }
    .timeline li:last-child { border-bottom: 0; }
    .timeline .dot { width: 10px; height: 10px; border-radius: 50%; background: #3b82f6; margin-top: 8px; }
    .timeline .ev { font-size: .84rem; color: var(--ink); font-weight: 500; }
    .timeline .meta { font-size: .76rem; color: var(--soft); }

    .ad-flash { padding: 10px 14px; background: #ecfdf5; color: #14532d; border: 1px solid #a7f3d0; border-radius: 10px; margin-bottom: 14px; font-size: .9rem; }

    @media (max-width: 980px) {
      .ad-shell { grid-template-columns: 1fr; }
      .ad-side { position: fixed; top: 0; left: 0; width: var(--ad-side); height: 100vh; transform: translateX(-100%); transition: transform .3s ease; z-index: 100; }
      .ad-shell.drawer-open .ad-side { transform: translateX(0); }
      .ad-toggle { display: inline-flex; }
      .ad-stats { grid-template-columns: 1fr 1fr; }
      .ad-detail { grid-template-columns: 1fr; }
      .ad-body { padding: 22px 18px 64px; }
      .ad-top { padding: 12px 18px; }
    }
  </style>
  @stack('admin-styles')
</head>
<body>
  @php
    $current = trim(request()->path(), '/');
    $is = function ($prefix) use ($current) {
      if ($prefix === 'admin') return $current === 'admin';
      return $current === "admin/{$prefix}" || str_starts_with($current, "admin/{$prefix}/");
    };
  @endphp

  <div class="ad-shell" id="adShell">

    <aside class="ad-side">
      <a href="{{ route('admin.overview') }}" class="ad-brand">
        <span class="logo">D</span>
        <span>Digirisers<span class="dot">.</span><small>Admin</small></span>
      </a>

      <div class="ad-section-label">Operations</div>
      <ul class="ad-nav">
        <li><a href="{{ route('admin.overview') }}" class="@if($is('admin')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
          Overview
        </a></li>
        <li><a href="{{ route('admin.leads.index') }}" class="@if($is('leads')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
          Leads
        </a></li>
        <li><a href="{{ route('admin.users.index') }}" class="@if($is('users')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          Users
        </a></li>
        <li><a href="{{ route('admin.clients.index') }}" class="@if($is('clients')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-7m-1 0H4M16 11h-3M16 15h-2m-7 0H4m9-4H4"/><circle cx="20" cy="11" r="1.5"/><circle cx="20" cy="15" r="1.5"/></svg>
          Clients
        </a></li>
        <li><a href="{{ route('admin.orders.index') }}" class="@if($is('orders')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          Orders
        </a></li>
      </ul>

      <div class="ad-section-label">Signals</div>
      <ul class="ad-nav">
        <li><a href="{{ route('admin.service-requests.index') }}" class="@if($is('service-requests')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l1.5 1.5L9 9"/><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
          Service requests
        </a></li>
        <li><a href="{{ route('admin.contact-submissions.index') }}" class="@if($is('contact-submissions')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          Contact submissions
        </a></li>
        <li><a href="{{ route('admin.pricing-requests.index') }}" class="@if($is('pricing-requests')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          Pricing requests
        </a></li>
        <li><a href="{{ route('admin.activity-logs.index') }}" class="@if($is('activity-logs')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          Activity logs
        </a></li>
      </ul>

      <div class="ad-section-label">System</div>
      <ul class="ad-nav">
        <li><a href="{{ route('admin.settings') }}" class="@if($is('settings')) active @endif">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          Settings
        </a></li>
        {{-- "View public site" intentionally removed: admins are kept inside /thebestadmin. --}}
      </ul>
    </aside>

    <div class="ad-main">
      <header class="ad-top">
        <button type="button" class="ad-toggle" id="adToggle" aria-label="Toggle navigation">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <h1>@yield('title', 'Admin')</h1>
        <div class="user">
          <span class="avatar">{{ auth()->user()?->initials ?? 'AD' }}</span>
          <span class="user-name">{{ auth()->user()?->first_name ?? 'Admin' }}</span>
          <form method="POST" action="{{ route('admin.logout') }}">@csrf
            <button class="signout" type="submit">Sign out</button>
          </form>
        </div>
      </header>

      <main class="ad-body">
        @if(session('flash'))
          <div class="ad-flash">{{ session('flash') }}</div>
        @endif
        @yield('content')
      </main>
    </div>
  </div>

  <script>
    (function () {
      const t = document.getElementById('adToggle');
      const s = document.getElementById('adShell');
      t?.addEventListener('click', () => s.classList.toggle('drawer-open'));
      // Close drawer when clicking a nav link on mobile
      document.querySelectorAll('.ad-side a').forEach(a => a.addEventListener('click', () => {
        if (window.innerWidth < 980) s.classList.remove('drawer-open');
      }));
    })();
  </script>
  @stack('admin-scripts')
</body>
</html>
