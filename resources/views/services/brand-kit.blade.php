@extends('layouts.app')
@section('title', 'Full Brand Identity Kit — Digirisers')
@section('description', 'A complete brand identity kit — logo system, color, type, voice, photography style, and a Figma library your team can build with for years.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .bk-hero { padding: 90px 0 50px; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
    .bk-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; }
    .bk-hero h1 em { color: #ec4899; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .bk-hero .tag { font-size:.74rem; font-weight:700; color:#9d174d; background:#fce7f3; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .bk-hero .lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 480px; }
    .bk-hero figure { aspect-ratio: 1; border-radius: 22px; overflow: hidden; }
    .bk-hero figure img { width: 100%; height: 100%; object-fit: cover; }
    .bk-stack { padding: 60px 0; }
    .bk-stack h2 { text-align: center; max-width: 580px; margin: 0 auto 30px; }
    .bk-deliv { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; max-width: 1100px; margin: 0 auto; }
    .bk-cell { padding: 26px; background: #fdf2f8; border: 1px solid #fbcfe8; border-radius: 14px; }
    .bk-cell strong { display: block; color: #be185d; font-size: .76rem; letter-spacing: .14em; text-transform: uppercase; font-family: var(--font-mono); margin-bottom: 8px; }
    .bk-cell h3 { font-size: 1rem; margin: 0 0 8px; }
    .bk-cell p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }
    .bk-color-strip { padding: 60px 0; background: #fff; }
    .bk-swatches { display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; max-width: 1100px; margin: 0 auto; }
    .bk-swatch { aspect-ratio: 1; border-radius: 14px; display: flex; flex-direction: column; justify-content: flex-end; padding: 14px; color: #fff; }
    .bk-swatch small { display: block; font-family: var(--font-mono); font-size: .7rem; opacity: .9; }
    @media (max-width: 880px) { .bk-hero { grid-template-columns: 1fr; } .bk-deliv { grid-template-columns: 1fr; } .bk-swatches { grid-template-columns: repeat(3, 1fr); } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container bk-hero">
    <div>
      <span class="tag">Brand identity · full kit</span>
      <h1>Everything that makes a brand feel <em>real</em>.</h1>
      <p class="lede">A logo isn't a brand. It's a hat. The brand is the system underneath: the colors that work in every context, the type that looks right at every size, the voice that's recognizably yours, the photography rules that hold the whole thing together. We build the entire system.</p>
      <p style="margin-top:24px;">
        @auth
          <a href="{{ route('contact') }}?service=brand-kit" class="btn btn-primary">Brief us in →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>
    </div>
    <figure><img src="https://images.unsplash.com/photo-1611162616475-46b635cb6868?w=1200&q=80&auto=format&fit=crop" alt="Brand identity materials"></figure>
  </section>

  <section class="bk-color-strip">
    <div class="container">
      <div class="bk-swatches">
        <div class="bk-swatch" style="background:#0f172a;"><small>#0F172A</small></div>
        <div class="bk-swatch" style="background:#1e3a8a;"><small>#1E3A8A</small></div>
        <div class="bk-swatch" style="background:#3b82f6;"><small>#3B82F6</small></div>
        <div class="bk-swatch" style="background:#ec4899;"><small>#EC4899</small></div>
        <div class="bk-swatch" style="background:#f59e0b;"><small>#F59E0B</small></div>
        <div class="bk-swatch" style="background:#16a34a;"><small>#16A34A</small></div>
        <div class="bk-swatch" style="background:#fafafa; color:#0f172a; border:1px solid var(--line);"><small style="opacity:1;">#FAFAFA</small></div>
      </div>
    </div>
  </section>

  <section class="bk-stack">
    <div class="container">
      <h2>What's in the kit.</h2>
      <div class="bk-deliv">
        <div class="bk-cell"><strong>01 · Logo</strong><h3>Mark + lockups</h3><p>Primary logo, mono, knockout, square, social avatars, favicon set. Sized and tested.</p></div>
        <div class="bk-cell"><strong>02 · Color</strong><h3>Palette + tokens</h3><p>Primary + secondary + neutrals + semantic. Hex, RGB, HSL, Pantone, CMYK. Tailwind / CSS-var-ready.</p></div>
        <div class="bk-cell"><strong>03 · Type</strong><h3>Pairing + scale</h3><p>Primary headline, body, accent. Type scale from H1 to caption with leading + tracking.</p></div>
        <div class="bk-cell"><strong>04 · Voice</strong><h3>Tone of voice doc</h3><p>How you sound. Words you use. Words you avoid. With 8 sample copy snippets across contexts.</p></div>
        <div class="bk-cell"><strong>05 · Photo</strong><h3>Visual style guide</h3><p>What your photography looks like — composition, light, color treatment. With 12 reference shots.</p></div>
        <div class="bk-cell"><strong>06 · Library</strong><h3>Figma + brandbook</h3><p>Live Figma library + 30-page PDF brandbook. Your team builds with the system, not from it.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
