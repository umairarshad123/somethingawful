@extends('layouts.app')
@section('title', 'Zoho CRM Setup — Digirisers')
@section('description', 'A Zoho CRM deployment shaped to your sales motion: modules, layouts, automations, reporting, and the integrations that connect Zoho to the rest of your stack.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .zo { padding: 90px 0; max-width: 880px; margin: 0 auto; text-align: center; }
    .zo .tag { display:inline-block; font-size:.74rem; font-weight:700; color:#1d4ed8; background:#eff6ff; padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .zo h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 18px 0 18px; }
    .zo h1 em { color: #1d4ed8; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .zo p { color: var(--muted); font-size: 1.08rem; max-width: 640px; margin: 0 auto 28px; line-height: 1.65; }
    .zo-photo { padding: 0 0 70px; }
    .zo-photo figure { max-width: 1100px; margin: 0 auto; aspect-ratio: 16/8; border-radius: 24px; overflow: hidden; }
    .zo-photo img { width: 100%; height: 100%; object-fit: cover; }
    .zo-grid { padding: 70px 0; background: #fff; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
    .zo-grid h2 { text-align: center; max-width: 580px; margin: 0 auto 36px; }
    .zo-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .zo-card { padding: 28px; background: #fafafa; border-radius: 14px; border: 1px solid var(--line); }
    .zo-card h3 { font-size: 1.05rem; margin: 0 0 8px; color: #1e3a8a; }
    .zo-card p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; text-align: left; }
    .zo-card .ch { font-family: var(--font-mono); font-size: .72rem; color: #1d4ed8; letter-spacing: .12em; }
    @media (max-width: 880px) { .zo-cards { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="zo">
    <span class="tag">Zoho CRM · setup</span>
    <h1>Zoho is <em>powerful</em>. Power without configuration is a tax.</h1>
    <p>Out of the box, Zoho ships with every module flipped on and almost nothing tailored. Your team ends up confused by 40 fields they don't use and unable to find the 5 they do. We strip it down to what you need, build the layouts your reps will actually adopt, and wire the integrations that connect Zoho to your real stack.</p>
    @auth
      <a href="{{ route('contact') }}?service=zoho-setup" class="btn btn-primary">Plan deployment →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="zo-photo">
    <figure><img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=1800&q=80&auto=format&fit=crop" alt="CRM and analytics screens"></figure>
  </section>

  <section class="zo-grid">
    <div class="container">
      <h2>The configuration we ship.</h2>
      <div class="zo-cards">
        <div class="zo-card"><span class="ch">CHAPTER 1</span><h3>Modules + layouts</h3><p>We turn off what you don't need, customize layouts, and add the lookups that match your industry — not Zoho's idea of a generic SaaS company.</p></div>
        <div class="zo-card"><span class="ch">CHAPTER 2</span><h3>Sales pipeline</h3><p>Stages, probabilities, win-rate tracking. Forecasting set up so you trust the number on Friday.</p></div>
        <div class="zo-card"><span class="ch">CHAPTER 3</span><h3>Workflow automations</h3><p>Lead assignment rules, follow-up reminders, stage-change notifications, deal-aging alerts — built around your operating cadence.</p></div>
        <div class="zo-card"><span class="ch">CHAPTER 4</span><h3>Email integration</h3><p>Two-way sync with Gmail/Outlook, signature templates, email-tracking pixels, and reply-detection that updates the timeline.</p></div>
        <div class="zo-card"><span class="ch">CHAPTER 5</span><h3>Reporting + dashboards</h3><p>Five reports that matter, on five dashboards mapped to roles. Not the 47-widget mess that ships by default.</p></div>
        <div class="zo-card"><span class="ch">CHAPTER 6</span><h3>Integrations + handoff</h3><p>Connect to Slack, QuickBooks, Stripe, your website forms. We hand off with a written runbook and a one-hour team training.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
