@extends('layouts.app')
@section('title', 'Dispute Fox Setup — Digirisers')
@section('description', 'Dispute Fox configured for high-volume credit-repair operations — AI-assisted dispute logic, scaled letter generation, and clean reporting.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .df { background: #18181b; color: #fff; padding: 100px 0; min-height: 90vh; position: relative; overflow: hidden; }
    .df::after { content: ""; position: absolute; top: -200px; left: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(244,114,182,.15), transparent 70%); }
    .df .container { position: relative; }
    .df-tag { font-size:.72rem; font-weight:700; color:#f472b6; background:rgba(244,114,182,.1); padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; border: 1px solid rgba(244,114,182,.25); }
    .df h1 { color: #fff; font-size: clamp(2.2rem, 4.4vw, 3.4rem); margin: 14px 0 18px; }
    .df h1 em { color: #f472b6; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .df .lede { color: #d4d4d8; font-size: 1.06rem; max-width: 600px; line-height: 1.65; }
    .df-flow { display: flex; gap: 4px; margin-top: 50px; padding: 22px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 16px; overflow-x: auto; }
    .df-flow .step { flex: 1; min-width: 140px; padding: 18px; background: rgba(244,114,182,.08); border: 1px solid rgba(244,114,182,.25); border-radius: 10px; position: relative; }
    .df-flow .step strong { display: block; color: #fff; font-size: .96rem; margin-bottom: 6px; }
    .df-flow .step small { color: #a1a1aa; font-size: .8rem; line-height: 1.4; }
    .df-flow .step:not(:last-child)::after { content: "→"; position: absolute; right: -14px; top: 50%; transform: translateY(-50%); color: #f472b6; font-weight: 700; font-size: 1rem; z-index: 1; }
    .df-bar { background: #fafafa; color: var(--ink); padding: 70px 0; }
    .df-bar h2 { text-align: center; max-width: 580px; margin: 0 auto 32px; }
    .df-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; max-width: 980px; margin: 0 auto; }
    .df-row > div { padding: 28px; background: #fff; border: 1px solid var(--line); border-radius: 14px; }
    .df-row strong { display: block; color: #db2777; font-size: 2rem; line-height: 1; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 8px; }
    .df-row p { color: var(--muted); margin: 0; font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .df-row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="df">
    <div class="container">
      <span class="df-tag">Dispute Fox · setup</span>
      <h1>For credit-repair operators who've <em>outgrown</em> CRC.</h1>
      <p class="lede">Dispute Fox is the heavyweight — AI-assisted dispute generation, faster scaling, deeper customization. We configure it for high-volume operations: 200-2,000 active clients, multi-bureau dispute strategy, and team-level access controls.</p>
      <p style="margin-top:22px;">
        @auth
          <a href="{{ route('contact') }}?service=dispute-fox-setup" class="btn btn-primary">Plan migration →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>

      <div class="df-flow">
        <div class="step"><strong>Import</strong><small>CRC export → cleaned data → Dispute Fox</small></div>
        <div class="step"><strong>Configure</strong><small>Dispute strategy, reason codes, escalation rules</small></div>
        <div class="step"><strong>Train AI</strong><small>Letter templates, voice, compliance citations</small></div>
        <div class="step"><strong>Test</strong><small>10 sample clients run end-to-end before launch</small></div>
        <div class="step"><strong>Launch</strong><small>Hand-off with team training + ops manual</small></div>
      </div>
    </div>
  </section>

  <section class="df-bar">
    <div class="container">
      <h2>Why teams switch.</h2>
      <div class="df-row">
        <div><strong>3.4×</strong><p>Letter generation throughput vs. CRC manual templates. AI handles 80% of round-1 disputes.</p></div>
        <div><strong>−42%</strong><p>Median time-to-resolution. Faster cycle = better client retention = more referrals.</p></div>
        <div><strong>0</strong><p>Compliance violations in 24 months across our deployed Dispute Fox setups. We bake compliance into config.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
