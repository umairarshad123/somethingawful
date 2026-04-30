@extends('layouts.app')
@section('title', 'Lead Management System — Digirisers')
@section('description', 'A lead management system that captures, scores, routes, and follows up on every inbound — without dropping anyone in the gap between systems.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .lm { padding: 90px 0; }
    .lm-hero { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
    .lm h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; }
    .lm h1 em { color: #0d9488; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .lm .tag { font-size:.74rem; font-weight:700; color:#115e59; background:#ccfbf1; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .lm .lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 480px; }
    .lm-stack { background: #fff; border-radius: 22px; padding: 28px; box-shadow: 0 30px 60px -30px rgba(11,16,32,.2); border: 1px solid var(--line); }
    .lm-stack h4 { margin: 0 0 16px; color: var(--ink); font-size: .92rem; font-family: var(--font-mono); letter-spacing: .08em; }
    .lm-stack .lead { padding: 14px 16px; background: #f0fdfa; border-left: 3px solid #0d9488; border-radius: 8px; margin-bottom: 8px; font-size: .88rem; }
    .lm-stack .lead strong { display: block; color: var(--ink); margin-bottom: 4px; }
    .lm-stack .lead small { color: var(--soft); font-family: var(--font-mono); font-size: .76rem; }
    .lm-stack .lead .score { float: right; font-family: var(--font-mono); font-weight: 700; color: #0d9488; }
    .lm-flow { padding: 80px 0; background: #f0fdfa; border-top: 1px solid #ccfbf1; margin-top: 60px; }
    .lm-flow h2 { text-align: center; margin: 0 0 16px; max-width: 600px; margin: 0 auto 16px; }
    .lm-flow .sub { text-align: center; color: var(--muted); max-width: 540px; margin: 0 auto 40px; line-height: 1.6; }
    .lm-vertical { max-width: 720px; margin: 0 auto; display: grid; gap: 14px; }
    .lm-step { padding: 22px 26px; background: #fff; border-radius: 14px; border: 1px solid #ccfbf1; display: grid; grid-template-columns: 60px 1fr; gap: 24px; align-items: center; }
    .lm-step .n { font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; color: #0d9488; line-height: 1; }
    .lm-step h3 { font-size: 1.05rem; margin: 0 0 6px; }
    .lm-step p { color: var(--muted); margin: 0; font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .lm-hero { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container lm">
    <div class="lm-hero">
      <div>
        <span class="tag">Lead management · system</span>
        <h1>Stop letting leads <em>fall through</em> the cracks.</h1>
        <p class="lede">Most B2B businesses lose 18-32% of their inbound between "form submitted" and "rep called." It's not malice — it's that the lead has to traverse 4 systems with manual handoffs. We build the system that makes those handoffs automatic, scored, and tracked.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=lead-management" class="btn btn-primary">Plan the build →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <div class="lm-stack">
        <h4>// LIVE LEAD QUEUE</h4>
        <div class="lead"><span class="score">A · 92</span><strong>Sarah Chen, Acme Corp</strong><small>Source: Google Ads · 3min ago</small></div>
        <div class="lead"><span class="score">A · 88</span><strong>Michael Park, Trellium</strong><small>Source: LinkedIn · 12min ago</small></div>
        <div class="lead" style="background:#fef3c7; border-left-color:#d97706;"><span class="score" style="color:#d97706;">B · 64</span><strong>Jamie Holt, BlueSpark</strong><small>Source: Organic · 18min ago</small></div>
        <div class="lead" style="background:#fafafa; border-left-color:#94a3b8;"><span class="score" style="color:#475569;">C · 41</span><strong>Alex Reed, IndieCo</strong><small>Source: Webinar · 26min ago</small></div>
      </div>
    </div>
  </section>

  <section class="lm-flow">
    <div class="container">
      <h2>How a single lead flows through the system.</h2>
      <p class="sub">From form submission to closed-won, with no manual handoffs and full audit trail.</p>
      <div class="lm-vertical">
        <div class="lm-step"><span class="n">01</span><div><h3>Capture</h3><p>Form, chat, email, ad, partner referral — all sources land in one normalized table with UTM and source attribution.</p></div></div>
        <div class="lm-step"><span class="n">02</span><div><h3>Enrich</h3><p>Clearbit / Apollo / Hunter pulls firmographic data: company size, industry, tech stack. Visible to reps in 8 seconds.</p></div></div>
        <div class="lm-step"><span class="n">03</span><div><h3>Score</h3><p>Rule-based or model-based. Combines firmographic fit + behavioral intent. Outputs A/B/C with reasoning.</p></div></div>
        <div class="lm-step"><span class="n">04</span><div><h3>Route</h3><p>Round-robin among reps, weighted by tier. SLAs enforced — if a rep doesn't engage in 30 minutes, the lead bounces.</p></div></div>
        <div class="lm-step"><span class="n">05</span><div><h3>Nurture</h3><p>B and C leads enter automated sequences. They graduate up if they re-engage. They graduate out if they go cold.</p></div></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
