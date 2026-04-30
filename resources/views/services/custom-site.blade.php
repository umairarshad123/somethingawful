@extends('layouts.app')

@section('title', 'Custom Designed Website / Sales Funnel — Digirisers')
@section('description', 'A bespoke website or sales funnel designed from a blank Figma canvas. No templates. Built around your buyer, your offer, and your brand.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .cs-hero { padding: 100px 0 50px; text-align: center; max-width: 880px; margin: 0 auto; }
    .cs-eyebrow { display: inline-block; font-size: .68rem; font-weight: 700; color: #db2777; background: #fdf2f8; padding: 7px 14px; border-radius: 999px; letter-spacing: .14em; text-transform: uppercase; margin-bottom: 20px; }
    .cs-hero h1 { font-size: clamp(2.4rem, 5vw, 3.8rem); letter-spacing: -0.04em; line-height: 1.02; margin: 0 0 18px; }
    .cs-hero h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; background: linear-gradient(135deg,#db2777,#9333ea); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .cs-hero p { font-size: 1.12rem; color: var(--muted); line-height: 1.65; max-width: 640px; margin: 0 auto 32px; }
    .cs-photo { max-width: 1100px; margin: 60px auto; position: relative; border-radius: 28px; overflow: hidden; aspect-ratio: 16/9; box-shadow: 0 70px 140px -50px rgba(11,16,32,.55); }
    .cs-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform 1.4s ease; }
    .cs-photo:hover img { transform: scale(1.04); }
    .cs-photo::after { content: ""; position: absolute; inset: 0; background: linear-gradient(180deg, transparent 60%, rgba(11,16,32,.5)); pointer-events: none; }
    .cs-photo-cap { position: absolute; bottom: 24px; left: 28px; right: 28px; color: #fff; font-size: .92rem; font-weight: 500; }
    .cs-cols { padding: 80px 0; background: #fff; border-top: 1px solid var(--line); }
    .cs-cols-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .cs-col { padding: 28px 24px; background: #fafafa; border-radius: 16px; border: 1px solid #f4f4f5; transition: background .25s ease, border-color .25s ease; }
    .cs-col:hover { background: #fdf2f8; border-color: #fbcfe8; }
    .cs-col h3 { font-size: .98rem; margin: 0 0 8px; }
    .cs-col p { font-size: .88rem; color: var(--soft); margin: 0; line-height: 1.55; }
    .cs-col .ico { width: 36px; height: 36px; display: grid; place-items: center; background: #fff; border-radius: 10px; margin-bottom: 14px; color: #db2777; box-shadow: 0 4px 12px rgba(219,39,119,.12); }
    .cs-cta { padding: 90px 0; text-align: center; }
    .cs-cta h2 { font-size: clamp(1.6rem, 3vw, 2.4rem); margin: 0 0 14px; }
    @media (max-width: 880px) { .cs-cols-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 540px) { .cs-cols-grid { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container cs-hero">
    <span class="cs-eyebrow">Bespoke build</span>
    <h1>A site designed from a <em>blank canvas</em>, not a stretched template.</h1>
    <p>Custom design isn't aesthetic vanity. It's the difference between a site that mirrors what your competitors look like and one that mirrors how your buyers actually think. We start in Figma, with your audience research and your unfair advantage on the wall.</p>
    @auth
      <a href="{{ route('contact') }}?service=custom-site" class="btn btn-primary">Talk to a designer</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <figure class="cs-photo">
    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1800&q=80&auto=format&fit=crop" alt="Designer at workstation with code and design tools">
    <figcaption class="cs-photo-cap">Every section is wireframed twice and design-reviewed by a senior before a single line of code is written.</figcaption>
  </figure>

  <section class="cs-cols">
    <div class="container">
      <h2 style="text-align:center; max-width:640px; margin:0 auto 44px;">What "custom" actually means here.</h2>
      <div class="cs-cols-grid">
        <div class="cs-col">
          <span class="ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></span>
          <h3>Audience-first wireframes</h3>
          <p>Three rounds in Figma. Buyer journey mapped. Section order tested against real intent, not vibes.</p>
        </div>
        <div class="cs-col">
          <span class="ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7l8-4 8 4M4 7v10l8 4 8-4V7M4 7l8 4 8-4"/></svg></span>
          <h3>Brand system</h3>
          <p>Color, type, motion, voice. Documented as a Figma library you keep — not a screenshot dropped in a Notion page.</p>
        </div>
        <div class="cs-col">
          <span class="ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></span>
          <h3>Hand-coded build</h3>
          <p>No page builder bloat. Semantic HTML, system-grade CSS, JS only where it earns its keep. Lighthouse 95+ at launch.</p>
        </div>
        <div class="cs-col">
          <span class="ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></span>
          <h3>Performance budget</h3>
          <p>2-second LCP target on a 4G connection. We measure on real devices and refuse to launch if we miss the bar.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="cs-cta">
    <div class="container">
      <h2>A site that looks like it costs <em class="serif-italic">five times</em> what we charged.</h2>
      <p style="color:var(--soft); max-width:560px; margin:0 auto 28px;">Three to five weeks. Two senior designers + one engineer. Fixed scope, no surprises.</p>
      @auth
        <a href="{{ route('contact') }}?service=custom-site" class="btn btn-primary btn-lg">Start the conversation →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary btn-lg">Create account &amp; view pricing →</a>
      @endauth
    </div>
  </section>

  @include('partials.footer')
@endsection
