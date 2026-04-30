@extends('layouts.app')
@section('title', 'Multi-Platform Ads Setup — Digirisers')
@section('description', 'A coordinated launch across Google, Meta, and TikTok — same audiences, unified tracking, separate creative tuned to each platform\'s native vibe.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .mp-hero { padding: 90px 0 50px; display: grid; grid-template-columns: 1.1fr 1fr; gap: 50px; align-items: center; }
    .mp-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; }
    .mp-hero h1 em { color: #db2777; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .mp-tag { font-size:.74rem; font-weight:700; color:#9d174d; background:#fce7f3; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .mp-hero .lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; }
    .mp-hero figure { aspect-ratio: 1; border-radius: 22px; overflow: hidden; }
    .mp-hero figure img { width: 100%; height: 100%; object-fit: cover; }
    .mp-platforms { padding: 70px 0; background: #fdf2f8; border-top: 1px solid #fbcfe8; margin-top: 40px; }
    .mp-platforms h2 { text-align: center; max-width: 600px; margin: 0 auto 40px; }
    .mp-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
    .mp-card { padding: 28px; background: #fff; border-radius: 20px; border: 1px solid #fbcfe8; }
    .mp-card .logo { width: 48px; height: 48px; border-radius: 14px; display: grid; place-items: center; color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 16px; }
    .mp-card h3 { font-size: 1.05rem; margin: 0 0 8px; }
    .mp-card .vibe { font-size: .82rem; color: #be185d; font-weight: 600; margin-bottom: 12px; }
    .mp-card p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }
    .mp-bar { padding: 60px 0; }
    .mp-bar h2 { text-align: center; max-width: 580px; margin: 0 auto 24px; }
    .mp-bar p { text-align: center; max-width: 600px; margin: 0 auto; color: var(--muted); line-height: 1.65; }
    @media (max-width: 880px) { .mp-hero, .mp-row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container mp-hero">
    <div>
      <span class="mp-tag">Multi-platform · Google + Meta + TikTok</span>
      <h1>One audience. Three <em>native</em> creative angles.</h1>
      <p class="lede">Running the same ad on Google, Meta, and TikTok is creative malpractice. Each platform has its own attention rhythm, native vibe, and viewer expectation. We build a unified strategy with three sets of creative — same brand, three platform-fluent voices.</p>
      <p style="margin-top:24px;">
        @auth
          <a href="{{ route('contact') }}?service=multi-platform-setup" class="btn btn-primary">Plan the launch →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>
    </div>
    <figure><img src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=1200&q=80&auto=format&fit=crop" alt="Multi-device ad campaign"></figure>
  </section>

  <section class="mp-platforms">
    <div class="container">
      <h2>How creative differs per platform.</h2>
      <div class="mp-row">
        <div class="mp-card">
          <span class="logo" style="background: linear-gradient(135deg,#4285f4,#34a853);">G</span>
          <h3>Google Ads</h3>
          <p class="vibe">High-intent · search-led</p>
          <p>Direct response. Headlines that match the query exactly. Sitelinks, callouts, structured snippets — the assets matter as much as the ad itself.</p>
        </div>
        <div class="mp-card">
          <span class="logo" style="background: linear-gradient(135deg,#1877f2,#e1306c);">M</span>
          <h3>Meta Ads</h3>
          <p class="vibe">Discovery · feed-native</p>
          <p>UGC-style creative outperforms studio polish 3-to-1. Hook in the first second. Captions assume audio is off. Multi-frame variations to fight fatigue.</p>
        </div>
        <div class="mp-card">
          <span class="logo" style="background: linear-gradient(135deg,#000,#ee1d52);">T</span>
          <h3>TikTok</h3>
          <p class="vibe">Entertainment-first · vertical</p>
          <p>Looks like a TikTok, not an ad. Native sound. POV transitions. The product earns its 9 seconds — it doesn't get them by default.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="mp-bar">
    <div class="container">
      <h2>Tracking, unified.</h2>
      <p>One server-side tracking layer feeds all three platforms with the same event definitions, so you compare apples to apples in your dashboard. Conversion lift studies, attribution windows, and audience uploads sync nightly.</p>
    </div>
  </section>

  @include('partials.footer')
@endsection
