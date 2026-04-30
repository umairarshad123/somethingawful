@extends('layouts.app')
@section('title', 'CRO Audit + Implementation — Digirisers')
@section('description', 'A conversion rate optimization audit grounded in real session data — followed by the actual implementation, not a 40-page PDF for someone else to ignore.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .cro { padding: 80px 0 100px; }
    .cro-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 60px; align-items: center; }
    .cro-grid figure { aspect-ratio: 1; border-radius: 24px; overflow: hidden; }
    .cro-grid figure img { width: 100%; height: 100%; object-fit: cover; }
    .cro h1 { font-size: clamp(2.2rem, 4.5vw, 3.4rem); margin: 16px 0 16px; }
    .cro h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #c026d3; }
    .cro-eyebrow { display: inline-block; font-size: .72rem; font-weight: 700; color: #a21caf; background: #fae8ff; padding: 6px 12px; border-radius: 999px; letter-spacing: .12em; text-transform: uppercase; }
    .cro-body { padding: 70px 0; background: #fafaf9; }
    .cro-body h2 { text-align: center; max-width: 580px; margin: 0 auto 36px; }
    .cro-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
    .cro-card { background: #fff; border-radius: 18px; padding: 28px; border: 1px solid var(--line); position: relative; overflow: hidden; transition: transform .25s ease, box-shadow .25s ease; }
    .cro-card:hover { transform: translateY(-3px); box-shadow: 0 30px 60px -30px rgba(192,38,211,.25); }
    .cro-card::after { content: ""; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #c026d3, #db2777); transform: scaleX(0); transform-origin: left; transition: transform .35s ease; }
    .cro-card:hover::after { transform: scaleX(1); }
    .cro-card .step { font-family: var(--font-mono); font-size: .76rem; color: #c026d3; letter-spacing: .12em; }
    .cro-card h3 { margin: 8px 0 8px; font-size: 1.08rem; }
    .cro-card p { color: var(--muted); margin: 0; font-size: .94rem; line-height: 1.6; }
    @media (max-width: 880px) { .cro-grid, .cro-cards { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container cro">
    <div class="cro-grid">
      <div>
        <span class="cro-eyebrow">Conversion audit</span>
        <h1>The audit that doesn't end with a <em>PDF</em>.</h1>
        <p style="color:var(--muted); font-size:1.06rem; line-height:1.65;">Most CRO audits are 40-page documents that recommend "improve trust signals." Useful, in theory. We do the audit AND make the changes. You leave with a measurably better site, not a deliverable.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=cro-audit" class="btn btn-primary">Book the audit →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <figure><img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=1000&q=80&auto=format&fit=crop" alt="Conversion analytics dashboard"></figure>
    </div>
  </section>

  <section class="cro-body">
    <div class="container">
      <h2>Three weeks. Audit, prioritize, ship.</h2>
      <div class="cro-cards">
        <div class="cro-card"><span class="step">WEEK 01</span><h3>Diagnose</h3><p>GA4 funnel review, FullStory or Hotjar session recordings, heuristic walk-through, mobile UX teardown. We surface the 5–7 highest-leverage issues with evidence.</p></div>
        <div class="cro-card"><span class="step">WEEK 02</span><h3>Prioritize</h3><p>We rank fixes by ICE score (impact, confidence, effort). You see the math, push back if you want, and we lock the test plan together.</p></div>
        <div class="cro-card"><span class="step">WEEK 03</span><h3>Ship</h3><p>We implement the top three fixes — copy, layout, code — and set up A/B tracking so you measure the lift in real numbers, not in a deck.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
