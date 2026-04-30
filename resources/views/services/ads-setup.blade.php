@extends('layouts.app')
@section('title', 'Ads Setup (per platform) — Digirisers')
@section('description', 'A single-platform ads setup done properly: account structure, conversion tracking, audiences, creative, and the kickoff campaign. Live in 5 days.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .as-hero { padding: 80px 0; max-width: 880px; margin: 0 auto; text-align: center; }
    .as-tag { display:inline-block; font-size:.74rem; font-weight:700; color:#1d4ed8; background:#eff6ff; padding:6px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .as-hero h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 18px 0 18px; }
    .as-hero h1 em { color: #2563eb; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .as-hero p { font-size: 1.1rem; color: var(--muted); max-width: 600px; margin: 0 auto 30px; line-height: 1.65; }
    .as-photo { padding: 0 0 70px; }
    .as-photo figure { max-width: 1100px; margin: 0 auto; aspect-ratio: 21/9; border-radius: 24px; overflow: hidden; }
    .as-photo img { width: 100%; height: 100%; object-fit: cover; }
    .as-platforms { padding: 60px 0; background: #fff; border-top: 1px solid var(--line); }
    .as-platforms h2 { text-align: center; max-width: 600px; margin: 0 auto 30px; }
    .as-platforms .row { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; max-width: 1000px; margin: 0 auto; }
    .as-platforms .pl { padding: 22px 18px; background: #f8fafc; border: 1px solid var(--line); border-radius: 14px; text-align: center; transition: background .2s ease, border-color .2s ease; }
    .as-platforms .pl:hover { background: #eff6ff; border-color: #93c5fd; }
    .as-platforms .pl strong { display: block; font-size: .96rem; color: var(--ink); margin-bottom: 6px; }
    .as-platforms .pl small { font-size: .78rem; color: var(--muted); }
    .as-flow { padding: 70px 0; }
    .as-flow h2 { max-width: 600px; margin: 0 0 36px; }
    .as-flow-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
    .as-flow-card { padding: 26px; background: linear-gradient(135deg, #eff6ff 0%, #fff 100%); border-radius: 16px; border: 1px solid #dbeafe; }
    .as-flow-card .num { font-family: var(--font-mono); color: #1d4ed8; font-weight: 700; font-size: .82rem; letter-spacing: .12em; }
    .as-flow-card h3 { font-size: 1.05rem; margin: 8px 0 8px; }
    .as-flow-card p { color: var(--muted); font-size: .9rem; margin: 0; line-height: 1.6; }
    @media (max-width: 880px) { .as-platforms .row { grid-template-columns: 1fr 1fr; } .as-flow-grid { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="as-hero">
    <span class="as-tag">Ads setup · single platform</span>
    <h1>One platform. <em>Done correctly.</em> In a week.</h1>
    <p>Most paid-media spends die in the first month because the account was set up wrong: bad campaign structure, conversion tracking misfiring, audiences too broad, no negative keywords. We do the boring foundational work so when you start spending, every dollar is measured.</p>
    @auth
      <a href="{{ route('contact') }}?service=ads-setup" class="btn btn-primary">Start the build →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="as-photo">
    <figure><img src="https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=1800&q=80&auto=format&fit=crop" alt="Ad campaign dashboard"></figure>
  </section>

  <section class="as-platforms">
    <div class="container">
      <h2>Platforms we build for.</h2>
      <div class="row">
        <div class="pl"><strong>Google Ads</strong><small>Search · PMax · Shopping</small></div>
        <div class="pl"><strong>Meta Ads</strong><small>Facebook · Instagram</small></div>
        <div class="pl"><strong>TikTok</strong><small>Spark · TopView · Brand</small></div>
        <div class="pl"><strong>LinkedIn</strong><small>Sponsored · ABM</small></div>
        <div class="pl"><strong>Microsoft</strong><small>Bing · LinkedIn audience</small></div>
      </div>
    </div>
  </section>

  <section class="container as-flow">
    <h2>What "setup" includes.</h2>
    <div class="as-flow-grid">
      <div class="as-flow-card">
        <span class="num">FOUNDATION</span>
        <h3>Account + tracking</h3>
        <p>Manager account, conversion tracking (server-side where possible), audience uploads, naming convention you'll thank us for in month 6.</p>
      </div>
      <div class="as-flow-card">
        <span class="num">CREATIVE</span>
        <h3>3 ad concepts</h3>
        <p>Three distinct creative angles, each with 5 variants. Hook copy, visual treatment, and CTAs differentiated to learn fast.</p>
      </div>
      <div class="as-flow-card">
        <span class="num">LAUNCH</span>
        <h3>Kickoff campaign</h3>
        <p>One campaign live with proper structure, learning budget configured, alerts set. We hand off with a video walking through every setting.</p>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
