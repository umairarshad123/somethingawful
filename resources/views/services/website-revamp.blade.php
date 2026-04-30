@extends('layouts.app')
@section('title', 'Website Revamp — Digirisers')
@section('description', 'A site redesign that keeps what works and replaces what doesn\'t. We diagnose first, design second, and ship a faster, sharper version of your site.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .rv-hero { padding: 80px 0 50px; max-width: 760px; }
    .rv-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.4rem); margin: 16px 0 16px; }
    .rv-hero h1 em { color: #2563eb; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .rv-hero p { font-size: 1.08rem; color: var(--muted); line-height: 1.65; }
    .rv-tag { font-size:.72rem; font-weight:700; color:#1d4ed8; background:#eff6ff; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .rv-vs { padding: 80px 0; background: #fff; border-top: 1px solid var(--line); }
    .rv-vs h2 { text-align: center; max-width: 600px; margin: 0 auto 44px; }
    .rv-table { display: grid; grid-template-columns: 1.4fr 1fr 1fr; border: 1px solid var(--line); border-radius: 18px; overflow: hidden; max-width: 980px; margin: 0 auto; }
    .rv-table > div { padding: 16px 22px; border-bottom: 1px solid var(--line); }
    .rv-table > div:nth-last-child(-n+3) { border-bottom: 0; }
    .rv-table .head { background: var(--ink); color: #fff; font-weight: 700; font-size: .92rem; }
    .rv-table .label { background: #fafafa; color: var(--ink); font-weight: 600; font-size: .92rem; }
    .rv-table .old { color: #b91c1c; background: #fef2f2; font-size: .9rem; }
    .rv-table .new { color: #15803d; background: #f0fdf4; font-size: .9rem; }
    .rv-img { padding: 60px 0; }
    .rv-img figure { max-width: 1000px; margin: 0 auto; aspect-ratio: 16/9; border-radius: 22px; overflow: hidden; box-shadow: 0 50px 100px -40px rgba(11,16,32,.4); }
    .rv-img img { width: 100%; height: 100%; object-fit: cover; }
    .rv-cta { padding: 80px 0; text-align: center; background: #1e3a8a; color: #fff; }
    .rv-cta h2 { color: #fff; }
    @media (max-width: 720px) { .rv-table { grid-template-columns: 1fr; } .rv-table > div { border-bottom: 1px solid var(--line); } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container rv-hero">
    <span class="rv-tag">Audit + Rebuild</span>
    <h1>Don't replatform. <em>Diagnose, then redesign.</em></h1>
    <p>"Let's redo the whole site" is usually expensive optimism. We start by reading your analytics, your session recordings, and your support tickets to find which 20% of pages drive 80% of value. Then we revamp those — design, content, and code — while leaving working pages alone.</p>
  </section>

  <section class="rv-vs">
    <div class="container">
      <h2>What changes when we're done.</h2>
      <div class="rv-table">
        <div class="head"></div>
        <div class="head">Before</div>
        <div class="head">After</div>

        <div class="label">Mobile LCP</div>
        <div class="old">4.8 s</div>
        <div class="new">1.6 s</div>

        <div class="label">Bounce rate</div>
        <div class="old">68%</div>
        <div class="new">42%</div>

        <div class="label">Pages per session</div>
        <div class="old">1.4</div>
        <div class="new">2.7</div>

        <div class="label">Lead form completion</div>
        <div class="old">2.1%</div>
        <div class="new">5.8%</div>

        <div class="label">Lighthouse score</div>
        <div class="old">52</div>
        <div class="new">96</div>
      </div>
      <p style="text-align:center; max-width:600px; margin:30px auto 0; color:var(--soft); font-size:.9rem;">Median results across 12 revamps shipped in the last 18 months. Your numbers will differ — we'll commit to a target before we start.</p>
    </div>
  </section>

  <section class="rv-img">
    <figure><img src="https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?w=1600&q=80&auto=format&fit=crop" alt="Designer iterating on website redesign mockup"></figure>
  </section>

  <section class="rv-cta">
    <div class="container">
      <h2>Get the audit first. Decide on the rebuild after.</h2>
      <p style="color:rgba(255,255,255,.75); max-width:540px; margin:0 auto 26px;">We'll deliver a written diagnosis with prioritized fixes — yours to keep whether you hire us for the rebuild or not.</p>
      @auth
        <a href="{{ route('contact') }}?service=website-revamp" class="btn btn-light">Book the audit →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-light">Create account &amp; view pricing →</a>
      @endauth
    </div>
  </section>

  @include('partials.footer')
@endsection
