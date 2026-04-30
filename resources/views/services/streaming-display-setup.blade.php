@extends('layouts.app')
@section('title', 'Streaming / Display Ads Setup — Digirisers')
@section('description', 'Connected TV and display ads launched on Hulu, Netflix, YouTube, and the open programmatic web — done with brand-safe inventory and measurable lift.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .sd-hero { position: relative; padding: 120px 0 100px; text-align: center; overflow: hidden; }
    .sd-hero::before { content: ""; position: absolute; inset: 0; background: linear-gradient(180deg,#1e1b4b 0%,#312e81 100%); }
    .sd-hero::after { content: ""; position: absolute; inset: 0; background: radial-gradient(ellipse 60% 50% at 50% 30%, rgba(167,139,250,.3) 0%, transparent 60%); }
    .sd-hero .container { position: relative; max-width: 880px; color: #fff; }
    .sd-hero h1 { color: #fff; font-size: clamp(2.4rem, 5vw, 3.8rem); margin: 18px 0 18px; }
    .sd-hero h1 em { color: #c4b5fd; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .sd-hero p { color: rgba(255,255,255,.78); font-size: 1.1rem; max-width: 600px; margin: 0 auto 32px; line-height: 1.65; }
    .sd-tag { display:inline-block; font-size:.74rem; font-weight:700; color:#c4b5fd; background:rgba(255,255,255,.1); padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,.2); }
    .sd-section { padding: 80px 0; }
    .sd-section h2 { text-align: center; max-width: 600px; margin: 0 auto 44px; }
    .sd-tv { max-width: 1000px; margin: 0 auto; aspect-ratio: 16/9; border-radius: 22px; overflow: hidden; position: relative; box-shadow: 0 50px 100px -40px rgba(11,16,32,.5); }
    .sd-tv img { width: 100%; height: 100%; object-fit: cover; }
    .sd-tv::after { content: ""; position: absolute; inset: 0; border: 8px solid #18181b; border-radius: 22px; pointer-events: none; box-shadow: inset 0 0 0 2px #404040; }
    .sd-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; max-width: 1100px; margin: 60px auto 0; }
    .sd-cell { padding: 22px; background: #fff; border: 1px solid var(--line); border-radius: 14px; text-align: center; }
    .sd-cell strong { display: block; font-size: 1.6rem; color: #6d28d9; font-weight: 800; line-height: 1; margin-bottom: 8px; }
    .sd-cell small { font-size: .88rem; color: var(--muted); }
    @media (max-width: 880px) { .sd-grid { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="sd-hero">
    <div class="container">
      <span class="sd-tag">CTV · streaming · programmatic</span>
      <h1>The big screen, <em>finally</em>, with measurable ROI.</h1>
      <p>TV used to mean "bullet money you can't track." With CTV — Hulu, Netflix, YouTube — every impression is targetable, every household is identifiable, and conversions are measurable across web and physical visits. We launch on the right inventory at the right CPM.</p>
      @auth
        <a href="{{ route('contact') }}?service=streaming-display-setup" class="btn btn-light">Plan the buy →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-light">Sign in to view pricing</a>
      @endauth
    </div>
  </section>

  <section class="sd-section">
    <div class="container">
      <h2>Where your spots actually run.</h2>
      <div class="sd-tv"><img src="https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?w=1600&q=80&auto=format&fit=crop" alt="Streaming TV display"></div>

      <div class="sd-grid">
        <div class="sd-cell"><strong>Hulu</strong><small>Premium CTV inventory</small></div>
        <div class="sd-cell"><strong>YouTube</strong><small>TrueView + Bumper</small></div>
        <div class="sd-cell"><strong>Netflix Ads</strong><small>Standard tier inventory</small></div>
        <div class="sd-cell"><strong>The Trade Desk</strong><small>Open programmatic CTV</small></div>
        <div class="sd-cell"><strong>Roku</strong><small>OneView + native</small></div>
        <div class="sd-cell"><strong>Display</strong><small>GDN + premium DSP</small></div>
        <div class="sd-cell"><strong>Spotify</strong><small>Audio + video</small></div>
        <div class="sd-cell"><strong>Brand-safe lists</strong><small>Curated allowlists, not blocklists</small></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
