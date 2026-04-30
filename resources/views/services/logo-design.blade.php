@extends('layouts.app')
@section('title', 'Logo Design — Digirisers')
@section('description', 'A custom logo designed properly: research, iteration, and a final mark you own outright in vector, raster, and brand-system-ready formats.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .lg { padding: 100px 0; max-width: 1080px; margin: 0 auto; text-align: center; }
    .lg .tag { display:inline-block; font-size:.74rem; font-weight:700; color:#0f172a; background:#f1f5f9; padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .lg h1 { font-size: clamp(2.8rem, 6vw, 4.4rem); margin: 18px 0 18px; letter-spacing: -0.04em; }
    .lg h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #0f172a; }
    .lg p { color: var(--muted); font-size: 1.1rem; max-width: 640px; margin: 0 auto 28px; line-height: 1.65; }
    .lg-marks { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; padding: 60px 24px; background: #fafafa; border-radius: 20px; margin: 60px 0; }
    .lg-marks .mark { aspect-ratio: 1; background: #fff; border-radius: 14px; display: grid; place-items: center; border: 1px solid var(--line); transition: transform .25s ease, box-shadow .25s ease; }
    .lg-marks .mark:hover { transform: translateY(-4px); box-shadow: 0 24px 50px -28px rgba(11,16,32,.25); }
    .lg-marks .mark span { font-weight: 800; font-size: 1.6rem; letter-spacing: -0.04em; }
    .lg-marks .mark.style-1 span { background: linear-gradient(135deg,#0ea5e9,#1e3a8a); -webkit-background-clip:text; background-clip:text; color: transparent; }
    .lg-marks .mark.style-2 { background: #0f172a; } .lg-marks .mark.style-2 span { color: #fff; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .lg-marks .mark.style-3 span { color: #dc2626; }
    .lg-marks .mark.style-4 { background: #16a34a; } .lg-marks .mark.style-4 span { color: #fff; }
    .lg-marks .mark.style-5 { border: 2px solid #0f172a; } .lg-marks .mark.style-5 span { color: #0f172a; font-family: var(--font-mono); }
    .lg-marks .mark.style-6 { background: linear-gradient(135deg,#f59e0b,#dc2626); } .lg-marks .mark.style-6 span { color: #fff; }
    .lg-process { padding: 60px 0; text-align: left; }
    .lg-process h2 { text-align: center; max-width: 600px; margin: 0 auto 36px; }
    .lg-process .row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .lg-process .step { padding: 24px; background: #f8fafc; border: 1px solid var(--line); border-radius: 14px; }
    .lg-process .step .day { color: #0f172a; font-family: var(--font-mono); font-size: .76rem; font-weight: 700; letter-spacing: .12em; }
    .lg-process .step h3 { margin: 6px 0 6px; font-size: 1rem; }
    .lg-process .step p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .lg-marks { grid-template-columns: 1fr 1fr 1fr; } .lg-process .row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="lg">
    <span class="tag">Logo design</span>
    <h1>A mark you'll <em>still like</em> in five years.</h1>
    <p>Trends die. Good logos last. We start with research — your competitors, your category visual codes, your audience expectations — then design a mark that sits comfortably alongside the brands your customers already trust.</p>
    @auth
      <a href="{{ route('contact') }}?service=logo-design" class="btn btn-primary">Start the design →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth

    <div class="lg-marks">
      <div class="mark style-1"><span>A</span></div>
      <div class="mark style-2"><span>b</span></div>
      <div class="mark style-3"><span>C</span></div>
      <div class="mark style-4"><span>D</span></div>
      <div class="mark style-5"><span>E</span></div>
      <div class="mark style-6"><span>F</span></div>
    </div>

    <div class="lg-process">
      <h2>The 7-day timeline.</h2>
      <div class="row">
        <div class="step"><span class="day">DAY 1-2</span><h3>Brief + research</h3><p>One call. Brand archetype work. Five reference brands you love, three you hate. Audit your category visual conventions.</p></div>
        <div class="step"><span class="day">DAY 3-5</span><h3>Three concepts</h3><p>Three distinct directions, each with a primary mark, mono variant, and typesystem pairing. Live-presented over a 30-minute call.</p></div>
        <div class="step"><span class="day">DAY 6-7</span><h3>Refine + handoff</h3><p>One direction selected, two refinement rounds. Final files: SVG, PNG (transparent + white BG), favicons, social avatars.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
