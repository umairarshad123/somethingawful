@extends('layouts.app')
@section('title', 'Website Security Implementation — Digirisers')
@section('description', 'WAF, security headers, malware scanning, brute-force protection, and the standard hardening checklist applied to your live site.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .se-hero { padding: 90px 0 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; }
    .se-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 16px; }
    .se-hero h1 em { color: #dc2626; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .se-hero .tag { font-size:.74rem; font-weight:700; color:#991b1b; background:#fee2e2; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .se-hero p.lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 480px; }
    .se-hero figure { aspect-ratio: 4/3; border-radius: 22px; overflow: hidden; }
    .se-hero figure img { width: 100%; height: 100%; object-fit: cover; }
    .se-cards { padding: 70px 0; background: #fef2f2; border-top: 1px solid #fecaca; }
    .se-cards h2 { text-align: center; max-width: 600px; margin: 0 auto 36px; }
    .se-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; max-width: 1100px; margin: 0 auto; }
    .se-card { padding: 28px; background: #fff; border: 1px solid #fecaca; border-radius: 16px; transition: transform .25s ease, border-color .25s ease; }
    .se-card:hover { transform: translateY(-3px); border-color: #dc2626; }
    .se-card .icon { width: 40px; height: 40px; border-radius: 10px; background: #fee2e2; color: #dc2626; display: grid; place-items: center; margin-bottom: 14px; }
    .se-card h3 { font-size: 1.05rem; margin: 0 0 8px; }
    .se-card p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .se-hero { grid-template-columns: 1fr; } .se-grid { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container se-hero">
    <div>
      <span class="tag">Security · website</span>
      <h1>The implementation, not the <em>checklist email</em>.</h1>
      <p class="lede">"Update your CMS plugins" is advice. We do the work: a WAF in front of your site, security headers configured, brute-force protection live, file-integrity monitoring running, and an automated nightly scan that flags any new file with sketchy patterns.</p>
      <p style="margin-top:24px;">
        @auth
          <a href="{{ route('contact') }}?service=security-implementation" class="btn btn-primary">Harden the site →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>
    </div>
    <figure><img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=1200&q=80&auto=format&fit=crop" alt="Security operations"></figure>
  </section>

  <section class="se-cards">
    <div class="container">
      <h2>What gets implemented.</h2>
      <div class="se-grid">
        <div class="se-card">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
          <h3>WAF in front</h3>
          <p>Cloudflare or AWS WAF with OWASP-top-10 rule sets enabled, rate limiting, and bot challenge for endpoints with abuse history.</p>
        </div>
        <div class="se-card">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"/><path d="M21 12c0 4.97-4.03 9-9 9-4.97 0-9-4.03-9-9 0-4.97 4.03-9 9-9 1.5 0 2.91.36 4.16 1"/></svg></span>
          <h3>Security headers</h3>
          <p>HSTS, CSP, X-Frame-Options, Referrer-Policy, Permissions-Policy. CSP tuned to your stack so nothing legitimate breaks.</p>
        </div>
        <div class="se-card">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11v3a4 4 0 0 1-4 4H7l-5 4V5a4 4 0 0 1 4-4h11a4 4 0 0 1 4 4v6z"/></svg></span>
          <h3>Brute-force protection</h3>
          <p>Login endpoints rate-limited, CAPTCHA on N failures, lockout policies, IP-based reputation scoring on suspicious patterns.</p>
        </div>
        <div class="se-card">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></span>
          <h3>File integrity monitoring</h3>
          <p>Daily diff against a known-clean snapshot. Alert on new PHP files in upload directories. Catches webshells before they're abused.</p>
        </div>
        <div class="se-card">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></span>
          <h3>Auto-update policy</h3>
          <p>Core, plugins, dependencies — auto-updated on a schedule that respects your release window. Critical patches go immediately.</p>
        </div>
        <div class="se-card">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3l18 18"/><path d="M10.59 5.41A2 2 0 0 1 12 5h7a2 2 0 0 1 2 2v7a2 2 0 0 1-.41 1.41M21 21H4a1 1 0 0 1-1-1V4"/></svg></span>
          <h3>Removal of attack surface</h3>
          <p>Disabled XML-RPC, hidden version strings, unused plugins purged, default admin URLs renamed, error verbosity reduced in prod.</p>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
