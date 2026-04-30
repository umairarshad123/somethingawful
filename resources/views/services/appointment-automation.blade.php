@extends('layouts.app')
@section('title', 'Appointment & Calendar Automation — Digirisers')
@section('description', 'Cal.com or Calendly configured for round-robin booking, qualifier flows, calendar holds, and a no-show recovery sequence that cuts misses by half.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ap { padding: 90px 0; max-width: 880px; margin: 0 auto; text-align: center; }
    .ap .tag { display:inline-block; font-size:.74rem; font-weight:700; color:#7e22ce; background:#faf5ff; padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .ap h1 { font-size: clamp(2.2rem, 4.5vw, 3.4rem); margin: 18px 0 18px; }
    .ap h1 em { color: #9333ea; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .ap p { color: var(--muted); font-size: 1.08rem; max-width: 600px; margin: 0 auto 28px; line-height: 1.65; }
    .ap-photo { padding: 0 0 70px; }
    .ap-photo figure { max-width: 1100px; margin: 0 auto; aspect-ratio: 21/9; border-radius: 24px; overflow: hidden; }
    .ap-photo img { width: 100%; height: 100%; object-fit: cover; }
    .ap-vs { padding: 80px 0; }
    .ap-vs h2 { text-align: center; max-width: 580px; margin: 0 auto 30px; }
    .ap-table { display: grid; grid-template-columns: 1.4fr 1fr 1fr; max-width: 920px; margin: 0 auto; border: 1px solid var(--line); border-radius: 16px; overflow: hidden; }
    .ap-table > div { padding: 14px 22px; border-bottom: 1px solid var(--line); text-align: left; }
    .ap-table > div:nth-last-child(-n+3) { border-bottom: 0; }
    .ap-table .head { background: var(--ink); color: #fff; font-size: .92rem; font-weight: 700; }
    .ap-table .label { background: #fff; font-weight: 600; font-size: .92rem; }
    .ap-table .stock { background: #fafafa; color: var(--soft); font-size: .9rem; }
    .ap-table .ours { background: #faf5ff; color: #6b21a8; font-size: .9rem; font-weight: 500; }
    @media (max-width: 720px) { .ap-table { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ap">
    <span class="tag">Calendar · automation</span>
    <h1>Booking that <em>qualifies</em> before the call starts.</h1>
    <p>Default Calendly: pick a time, see you there. That's fine for friend coffees. For sales, you want to qualify, route to the right rep, hold the calendar against double-booking, send pre-call prep, and trigger a no-show flow if it happens. We configure all of that.</p>
    @auth
      <a href="{{ route('contact') }}?service=appointment-automation" class="btn btn-primary">Plan the setup →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="ap-photo">
    <figure><img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1800&q=80&auto=format&fit=crop" alt="Calendar planning"></figure>
  </section>

  <section class="ap-vs">
    <div class="container">
      <h2>Default flow vs. what we ship.</h2>
      <div class="ap-table">
        <div class="head">Capability</div>
        <div class="head">Stock Calendly</div>
        <div class="head">Our config</div>

        <div class="label">Qualifier questions</div>
        <div class="stock">Optional, ignored</div>
        <div class="ours">Required, used to route</div>

        <div class="label">Round-robin</div>
        <div class="stock">Random</div>
        <div class="ours">Skill + workload weighted</div>

        <div class="label">Pre-call prep</div>
        <div class="stock">Generic confirmation</div>
        <div class="ours">Personalized brief sent to rep</div>

        <div class="label">No-show handling</div>
        <div class="stock">Nothing</div>
        <div class="ours">Auto-rebook flow + nurture sequence</div>

        <div class="label">CRM sync</div>
        <div class="stock">Email log</div>
        <div class="ours">Native opportunity created with full context</div>

        <div class="label">Buffer logic</div>
        <div class="stock">Fixed minutes</div>
        <div class="ours">Variable by meeting type + rep</div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
