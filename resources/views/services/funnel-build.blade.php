@extends('layouts.app')
@section('title', 'Funnel Build — Digirisers')
@section('description', 'A 3-step opt-in → sales → upsell funnel that turns cold ad clicks into qualified buyers. Built, wired, and ready to scale.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .fn { background: linear-gradient(180deg,#fff 0%, #f0fdf4 100%); padding: 80px 0; }
    .fn h1 { font-size: clamp(2.2rem, 4.5vw, 3.4rem); max-width: 720px; }
    .fn h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #16a34a; }
    .fn-intro { display: grid; grid-template-columns: 1.2fr 1fr; gap: 60px; align-items: center; }
    .fn-intro p { color: var(--muted); font-size: 1.06rem; line-height: 1.65; max-width: 520px; }
    .fn-intro figure { aspect-ratio: 4/5; border-radius: 22px; overflow: hidden; }
    .fn-intro figure img { width: 100%; height: 100%; object-fit: cover; }
    .fn-time { padding: 80px 0; border-top: 1px solid var(--line); margin-top: 80px; }
    .fn-time h2 { text-align: center; max-width: 600px; margin: 0 auto 50px; }
    .fn-step { display: grid; grid-template-columns: 200px 1fr 1fr; gap: 40px; padding: 36px 0; border-bottom: 1px dashed var(--line); align-items: start; }
    .fn-step:last-child { border-bottom: 0; }
    .fn-step .num { font-family: var(--font-mono); font-size: 4rem; font-weight: 700; color: #16a34a; line-height: .9; }
    .fn-step h3 { font-size: 1.4rem; margin: 8px 0 12px; }
    .fn-step p { color: var(--muted); line-height: 1.65; margin: 0; }
    .fn-step figure { aspect-ratio: 4/3; border-radius: 14px; overflow: hidden; }
    .fn-step figure img { width: 100%; height: 100%; object-fit: cover; }
    @media (max-width: 880px) { .fn-intro, .fn-step { grid-template-columns: 1fr; } .fn-step .num { font-size: 3rem; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="fn">
    <div class="container fn-intro">
      <div>
        <span style="font-size:.74rem; font-weight:700; color:#15803d; background:#dcfce7; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase;">Funnel build · 3 stages</span>
        <h1 style="margin:18px 0 16px;">From cold click to <em>upsell</em>, in three pages.</h1>
        <p>A funnel is not a long landing page. It's a sequence of decisions — opt in, buy, expand — each with its own emotional brief. We design and build all three pages, the email automations connecting them, and the integration that drops the buyer into your CRM tagged correctly.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=funnel-build" class="btn btn-primary">Sketch the funnel →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <figure><img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=1000&q=80&auto=format&fit=crop" alt="Funnel sketch with markers"></figure>
    </div>
  </section>

  <section class="container fn-time">
    <h2>How the three stages connect.</h2>

    <div class="fn-step">
      <span class="num">01</span>
      <div><h3>The opt-in</h3><p>A short page with a specific lead magnet — checklist, swipe file, free audit. The headline names the exact pain. The form asks for one thing. The thank-you page sets up the sale.</p></div>
      <figure><img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=900&q=80&auto=format&fit=crop" alt="Opt-in form"></figure>
    </div>

    <div class="fn-step">
      <span class="num">02</span>
      <div><h3>The sale</h3><p>Long-form, story-driven, objection-led. Six sections: hook, agitation, transformation, offer, proof, guarantee. Built so the order button is always within thumb's reach on mobile.</p></div>
      <figure><img src="https://images.unsplash.com/photo-1556745757-8d76bdb6984b?w=900&q=80&auto=format&fit=crop" alt="Sales page strategy"></figure>
    </div>

    <div class="fn-step">
      <span class="num">03</span>
      <div><h3>The upsell</h3><p>One-click upgrade after checkout. Different pixel, different price, different promise. Typical lift: 18-32% increase in average order value with no extra ad spend.</p></div>
      <figure><img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=900&q=80&auto=format&fit=crop" alt="Upsell strategy"></figure>
    </div>
  </section>

  @include('partials.footer')
@endsection
