@extends('layouts.app')
@section('title', 'Landing Page — Digirisers')
@section('description', 'A single conversion-optimized landing page built around one offer, one audience, one ask. Live in 5 days.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .lp { padding: 60px 0 90px; }
    .lp h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); max-width: 740px; margin: 18px 0 16px; }
    .lp h1 em { font-family: var(--font-serif); font-style: italic; color: #f97316; font-weight: 400; }
    .lp .hero-p { font-size: 1.1rem; color: var(--muted); max-width: 620px; line-height: 1.65; }
    .lp-tag { display: inline-block; background: #fff7ed; color: #c2410c; font-size: .72rem; font-weight: 700; padding: 6px 12px; border-radius: 999px; letter-spacing: .12em; text-transform: uppercase; }
    .lp-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px; margin-top: 60px; }
    .lp-grid figure { aspect-ratio: 1; border-radius: 14px; overflow: hidden; }
    .lp-grid figure:nth-child(1) { grid-column: span 3; aspect-ratio: 6/4; }
    .lp-grid figure:nth-child(2) { grid-column: span 3; aspect-ratio: 6/4; }
    .lp-grid figure:nth-child(3) { grid-column: span 2; }
    .lp-grid figure:nth-child(4) { grid-column: span 2; }
    .lp-grid figure:nth-child(5) { grid-column: span 2; }
    .lp-grid img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s ease; }
    .lp-grid figure:hover img { transform: scale(1.06); }
    .lp-six { display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px; padding: 70px 0; border-top: 1px solid var(--line); margin-top: 80px; }
    .lp-six div { padding: 18px; }
    .lp-six h3 { font-size: .95rem; margin: 0 0 6px; color: #c2410c; }
    .lp-six p { font-size: .82rem; color: var(--muted); margin: 0; line-height: 1.5; }
    @media (max-width: 880px) { .lp-grid, .lp-six { grid-template-columns: 1fr 1fr; } .lp-grid figure { grid-column: span 1 !important; aspect-ratio: 1 !important; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container lp">
    <span class="lp-tag">5-day delivery · single page</span>
    <h1>One <em>page</em>. One offer. One conversion to optimize for.</h1>
    <p class="hero-p">Multi-page sites scatter intent. A landing page concentrates it. We write the headline, design the section flow, and ship the build in five business days — usually for a paid-ads launch, a product release, or a webinar funnel.</p>
    <p style="margin-top: 28px;">
      @auth
        <a href="{{ route('contact') }}?service=landing-page" class="btn btn-primary">Brief us in →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth
    </p>

    <div class="lp-grid">
      <figure><img src="https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=1200&q=80&auto=format&fit=crop" alt="Landing page on monitor"></figure>
      <figure><img src="https://images.unsplash.com/photo-1559028012-481c04fa702d?w=1200&q=80&auto=format&fit=crop" alt="Mobile mockup"></figure>
      <figure><img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&q=80&auto=format&fit=crop" alt="Workspace"></figure>
      <figure><img src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&q=80&auto=format&fit=crop" alt="Desktop view"></figure>
      <figure><img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=800&q=80&auto=format&fit=crop" alt="Funnel sketch"></figure>
    </div>

    <div class="lp-six">
      <div><h3>Day 1</h3><p>Offer + audience interview.</p></div>
      <div><h3>Day 2</h3><p>Headline + section copy.</p></div>
      <div><h3>Day 3</h3><p>Design + photo direction.</p></div>
      <div><h3>Day 4</h3><p>Build + integrations.</p></div>
      <div><h3>Day 5</h3><p>QA + launch.</p></div>
      <div><h3>Day 6+</h3><p>You optimize from real data.</p></div>
    </div>
  </section>

  @include('partials.footer')
@endsection
