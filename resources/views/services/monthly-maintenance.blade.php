@extends('layouts.app')
@section('title', 'Monthly Maintenance & Security Retainer — Digirisers')
@section('description', 'Monthly maintenance, security patching, uptime monitoring, and quarterly disaster-recovery drills — for sites you can\'t afford to think about.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .mm { padding: 90px 0 80px; }
    .mm h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; max-width: 720px; }
    .mm h1 em { color: #16a34a; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .mm .tag { font-size:.74rem; font-weight:700; color:#15803d; background:#dcfce7; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .mm p.lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 600px; margin: 0 0 28px; }
    .mm-photo { padding: 0 0 60px; }
    .mm-photo figure { max-width: 1100px; margin: 0 auto; aspect-ratio: 21/9; border-radius: 24px; overflow: hidden; }
    .mm-photo img { width: 100%; height: 100%; object-fit: cover; }
    .mm-cal { padding: 70px 0; background: #f0fdf4; border-top: 1px solid #bbf7d0; }
    .mm-cal h2 { text-align: center; max-width: 580px; margin: 0 auto 30px; }
    .mm-cal-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; max-width: 1000px; margin: 0 auto; }
    .mm-cal-grid > div { padding: 22px 18px; background: #fff; border: 1px solid #bbf7d0; border-radius: 12px; }
    .mm-cal-grid .when { font-family: var(--font-mono); font-size: .72rem; color: #15803d; letter-spacing: .12em; }
    .mm-cal-grid h3 { font-size: 1rem; margin: 6px 0 4px; }
    .mm-cal-grid p { font-size: .88rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .mm-cal-grid { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container mm">
    <span class="tag">Maintenance · monthly retainer</span>
    <h1 style="margin-top:14px;">A site you don't have to <em>think about</em>.</h1>
    <p class="lede">Most sites are fine — until they aren't. The plugin auto-update breaks the homepage. The SSL forgets to renew. A scanner-bot exploits an unpatched CVE. We tend the boring infrastructure work on a schedule so the site keeps working without you noticing.</p>
    @auth
      <a href="{{ route('contact') }}?service=monthly-maintenance" class="btn btn-primary">Start the retainer →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="mm-photo">
    <figure><img src="https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?w=1800&q=80&auto=format&fit=crop" alt="Server racks and infrastructure"></figure>
  </section>

  <section class="mm-cal">
    <div class="container">
      <h2>What's on the calendar.</h2>
      <div class="mm-cal-grid">
        <div><span class="when">DAILY</span><h3>Uptime monitoring</h3><p>Synthetic checks every 60 seconds from 5 regions. Page if down for 3 consecutive checks.</p></div>
        <div><span class="when">WEEKLY</span><h3>Security patches</h3><p>Plugin + dependency review. Critical CVEs patched same week. Routine updates monthly.</p></div>
        <div><span class="when">MONTHLY</span><h3>Backup verification</h3><p>Restore one backup to a staging environment. Confirm it boots. Document any drift.</p></div>
        <div><span class="when">QUARTERLY</span><h3>DR drill</h3><p>Simulated region failure or DB corruption. Time-to-recovery measured. Findings documented.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
