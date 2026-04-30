@extends('layouts.app')
@section('title', 'Monthly SEO Retainer — Digirisers')
@section('description', 'A monthly SEO retainer that produces measurable rank gains — content, links, technical, and reporting handled by senior practitioners, not interns.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ms { background: #052e16; color: #f0fdf4; padding: 100px 0 80px; min-height: 90vh; position: relative; overflow: hidden; }
    .ms::before { content: ""; position: absolute; bottom: -30%; right: -10%; width: 700px; height: 700px; background: radial-gradient(circle, rgba(34,197,94,.18), transparent 65%); }
    .ms .container { position: relative; }
    .ms h1 { color: #fff; font-size: clamp(2.3rem, 4.6vw, 3.4rem); margin: 16px 0 18px; }
    .ms h1 em { color: #4ade80; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .ms .lede { color: #bbf7d0; font-size: 1.06rem; line-height: 1.65; max-width: 600px; }
    .ms-tag { display:inline-block; font-size:.72rem; font-weight:700; color:#4ade80; background:rgba(74,222,128,.12); padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; border: 1px solid rgba(74,222,128,.25); }
    .ms-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-top: 60px; }
    .ms-card { padding: 26px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.1); border-radius: 16px; backdrop-filter: blur(20px); }
    .ms-card .num { font-family: var(--font-mono); font-size: .72rem; color: #4ade80; letter-spacing: .12em; }
    .ms-card h3 { color: #fff; margin: 8px 0 6px; font-size: 1rem; }
    .ms-card p { color: #a7f3d0; font-size: .88rem; margin: 0; line-height: 1.55; }
    .ms-bar { padding: 60px 0; background: #fff; color: var(--ink); border-top: 1px solid var(--line); }
    .ms-bar h2 { text-align: center; max-width: 600px; margin: 0 auto 14px; }
    .ms-bar .sub { text-align: center; color: var(--muted); max-width: 520px; margin: 0 auto 32px; }
    .ms-bar .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; max-width: 800px; margin: 0 auto; text-align: center; padding: 30px 0; border-top: 1px dashed var(--line); border-bottom: 1px dashed var(--line); }
    .ms-bar .stats strong { display: block; font-size: 2.2rem; font-weight: 800; color: #15803d; line-height: 1; margin-bottom: 6px; }
    .ms-bar .stats small { font-size: .82rem; color: var(--muted); }
    @media (max-width: 880px) { .ms-grid { grid-template-columns: 1fr 1fr; } .ms-bar .stats { grid-template-columns: 1fr; gap: 18px; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ms">
    <div class="container">
      <span class="ms-tag">Monthly retainer · senior team</span>
      <h1>The boring, <em>ongoing</em> work that compounds.</h1>
      <p class="lede">SEO is not a project. It's a discipline you sustain. Our monthly retainer is the team handling content briefs, link earning, technical maintenance, and reporting — so you compound rankings month over month instead of paying for one-off audits that go stale.</p>
      <p style="margin-top:26px;">
        @auth
          <a href="{{ route('contact') }}?service=monthly-seo" class="btn btn-primary">Start the retainer →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>

      <div class="ms-grid">
        <div class="ms-card"><span class="num">CONTENT</span><h3>4 briefs/month</h3><p>Researched, structured, written by humans, fact-checked. Your team approves and publishes.</p></div>
        <div class="ms-card"><span class="num">LINKS</span><h3>3-5/month</h3><p>Earned, not bought. Real outreach to relevant publications. We share every link and the angle that won it.</p></div>
        <div class="ms-card"><span class="num">TECHNICAL</span><h3>Maintenance pass</h3><p>Crawl errors, broken links, redirects, schema drift, Core Web Vitals — caught and fixed monthly.</p></div>
        <div class="ms-card"><span class="num">REPORTING</span><h3>One real meeting</h3><p>30 minutes with a senior — not a deck, just decisions. We show what worked, what didn't, what's next.</p></div>
      </div>
    </div>
  </section>

  <section class="ms-bar">
    <div class="container">
      <h2>What 12 months looks like.</h2>
      <p class="sub">Median across all retainer clients on the engagement for at least a year.</p>
      <div class="stats">
        <div><strong>+187%</strong><small>organic clicks vs. month-zero baseline</small></div>
        <div><strong>+38</strong><small>top-3 ranked keywords (from typical 6 baseline)</small></div>
        <div><strong>4.1×</strong><small>ROI on retainer fees vs. attributed organic revenue</small></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
