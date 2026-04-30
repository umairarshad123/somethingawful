@extends('layouts.app')
@section('title', 'On-Page SEO (per 10 pages) — Digirisers')
@section('description', 'Hand-tuned on-page optimization across the pages that matter — title tags, internal linking, content gaps, schema, and intent matching. Done in batches of 10.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .op { padding: 90px 0; text-align: center; max-width: 880px; margin: 0 auto; }
    .op .tag { font-size:.74rem; font-weight:700; color:#7e22ce; background:#faf5ff; padding:6px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .op h1 { font-size: clamp(2.2rem, 4.5vw, 3.4rem); margin: 18px 0 18px; }
    .op h1 em { color: #9333ea; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .op p { color: var(--muted); font-size: 1.08rem; line-height: 1.65; max-width: 620px; margin: 0 auto 28px; }
    .op-photo { max-width: 1100px; margin: 60px auto; aspect-ratio: 16/9; border-radius: 26px; overflow: hidden; box-shadow: 0 50px 100px -40px rgba(11,16,32,.4); }
    .op-photo img { width: 100%; height: 100%; object-fit: cover; }
    .op-cards { padding: 70px 0; background: linear-gradient(180deg, #fff 0%, #faf5ff 100%); }
    .op-cards h2 { text-align: center; max-width: 600px; margin: 0 auto 44px; }
    .op-row { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 14px; }
    .op-row > div { padding: 24px; background: #fff; border: 1px solid #e9d5ff; border-radius: 16px; transition: transform .25s ease, box-shadow .25s ease; }
    .op-row > div:hover { transform: translateY(-4px); box-shadow: 0 24px 50px -28px rgba(147,51,234,.4); }
    .op-row strong { display: block; color: #7e22ce; font-size: .76rem; letter-spacing: .12em; text-transform: uppercase; font-family: var(--font-mono); margin-bottom: 8px; }
    .op-row h3 { font-size: 1rem; margin: 0 0 8px; }
    .op-row p { font-size: .88rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .op-row { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container op">
    <span class="tag">On-page · per 10 pages</span>
    <h1>The work that takes content from <em>indexed</em> to <em>ranked</em>.</h1>
    <p>Most pages on most sites are 60% optimized. The last 40% — title hierarchy, internal links to and from the right neighbors, schema, intent-matched copy, the right H2s in the right order — is where the rankings live. We do that work, in batches of ten pages, with a written before/after for each.</p>
    @auth
      <a href="{{ route('contact') }}?service=on-page-seo" class="btn btn-primary">Pick the 10 pages →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <figure class="op-photo"><img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=1800&q=80&auto=format&fit=crop" alt="On-page SEO planning notes"></figure>

  <section class="op-cards">
    <div class="container">
      <h2>The four passes per page.</h2>
      <div class="op-row">
        <div><strong>Pass 01</strong><h3>Intent match</h3><p>We compare your page to the top-ranking ten and rewrite headers / structure to match the dominant search intent — informational, comparison, transactional.</p></div>
        <div><strong>Pass 02</strong><h3>Content gaps</h3><p>Topic-cluster analysis surfaces the subtopics every ranking page covers that yours doesn't. We add the missing sections in your voice.</p></div>
        <div><strong>Pass 03</strong><h3>Internal linking</h3><p>Right-neighbor links in and out using exact-match and partial-match anchors. We never use "click here." Every link earns its place.</p></div>
        <div><strong>Pass 04</strong><h3>Schema + technicals</h3><p>Article, FAQ, HowTo, Product schema as appropriate. Image alt, canonical, meta description, OpenGraph — all polished.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
