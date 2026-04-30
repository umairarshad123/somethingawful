@extends('layouts.app')
@section('title', 'Referral / Affiliate System — Digirisers')
@section('description', 'A referral or affiliate program built into your stack — tracking, attribution, payouts, and the dashboards that keep partners motivated.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .rf-hero { padding: 80px 0; }
    .rf-hero .row { display: grid; grid-template-columns: 1.1fr 1fr; gap: 50px; align-items: center; }
    .rf-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; }
    .rf-hero h1 em { color: #2563eb; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .rf-hero .tag { font-size:.74rem; font-weight:700; color:#1e40af; background:#dbeafe; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .rf-hero p.lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 480px; }
    .rf-hero figure { aspect-ratio: 4/3; border-radius: 22px; overflow: hidden; box-shadow: 0 40px 80px -40px rgba(11,16,32,.35); }
    .rf-hero figure img { width: 100%; height: 100%; object-fit: cover; }
    .rf-cards { padding: 60px 0; background: #f0f9ff; border-top: 1px solid var(--line); }
    .rf-cards h2 { text-align: center; max-width: 600px; margin: 0 auto 40px; }
    .rf-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .rf-cell { padding: 24px 22px; background: #fff; border: 1px solid #bfdbfe; border-radius: 14px; }
    .rf-cell .stat { font-size: 1.8rem; font-weight: 800; color: #2563eb; line-height: 1; letter-spacing: -0.03em; margin-bottom: 8px; }
    .rf-cell h3 { font-size: 1rem; margin: 0 0 6px; }
    .rf-cell p { font-size: .88rem; color: var(--muted); margin: 0; line-height: 1.55; }
    .rf-flow { padding: 70px 0; }
    .rf-flow h2 { max-width: 580px; margin: 0 0 30px; }
    .rf-flow p { color: var(--muted); line-height: 1.65; max-width: 640px; }
    @media (max-width: 880px) { .rf-hero .row, .rf-row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container rf-hero">
    <div class="row">
      <div>
        <span class="tag">Referrals · affiliates</span>
        <h1>The growth channel you can <em>turn on</em>, not buy.</h1>
        <p class="lede">Paid ads scale with budget. Referrals scale with delight. We build the system that lets your existing customers and external partners refer business — with proper tracking, automatic payouts, and dashboards that keep them showing up.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=referral-system" class="btn btn-primary">Plan the launch →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <figure><img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1200&q=80&auto=format&fit=crop" alt="Handshake on referral"></figure>
    </div>
  </section>

  <section class="rf-cards">
    <div class="container">
      <h2>What gets configured.</h2>
      <div class="rf-row">
        <div class="rf-cell"><span class="stat">∞</span><h3>Unique partner links</h3><p>Auto-generated trackable URLs per partner. Cookie + first-party tracking for full attribution.</p></div>
        <div class="rf-cell"><span class="stat">$$</span><h3>Payout automation</h3><p>Stripe Connect, PayPal, ACH. Auto-payout on validated conversion, no manual reconciliation.</p></div>
        <div class="rf-cell"><span class="stat">📊</span><h3>Partner dashboard</h3><p>Real-time stats: clicks, signups, paid commissions, pending earnings. Their own login.</p></div>
        <div class="rf-cell"><span class="stat">🔔</span><h3>Activity nudges</h3><p>Auto-emails when partners go quiet. Leaderboard. Tier upgrades for top performers.</p></div>
      </div>
    </div>
  </section>

  <section class="rf-flow">
    <div class="container">
      <h2>Two-sided incentives, with the math worked out.</h2>
      <p>The right referral economics depend on your LTV, CAC, and gross margin. Too generous and you lose money on every referred deal. Too stingy and partners stop sharing. We model it for your business — typically 10-25% of first-year revenue with a recurring tail — and configure the system to enforce the rules automatically.</p>
    </div>
  </section>

  @include('partials.footer')
@endsection
