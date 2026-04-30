@extends('layouts.app')
@section('title', 'Email Marketing Automation Setup — Digirisers')
@section('description', 'A complete email automation foundation — flows, segments, deliverability, and the templates that turn one purchase into three.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .em { padding: 90px 0; }
    .em h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 12px 0 16px; max-width: 700px; }
    .em h1 em { color: #d946ef; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .em .tag { font-size:.74rem; font-weight:700; color:#86198f; background:#fae8ff; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .em p.lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 600px; margin: 16px 0 28px; }
    .em-flows { padding: 60px 0; }
    .em-flows h2 { margin: 0 0 30px; }
    .em-stack { display: grid; gap: 12px; max-width: 880px; }
    .em-flow { display: grid; grid-template-columns: 80px 1fr 100px; gap: 18px; padding: 22px; background: #fdf4ff; border: 1px solid #f0abfc; border-radius: 14px; align-items: center; }
    .em-flow .pill { padding: 4px 10px; background: #d946ef; color: #fff; border-radius: 999px; font-family: var(--font-mono); font-size: .7rem; text-align: center; font-weight: 700; }
    .em-flow h3 { font-size: 1rem; margin: 0 0 4px; }
    .em-flow p { font-size: .88rem; color: var(--muted); margin: 0; line-height: 1.55; }
    .em-flow .imp { color: #86198f; font-weight: 700; font-size: .82rem; text-align: right; font-family: var(--font-mono); }
    .em-deliv { padding: 70px 0; background: #fdf4ff; }
    .em-deliv h2 { text-align: center; max-width: 600px; margin: 0 auto 30px; }
    .em-deliv .row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; max-width: 920px; margin: 0 auto; }
    .em-deliv .cell { padding: 22px 18px; background: #fff; border: 1px solid #f0abfc; border-radius: 12px; text-align: center; }
    .em-deliv .cell strong { display: block; font-size: 1.4rem; color: #a21caf; font-weight: 800; line-height: 1; margin-bottom: 8px; }
    .em-deliv .cell small { font-size: .82rem; color: var(--muted); }
    @media (max-width: 880px) { .em-flow { grid-template-columns: 1fr; } .em-flow .imp { text-align: left; } .em-deliv .row { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container em">
    <span class="tag">Email · automation</span>
    <h1>The seven flows every store needs to <em>print money</em>.</h1>
    <p class="lede">Email is the most ROI-positive channel in marketing — and most teams ship two flows then stop. We build the seven that the data says compound: welcome, abandoned cart, post-purchase, win-back, browse abandonment, replenishment, and review request.</p>
    @auth
      <a href="{{ route('contact') }}?service=email-automation" class="btn btn-primary">Plan the foundation →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="container em-flows">
    <h2>The seven flows we ship.</h2>
    <div class="em-stack">
      <div class="em-flow"><span class="pill">FLOW 1</span><div><h3>Welcome series</h3><p>3 emails over 7 days. Brand story, product hierarchy, first-purchase incentive that doesn't train discount-shoppers.</p></div><span class="imp">+ 18-26%</span></div>
      <div class="em-flow"><span class="pill">FLOW 2</span><div><h3>Abandoned cart</h3><p>3 emails over 5 days. Reminder, social-proof, last-chance with light incentive. ~22% recovery rate.</p></div><span class="imp">+ 12-22%</span></div>
      <div class="em-flow"><span class="pill">FLOW 3</span><div><h3>Post-purchase</h3><p>5 emails over 30 days. Thanks, shipping, use-the-product, ask-for-review, cross-sell. Repeat-purchase cement.</p></div><span class="imp">+ 8-14%</span></div>
      <div class="em-flow"><span class="pill">FLOW 4</span><div><h3>Win-back</h3><p>4 emails for customers who've gone quiet 60-90 days. Soft, then specific, then bold. Saves 5-10% of churners.</p></div><span class="imp">+ 5-10%</span></div>
      <div class="em-flow"><span class="pill">FLOW 5</span><div><h3>Browse abandonment</h3><p>For viewers who didn't add to cart. Lower urgency, higher curiosity. Helps qualified browsers commit.</p></div><span class="imp">+ 3-7%</span></div>
      <div class="em-flow"><span class="pill">FLOW 6</span><div><h3>Replenishment</h3><p>For consumables. Time-the-reorder based on purchase cadence. Most underrated revenue lever.</p></div><span class="imp">+ 6-12%</span></div>
      <div class="em-flow"><span class="pill">FLOW 7</span><div><h3>Review request</h3><p>Triggered post-fulfillment. UGC-friendly. Filters happy reviewers to public, unhappy to support — protects your rating.</p></div><span class="imp">+ 4-8%</span></div>
    </div>
  </section>

  <section class="em-deliv">
    <div class="container">
      <h2>Deliverability done right.</h2>
      <div class="row">
        <div class="cell"><strong>SPF</strong><small>Authenticated sender records</small></div>
        <div class="cell"><strong>DKIM</strong><small>Cryptographic signature</small></div>
        <div class="cell"><strong>DMARC</strong><small>Reject impersonators</small></div>
        <div class="cell"><strong>BIMI</strong><small>Logo in inbox if eligible</small></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
