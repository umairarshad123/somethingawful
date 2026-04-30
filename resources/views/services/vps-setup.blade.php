@extends('layouts.app')
@section('title', 'VPS Setup & Hardening — Digirisers')
@section('description', 'A production-grade VPS configured from scratch — provisioned, hardened, monitored, and handed off with a runbook your team can actually use.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .vp { padding: 100px 0 80px; background: #fafafa; }
    .vp h1 { font-size: clamp(2.2rem, 4.4vw, 3.4rem); margin: 14px 0 16px; max-width: 760px; }
    .vp h1 em { color: #475569; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .vp .tag { font-size:.74rem; font-weight:700; color:#1e293b; background:#e2e8f0; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .vp .lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 600px; }
    .vp-term { background: #0a0a0a; color: #4ade80; padding: 22px; border-radius: 14px; font-family: var(--font-mono); font-size: .82rem; line-height: 1.7; margin: 50px 0; max-width: 880px; }
    .vp-term .prompt { color: #71717a; }
    .vp-term .ok { color: #4ade80; }
    .vp-term .com { color: #fbbf24; }
    .vp-step { padding: 70px 0; background: #fff; border-top: 1px solid var(--line); }
    .vp-step h2 { text-align: center; margin: 0 0 36px; max-width: 580px; margin: 0 auto 36px; }
    .vp-list { max-width: 780px; margin: 0 auto; counter-reset: vp; display: grid; gap: 12px; }
    .vp-item { counter-increment: vp; display: grid; grid-template-columns: 50px 1fr; gap: 18px; padding: 22px; background: #f8fafc; border: 1px solid var(--line); border-radius: 12px; }
    .vp-item::before { content: counter(vp, decimal-leading-zero); font-family: var(--font-mono); font-weight: 700; color: #475569; font-size: .82rem; }
    .vp-item h3 { font-size: 1rem; margin: 0 0 4px; }
    .vp-item p { color: var(--muted); margin: 0; font-size: .92rem; line-height: 1.55; }
    @media (max-width: 720px) { .vp-term { font-size: .72rem; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container vp">
    <span class="tag">VPS · setup &amp; hardening</span>
    <h1 style="margin-top:14px;">A server that's <em>actually</em> production-ready.</h1>
    <p class="lede">"I just rented a $5 droplet and ran apt install nginx" is fine for a hobby project. Production needs the boring work done correctly: SSH hardened, firewall configured, fail2ban active, automatic security patching, log shipping, and a backup strategy that's been tested by actually restoring once.</p>
    <p style="margin-top:22px;">
      @auth
        <a href="{{ route('contact') }}?service=vps-setup" class="btn btn-primary">Provision the box →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth
    </p>

    <pre class="vp-term"><span class="prompt">root@server:~#</span> ufw status
Status: active
To                         Action      From
--                         ------      ----
22/tcp ALLOW <span class="com"># SSH (key-only)</span>
80/tcp ALLOW <span class="com"># HTTP → HTTPS redirect</span>
443/tcp ALLOW <span class="com"># HTTPS</span>
<span class="prompt">root@server:~#</span> systemctl status fail2ban
<span class="ok">● fail2ban.service - Fail2Ban Service</span>
<span class="ok">  Active: active (running) since Mon</span>
<span class="prompt">root@server:~#</span> ./check-hardening.sh
<span class="ok">[OK] Root SSH disabled</span>
<span class="ok">[OK] Password auth disabled</span>
<span class="ok">[OK] Unattended security upgrades enabled</span>
<span class="ok">[OK] Last backup verified: 14m ago</span></pre>
  </section>

  <section class="vp-step">
    <div class="container">
      <h2>What ships with the deployment.</h2>
      <div class="vp-list">
        <div class="vp-item"><div><h3>Provisioned + sized</h3><p>Right-sized VPS on DigitalOcean, Hetzner, AWS, or your provider of choice. We'll right-size based on your actual load profile, not a guess.</p></div></div>
        <div class="vp-item"><div><h3>SSH hardened</h3><p>Key-only auth, root login disabled, custom port if you insist, fail2ban active, login alerts to Slack.</p></div></div>
        <div class="vp-item"><div><h3>UFW firewall</h3><p>Default deny inbound, allow only what's needed, IP allowlists where appropriate. Documented why each port is open.</p></div></div>
        <div class="vp-item"><div><h3>Auto-patching</h3><p>Unattended security upgrades enabled. Daily cron checks. Reboots scheduled in your maintenance window only.</p></div></div>
        <div class="vp-item"><div><h3>Backups + restore tested</h3><p>Daily snapshots to a separate region. We perform an actual restore as the final sign-off step. Yes, really.</p></div></div>
        <div class="vp-item"><div><h3>Monitoring + alerts</h3><p>Disk, CPU, memory, swap, network — surfaced in Grafana or your stack. PagerDuty / Slack alerts on threshold breach.</p></div></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
