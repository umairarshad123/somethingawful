@extends('layouts.app')

@section('title', 'WordPress Portfolio Site — Digirisers')
@section('description', 'A clean, fast WordPress portfolio built around your work — not the theme. Custom typography, page-speed budget under 2 seconds, and a CMS your future self can actually edit.')
@section('robots', 'index,follow')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .pf { background: #fff; }
    .pf-hero { padding: 80px 0 64px; display: grid; grid-template-columns: 1.05fr 1fr; gap: 60px; align-items: center; }
    .pf-hero-img { position: relative; border-radius: 24px; overflow: hidden; aspect-ratio: 4/5; box-shadow: 0 50px 100px -40px rgba(11,16,32,.4); }
    .pf-hero-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 1s ease; }
    .pf-hero-img:hover img { transform: scale(1.05); }
    .pf-hero-img::after { content: ""; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(99,102,241,.18) 0%, transparent 60%); }
    .pf-tag { display: inline-block; font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #4338ca; background: #eef2ff; padding: 6px 12px; border-radius: 999px; margin-bottom: 18px; }
    .pf-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.4rem); margin: 0 0 14px; }
    .pf-hero h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #6366f1; }
    .pf-hero p { color: var(--muted); font-size: 1.08rem; line-height: 1.65; max-width: 540px; }
    .pf-list { background: #fafbff; border-top: 1px solid var(--line); padding: 80px 0; }
    .pf-list .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
    .pf-card { padding: 28px; background: #fff; border: 1px solid var(--line); border-radius: 18px; transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease; }
    .pf-card:hover { transform: translateY(-4px); border-color: #c7d2fe; box-shadow: 0 24px 50px -28px rgba(99,102,241,.4); }
    .pf-card .num { font-family: var(--font-mono); font-size: .72rem; color: #6366f1; font-weight: 700; letter-spacing: .12em; }
    .pf-card h3 { font-size: 1.05rem; margin: 8px 0 8px; }
    .pf-card p { color: var(--soft); font-size: .92rem; margin: 0; line-height: 1.6; }
    .pf-cta { padding: 80px 0; text-align: center; background: linear-gradient(135deg, #4338ca 0%, #1e1b4b 100%); color: #fff; }
    .pf-cta h2 { color: #fff; margin: 0 0 14px; }
    .pf-cta p { color: rgba(255,255,255,.7); max-width: 520px; margin: 0 auto 26px; }
    @media (max-width: 880px) { .pf-hero, .pf-list .grid { grid-template-columns: 1fr; } .pf-hero { padding-top: 40px; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <main class="pf">
    <div class="container pf-hero">
      <figure class="pf-hero-img"><img src="https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=1200&q=80&auto=format&fit=crop" alt="Designer arranging a portfolio layout"></figure>
      <div>
        <span class="pf-tag">Portfolio · WordPress</span>
        <h1>A portfolio that frames the <em>work</em>, not the theme.</h1>
        <p>Most portfolio templates flatten what makes your work distinct. We build a small, opinionated WordPress site around your aesthetic — typography, grid, photography rhythm — so the case studies feel like a magazine spread, not a directory.</p>
        <p style="margin-top:22px;">
          @auth
            <a href="#book" class="btn btn-primary">Start the build</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
          <a href="{{ route('contact') }}" class="btn" style="background:transparent; color:var(--ink); border:1px solid var(--line);">Talk to us</a>
        </p>
      </div>
    </div>

    <section class="pf-list">
      <div class="container">
        <h2 style="margin: 0 0 36px; max-width: 620px;">Three things every portfolio needs — and most miss.</h2>
        <div class="grid">
          <div class="pf-card"><span class="num">01</span><h3>A visual rhythm</h3><p>We design the case-study spread, not just a tile grid. Crops, captions, and white space are deliberate — your work breathes between sections.</p></div>
          <div class="pf-card"><span class="num">02</span><h3>Typography that reads</h3><p>One serif, one sans, one mono — paired specifically to your medium. Sizes, leading, and rag are tuned so long-form text feels printed, not pasted.</p></div>
          <div class="pf-card"><span class="num">03</span><h3>A CMS you'll use</h3><p>Custom Gutenberg blocks for your specific case-study format. New work goes up in twenty minutes, not three hours.</p></div>
        </div>
      </div>
    </section>

    <section class="pf-cta" id="book">
      <div class="container">
        <h2>Ship a portfolio you'll send to clients without flinching.</h2>
        <p>Two to three weeks. Three case studies built with you. A CMS configured to your exact workflow.</p>
        @auth
          <a href="{{ route('contact') }}?service=wp-portfolio" class="btn btn-light">Start the project →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-light">Create account &amp; view pricing →</a>
        @endauth
      </div>
    </section>
  </main>

  @include('partials.footer')
@endsection
