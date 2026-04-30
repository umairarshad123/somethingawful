@extends('layouts.app')
@section('title', 'Ads Management — Digirisers')
@section('description', 'Weekly ads management on Google, Meta, TikTok, or LinkedIn. Optimization, creative refresh, budget reallocation, and a real human who watches the numbers.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .am { background: #0c0a09; color: #fafaf9; padding: 90px 0 80px; min-height: 90vh; position: relative; overflow: hidden; }
    .am::after { content: ""; position: absolute; top: -100px; right: -150px; width: 600px; height: 600px; background: radial-gradient(circle, rgba(245,158,11,.18), transparent 60%); pointer-events: none; }
    .am .container { position: relative; }
    .am h1 { color: #fff; font-size: clamp(2.2rem, 4.4vw, 3.4rem); margin: 14px 0 18px; }
    .am h1 em { color: #fbbf24; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .am-tag { font-size:.72rem; font-weight:700; color:#fbbf24; background:rgba(251,191,36,.1); padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; border:1px solid rgba(251,191,36,.25); }
    .am .lede { color: #d6d3d1; font-size: 1.06rem; line-height: 1.65; max-width: 580px; margin: 0 0 30px; }
    .am-week { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; margin-top: 50px; padding: 24px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 16px; }
    .am-week .day { padding: 14px 12px; border-radius: 10px; background: rgba(255,255,255,.05); }
    .am-week .day.busy { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #422006; }
    .am-week .day .nm { font-family: var(--font-mono); font-size: .68rem; letter-spacing: .12em; opacity: .7; margin-bottom: 6px; }
    .am-week .day strong { display: block; font-size: .82rem; line-height: 1.4; }
    .am-bar { padding: 70px 0; background: #fafaf9; color: var(--ink); }
    .am-bar h2 { text-align: center; margin: 0 0 30px; max-width: 580px; margin: 0 auto 30px; }
    .am-list { max-width: 760px; margin: 0 auto; display: grid; gap: 12px; }
    .am-list div { padding: 18px 22px; background: #fff; border: 1px solid var(--line); border-radius: 12px; display: grid; grid-template-columns: 28px 1fr; gap: 14px; }
    .am-list svg { color: #d97706; margin-top: 3px; }
    .am-list strong { display: block; margin-bottom: 4px; }
    .am-list span { color: var(--muted); font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .am-week { grid-template-columns: repeat(2, 1fr); } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="am">
    <div class="container">
      <span class="am-tag">Ads management · weekly</span>
      <h1>Ads aren't <em>set-and-forget</em>. We're the team that doesn't.</h1>
      <p class="lede">Most ad accounts decline within 60 days because no one's tending them — creative fatigues, audiences saturate, attribution drifts. Our weekly retainer is one senior practitioner per platform who reads the numbers, refreshes creative, reallocates budget, and tells you when to pull a plug.</p>
      @auth
        <a href="{{ route('contact') }}?service=ads-management" class="btn btn-primary">Start the retainer →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth

      <div class="am-week">
        <div class="day"><span class="nm">MON</span><strong>Performance review</strong></div>
        <div class="day busy"><span class="nm">TUE</span><strong>Optimization sprint</strong></div>
        <div class="day"><span class="nm">WED</span><strong>Creative review</strong></div>
        <div class="day busy"><span class="nm">THU</span><strong>Budget reallocation</strong></div>
        <div class="day"><span class="nm">FRI</span><strong>Weekly client report</strong></div>
        <div class="day"><span class="nm">SAT</span><strong>Monitoring only</strong></div>
        <div class="day"><span class="nm">SUN</span><strong>Monitoring only</strong></div>
      </div>
    </div>
  </section>

  <section class="am-bar">
    <div class="container">
      <h2>What's actually happening each week.</h2>
      <div class="am-list">
        <div><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Negative keyword adds, search-term review</strong><span>For Google, the single biggest budget protector. We cut 5-15% wasted spend in most accounts within month one.</span></div></div>
        <div><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Creative refresh on cadence</strong><span>One new ad concept tested every two weeks. Winners scaled, losers killed. We share a Loom showing why each call was made.</span></div></div>
        <div><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Bid + budget reallocation</strong><span>Daily caps adjusted based on day-of-week and time-of-day performance. Audience overlap pruned. Top-performing ad sets given oxygen.</span></div></div>
        <div><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Friday report — written by a human</strong><span>What we did, what worked, what didn't, what we're testing next. Two paragraphs and a chart, not a 17-slide deck.</span></div></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
