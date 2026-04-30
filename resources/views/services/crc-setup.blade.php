@extends('layouts.app')
@section('title', 'Credit Repair Cloud Setup — Digirisers')
@section('description', 'A Credit Repair Cloud deployment with dispute automation, intake forms, client portals, and the metro-2 dispute logic configured to compliance.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .cr { padding: 90px 0; }
    .cr h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; max-width: 720px; }
    .cr h1 em { color: #047857; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .cr .tag { font-size:.74rem; font-weight:700; color:#065f46; background:#d1fae5; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .cr p.lede { color: var(--muted); font-size: 1.06rem; max-width: 600px; line-height: 1.65; }
    .cr-row { padding: 60px 0; display: grid; grid-template-columns: 1.4fr 1fr; gap: 60px; align-items: center; }
    .cr-row figure { aspect-ratio: 4/5; border-radius: 22px; overflow: hidden; box-shadow: 0 50px 100px -40px rgba(11,16,32,.4); }
    .cr-row figure img { width: 100%; height: 100%; object-fit: cover; }
    .cr-row h2 { margin: 0 0 14px; }
    .cr-row p { color: var(--muted); line-height: 1.65; margin: 0 0 20px; }
    .cr-clean { padding: 70px 0; background: #f0fdf4; border-top: 1px solid #bbf7d0; }
    .cr-clean h2 { text-align: center; margin: 0 0 36px; max-width: 600px; margin: 0 auto 36px; }
    .cr-checks { max-width: 760px; margin: 0 auto; display: grid; gap: 12px; }
    .cr-checks div { padding: 16px 22px; background: #fff; border: 1px solid #bbf7d0; border-radius: 12px; display: grid; grid-template-columns: 24px 1fr; gap: 14px; }
    .cr-checks svg { color: #047857; margin-top: 3px; }
    .cr-checks strong { display: block; margin-bottom: 4px; }
    .cr-checks span { color: var(--muted); font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .cr-row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container cr">
    <span class="tag">Credit repair · CRC</span>
    <h1 style="margin-top:14px;">A CRC backend that <em>compounds</em> as your client base grows.</h1>
    <p class="lede">Credit Repair Cloud is the industry standard, but the difference between a 50-client operation and a 500-client one is configuration. We deploy intake, dispute logic, client communication, and reporting in a way that scales without breaking — and stays inside CROA + state compliance.</p>
    <p style="margin-top:22px;">
      @auth
        <a href="{{ route('contact') }}?service=crc-setup" class="btn btn-primary">Plan deployment →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth
    </p>

    <div class="cr-row">
      <div>
        <h2>Configured for your specific dispute strategy.</h2>
        <p>Round-1 vs. round-2 vs. escalation letters, metro-2 reason codes, FCRA/FDCPA/CROA citation density, factual-dispute language vs. legal-citation language — every dispute strategy we've seen work, configured to your default playbook.</p>
        <p>We bring the templates and reason codes; you tell us which paragraphs match your operating philosophy. The result: clients hit response rates 30-45% above CRC defaults.</p>
      </div>
      <figure><img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1000&q=80&auto=format&fit=crop" alt="Financial documents"></figure>
    </div>
  </section>

  <section class="cr-clean">
    <div class="container">
      <h2>What's locked in before you onboard the first client.</h2>
      <div class="cr-checks">
        <div><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Branded client portal</strong><span>Logo, color, custom subdomain. Clients see your brand, not CRC's.</span></div></div>
        <div><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Compliance-vetted onboarding</strong><span>Disclosure flow, agreement signature, ID verification — all sequenced to satisfy CROA and your state's specific requirements.</span></div></div>
        <div><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Automated round-based disputes</strong><span>Round 1 → wait → review → round 2 escalation logic. Time-based triggers, not manual reminders.</span></div></div>
        <div><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Affiliate + referral tracking</strong><span>Built-in CRC affiliate logic configured to your commission structure. Auto-credit, auto-payout, dashboard for affiliates.</span></div></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
