@extends('layouts.app')
@section('title', 'Canva Creative Design — Digirisers')
@section('description', 'Canva-native creative design for fast-turnaround social, ads, and email assets — designed by humans who know when to break Canva\'s defaults.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .cv { padding: 90px 0; max-width: 1100px; margin: 0 auto; }
    .cv .tag { font-size:.74rem; font-weight:700; color:#075985; background:#e0f2fe; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .cv h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; max-width: 740px; }
    .cv h1 em { color: #0284c7; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .cv p.lede { color: var(--muted); font-size: 1.06rem; line-height: 1.65; max-width: 600px; margin: 0 0 28px; }
    .cv-mosaic { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; margin: 50px 0; }
    .cv-mosaic figure { aspect-ratio: 1; border-radius: 14px; overflow: hidden; }
    .cv-mosaic figure:nth-child(1) { grid-column: span 2; grid-row: span 2; aspect-ratio: 1; }
    .cv-mosaic figure:nth-child(4) { grid-column: span 2; aspect-ratio: 2/1; }
    .cv-mosaic figure img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s ease; }
    .cv-mosaic figure:hover img { transform: scale(1.06); }
    .cv-bar { padding: 70px 0; background: #f0f9ff; }
    .cv-bar h2 { text-align: center; max-width: 600px; margin: 0 auto 30px; }
    .cv-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; max-width: 1000px; margin: 0 auto; }
    .cv-row > div { padding: 24px; background: #fff; border: 1px solid #bae6fd; border-radius: 14px; }
    .cv-row strong { display: block; color: #0284c7; font-size: .82rem; font-family: var(--font-mono); letter-spacing: .12em; margin-bottom: 8px; }
    .cv-row h3 { font-size: 1rem; margin: 0 0 6px; }
    .cv-row p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .cv-mosaic { grid-template-columns: 1fr 1fr; } .cv-mosaic figure { grid-column: span 1 !important; grid-row: span 1 !important; aspect-ratio: 1 !important; } .cv-row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container cv">
    <span class="tag">Canva creative · per asset</span>
    <h1>Fast-turnaround creative that <em>doesn't</em> look fast.</h1>
    <p class="lede">Canva is brilliant for speed. The default templates make everyone look like everyone else. We design in Canva so your team can edit later — but we override the defaults: real type pairings, real grids, real photo treatments, your actual brand colors, your specific tone.</p>
    @auth
      <a href="{{ route('contact') }}?service=canva-design" class="btn btn-primary">Send a brief →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth

    <div class="cv-mosaic">
      <figure><img src="https://images.unsplash.com/photo-1542223189-67a03fa0f0bd?w=900&q=80&auto=format&fit=crop" alt="Design 1"></figure>
      <figure><img src="https://images.unsplash.com/photo-1561070791-2526d30994b8?w=600&q=80&auto=format&fit=crop" alt="Design 2"></figure>
      <figure><img src="https://images.unsplash.com/photo-1611162616475-46b635cb6868?w=600&q=80&auto=format&fit=crop" alt="Design 3"></figure>
      <figure><img src="https://images.unsplash.com/photo-1493612276216-ee3925520721?w=900&q=80&auto=format&fit=crop" alt="Design 4"></figure>
      <figure><img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&q=80&auto=format&fit=crop" alt="Design 5"></figure>
      <figure><img src="https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=600&q=80&auto=format&fit=crop" alt="Design 6"></figure>
    </div>
  </section>

  <section class="cv-bar">
    <div class="container">
      <h2>Asset types we design.</h2>
      <div class="cv-row">
        <div><strong>SOCIAL</strong><h3>Posts + carousels</h3><p>Square, vertical, story format. Text optimized for thumb-scroll. Typography that scales.</p></div>
        <div><strong>ADS</strong><h3>Static + video</h3><p>Multi-aspect-ratio creative for paid social. A/B variants delivered in one batch.</p></div>
        <div><strong>EMAIL</strong><h3>Headers + spots</h3><p>Hero images, product cards, newsletter graphics. Sized to render right in dark + light mode.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
