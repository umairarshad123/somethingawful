@extends('layouts.app')
@section('title', '2FA + RBAC Setup — Digirisers')
@section('description', 'Two-factor authentication and role-based access control implemented for your team — auditable, recoverable, and resistant to social engineering.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .tf { padding: 90px 0; }
    .tf-hero { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
    .tf h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; }
    .tf h1 em { color: #2563eb; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .tf .tag { font-size:.74rem; font-weight:700; color:#1e3a8a; background:#dbeafe; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .tf p.lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 480px; }
    .tf-roles { background: #fff; border: 1px solid var(--line); border-radius: 22px; padding: 28px; box-shadow: 0 30px 60px -30px rgba(11,16,32,.2); }
    .tf-roles h4 { margin: 0 0 16px; color: var(--ink); font-size: .92rem; font-family: var(--font-mono); letter-spacing: .08em; }
    .tf-roles .role { display: grid; grid-template-columns: 1fr auto; gap: 12px; padding: 14px 0; border-bottom: 1px dashed var(--line); align-items: center; }
    .tf-roles .role:last-child { border-bottom: 0; }
    .tf-roles .role strong { font-size: .92rem; }
    .tf-roles .role small { display: block; color: var(--soft); font-size: .8rem; margin-top: 2px; }
    .tf-roles .perms { font-family: var(--font-mono); font-size: .72rem; color: #1d4ed8; background: #eff6ff; padding: 4px 8px; border-radius: 6px; font-weight: 600; }
    .tf-list { padding: 60px 0; background: #f0f9ff; border-top: 1px solid var(--line); margin-top: 60px; }
    .tf-list h2 { text-align: center; max-width: 600px; margin: 0 auto 32px; }
    .tf-list ul { list-style: none; padding: 0; margin: 0; max-width: 760px; margin: 0 auto; display: grid; gap: 12px; }
    .tf-list li { padding: 18px 22px; background: #fff; border: 1px solid #bfdbfe; border-radius: 12px; display: grid; grid-template-columns: 24px 1fr; gap: 14px; }
    .tf-list svg { color: #1d4ed8; margin-top: 3px; }
    .tf-list strong { display: block; margin-bottom: 4px; }
    .tf-list span { color: var(--muted); font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .tf-hero { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container tf">
    <div class="tf-hero">
      <div>
        <span class="tag">2FA · RBAC</span>
        <h1>Access controls that <em>survive</em> a phishing attempt.</h1>
        <p class="lede">A breach almost always starts with one user with too much access getting their password compromised. Hardware-key 2FA + role-based access control limits the blast radius — if one account falls, the attacker can't pivot. We implement both, plus the audit trail.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=2fa-rbac" class="btn btn-primary">Plan the setup →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <div class="tf-roles">
        <h4>// SAMPLE ROLE MATRIX</h4>
        <div class="role"><div><strong>Owner</strong><small>full access · founders only</small></div><span class="perms">ALL</span></div>
        <div class="role"><div><strong>Admin</strong><small>users, billing, settings</small></div><span class="perms">RWX − DESTROY</span></div>
        <div class="role"><div><strong>Editor</strong><small>content, no settings</small></div><span class="perms">RW</span></div>
        <div class="role"><div><strong>Reviewer</strong><small>read + comment</small></div><span class="perms">R + C</span></div>
        <div class="role"><div><strong>Auditor</strong><small>logs only</small></div><span class="perms">R LOGS</span></div>
      </div>
    </div>
  </section>

  <section class="tf-list">
    <div class="container">
      <h2>What's included.</h2>
      <ul>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Hardware-key 2FA where available</strong><span>WebAuthn / passkeys preferred. TOTP fallback. SMS only as last resort and never for admins.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Role matrix designed for your team</strong><span>5-7 roles, mapped to actual job functions. Documented permissions per role. No "everyone is admin."</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Audit log + alerts</strong><span>Every privileged action logged. Anomalies (logins from new geo, role escalation, bulk export) ping Slack within 60 seconds.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Recovery flow tested</strong><span>What happens when a user loses their phone? When the admin leaves? We document and rehearse it before launch.</span></div></li>
      </ul>
    </div>
  </section>

  @include('partials.footer')
@endsection
