@extends('layouts.app')
@section('title', 'Full AI Employee Deployment — Digirisers')
@section('description', 'A purpose-built AI employee — not a chatbot — that owns one specific role end-to-end: capable, accountable, and observable.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ae-hero { position: relative; padding: 120px 0 80px; text-align: center; overflow: hidden; }
    .ae-hero::before { content: ""; position: absolute; inset: 0; background: radial-gradient(ellipse 60% 80% at 50% 0%, #fce7f3 0%, transparent 60%); pointer-events: none; }
    .ae-hero .container { position: relative; max-width: 880px; }
    .ae-hero h1 { font-size: clamp(2.6rem, 5.5vw, 4rem); margin: 16px 0 18px; letter-spacing: -0.04em; }
    .ae-hero h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; background: linear-gradient(135deg,#ec4899,#8b5cf6); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .ae-hero p { font-size: 1.14rem; color: var(--muted); max-width: 640px; margin: 0 auto 32px; line-height: 1.65; }
    .ae-tag { display:inline-block; font-size:.74rem; font-weight:700; color:#a21caf; background:#fdf4ff; padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .ae-img { max-width: 1100px; margin: 60px auto; aspect-ratio: 21/9; border-radius: 28px; overflow: hidden; box-shadow: 0 60px 120px -50px rgba(11,16,32,.5); }
    .ae-img img { width: 100%; height: 100%; object-fit: cover; }
    .ae-roles { padding: 80px 0; background: #fafafa; }
    .ae-roles h2 { text-align: center; margin: 0 0 12px; max-width: 700px; margin: 0 auto; }
    .ae-roles .sub { text-align: center; color: var(--muted); max-width: 580px; margin: 12px auto 50px; line-height: 1.6; }
    .ae-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
    .ae-role { background: #fff; border-radius: 18px; padding: 28px; border: 1px solid var(--line); transition: transform .25s ease, box-shadow .25s ease; }
    .ae-role:hover { transform: translateY(-4px); box-shadow: 0 30px 60px -30px rgba(168,85,247,.25); }
    .ae-role .icon { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg,#ec4899,#8b5cf6); color: #fff; display: grid; place-items: center; margin-bottom: 16px; }
    .ae-role h3 { font-size: 1.05rem; margin: 0 0 8px; }
    .ae-role p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .ae-grid { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ae-hero">
    <div class="container">
      <span class="ae-tag">AI employee · full deployment</span>
      <h1>Hire an <em>AI specialist</em>, not a generalist chatbot.</h1>
      <p>A general-purpose assistant ends up doing none of your jobs particularly well. We design, build, and deploy a purpose-built AI employee for one specific role — with its own tools, memory, KPIs, and a manager (you) to whom it reports. Like onboarding a new hire who never sleeps.</p>
      @auth
        <a href="{{ route('contact') }}?service=full-ai-employee" class="btn btn-primary btn-lg">Spec the role →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary btn-lg">Sign in to view pricing</a>
      @endauth
    </div>
  </section>

  <figure class="ae-img"><img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=1800&q=80&auto=format&fit=crop" alt="AI employee concept"></figure>

  <section class="ae-roles">
    <div class="container">
      <h2>Roles we've shipped this for.</h2>
      <p class="sub">Each one runs in production today, owns its own KPIs, and gets reviewed weekly like any other employee.</p>
      <div class="ae-grid">
        <div class="ae-role">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
          <h3>Inbound SDR</h3>
          <p>Owns lead qualification end-to-end. Books 14 sales-qualified meetings per week with no human in the loop until the call itself.</p>
        </div>
        <div class="ae-role">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
          <h3>Tier-1 support agent</h3>
          <p>Resolves 78% of tickets autonomously, escalates the rest with full context. Tracks NPS per resolution.</p>
        </div>
        <div class="ae-role">
          <span class="icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></span>
          <h3>Operations dispatcher</h3>
          <p>Watches inbound orders, assigns to the right team, balances workload, escalates anomalies — for an e-commerce ops team of seven.</p>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
