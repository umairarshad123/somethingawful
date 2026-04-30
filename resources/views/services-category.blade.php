@extends('layouts.app')

@section('title', $cat['title'] . ' — Digirisers')
@section('description', $cat['blurb'])
@section('robots', 'index,follow')

@php
  $iconMap = [
    'monitor'  => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="14" rx="2"/><line x1="8" y1="20" x2="16" y2="20"/><line x1="12" y1="18" x2="12" y2="20"/></svg>',
    'brain'    => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4a3 3 0 0 0-3 3v1a3 3 0 0 0-2 5 3 3 0 0 0 2 5 3 3 0 0 0 3 3 3 3 0 0 0 3-3V7a3 3 0 0 0-3-3z"/><path d="M15 4a3 3 0 0 1 3 3v1a3 3 0 0 1 2 5 3 3 0 0 1-2 5 3 3 0 0 1-3 3 3 3 0 0 1-3-3"/></svg>',
    'search'   => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>',
    'target'   => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
    'workflow' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><path d="M6.5 10v4a3 3 0 0 0 3 3H14"/></svg>',
    'megaphone'=> '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-8v18l-18-8v-2z"/><path d="M11 13v6a2 2 0 0 0 4 0v-3"/></svg>',
    'shield'   => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
    'sparkle'  => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l2 5 5 2-5 2-2 5-2-5-5-2 5-2z"/></svg>',
  ];
  $cycleLabel = ['project' => 'one-time', 'mo' => '/month', 'week' => '/week', 'per Zap' => 'per Zap', 'per script' => 'per script', 'per asset' => 'per asset'];
  $minPrice = collect($cat['items'])->min('price');
  $allCats = collect(config('catalog.categories', []))->sortBy('order')->values();
@endphp

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    section { padding: 90px 0; position: relative; }
    .container { max-width: 1240px; }

    /* Hero */
    .cat-hero {
      position: relative; overflow: hidden;
      background: var(--grad-soft);
      padding: 80px 0 70px;
      border-bottom: 1px solid var(--line);
    }
    .cat-hero::before {
      content: ""; position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(148,163,184,.15) 1px, transparent 1px),
        linear-gradient(90deg, rgba(148,163,184,.15) 1px, transparent 1px);
      background-size: 56px 56px;
      mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%);
      pointer-events: none;
    }
    .cat-hero-inner { position: relative; z-index: 1; max-width: 880px; margin: 0 auto; text-align: center; }
    .breadcrumbs { font-size: .85rem; color: var(--soft); margin-bottom: 18px; font-family: var(--font-mono); letter-spacing: .02em; }
    .breadcrumbs a { color: var(--blue-700); }
    .breadcrumbs span { margin: 0 8px; opacity: .5; }
    .cat-hero-icon {
      display: inline-grid; place-items: center;
      width: 64px; height: 64px; border-radius: 16px;
      background: var(--grad); color: #fff;
      margin-bottom: 22px;
      box-shadow: 0 14px 30px -10px rgba(37,99,235,.5);
    }
    .cat-hero h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); margin-bottom: 14px; }
    .cat-hero .tagline { font-size: 1.05rem; color: var(--blue-700); font-weight: 600; margin-bottom: 16px; letter-spacing: -0.005em; }
    .cat-hero .hero-blurb { font-size: 1.1rem; color: var(--muted); max-width: 660px; margin: 0 auto 28px; }
    .cat-meta {
      display: inline-flex; gap: 24px; flex-wrap: wrap; justify-content: center;
      padding: 14px 22px;
      background: #fff; border: 1px solid var(--line); border-radius: 999px;
      box-shadow: var(--shadow-sm);
    }
    .cat-meta div { font-size: .82rem; color: var(--soft); }
    .cat-meta strong { color: var(--ink); font-weight: 700; }

    /* Process strip */
    .process-strip { background: #fff; border-bottom: 1px solid var(--line); padding: 56px 0; }
    .process-strip-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
    .process-step {
      padding: 20px;
      background: var(--bg-soft); border: 1px solid var(--line); border-radius: 14px;
      transition: border-color .2s ease, transform .2s ease;
    }
    .process-step:hover { border-color: var(--blue-300); transform: translateY(-2px); }
    .process-step .step-num {
      display: inline-block;
      font-family: var(--font-mono); font-size: .7rem; font-weight: 700;
      color: var(--blue-700); background: var(--blue-50);
      padding: 3px 8px; border-radius: 6px; margin-bottom: 8px;
    }
    .process-step h4 { font-size: 1rem; font-weight: 700; color: var(--ink); margin: 0 0 4px; }
    .process-step p { font-size: .85rem; color: var(--soft); margin: 0; line-height: 1.45; }

    /* Items list */
    .items-section { background: var(--bg-soft); }
    .items-head { display: flex; justify-content: space-between; align-items: baseline; gap: 14px; flex-wrap: wrap; margin-bottom: 32px; }
    .items-head h2 { margin: 0; font-size: clamp(1.6rem, 3vw, 2.2rem); letter-spacing: -0.025em; }
    .items-head h2 .count { font-size: .9rem; color: var(--soft); font-family: var(--font-mono); font-weight: 500; margin-left: 8px; }
    .items-head .filter-note { font-size: .85rem; color: var(--soft); }

    .item-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 16px;
    }
    .item-card {
      position: relative;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 16px;
      padding: 22px;
      display: flex; flex-direction: column;
      transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
      text-decoration: none;
      color: inherit;
    }
    .item-card:hover { transform: translateY(-3px); border-color: var(--blue-300); box-shadow: var(--shadow); color: inherit; }
    .item-card .tag {
      position: absolute; top: 14px; right: 14px;
      font-size: .6rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em;
      padding: 3px 8px; border-radius: 999px;
    }
    .item-card .tag.popular { background: var(--ink); color: #fff; }
    .item-card .tag.new { background: var(--blue-600); color: #fff; }
    .item-card h3 { font-size: 1.02rem; font-weight: 700; color: var(--ink); margin: 0 0 6px; padding-right: 56px; letter-spacing: -0.01em; }
    .item-card .blurb { font-size: .88rem; color: var(--soft); margin: 0 0 16px; line-height: 1.5; flex: 1; }
    .item-card .price-row { display: flex; align-items: baseline; gap: 4px; margin-bottom: 12px; }
    .item-card .price { font-size: 1.4rem; font-weight: 800; color: var(--ink); letter-spacing: -0.02em; line-height: 1; }
    .item-card .cycle { font-size: .82rem; color: var(--soft); }
    .item-card .row-foot { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding-top: 12px; border-top: 1px dashed var(--line); }
    .item-card .timeline { font-size: .76rem; color: var(--soft); font-family: var(--font-mono); }
    .item-card .arrow { display: inline-flex; align-items: center; gap: 4px; font-size: .82rem; font-weight: 600; color: var(--blue-700); transition: gap .2s ease; }
    .item-card:hover .arrow { gap: 8px; color: var(--blue-900); }

    /* Other modules */
    .other-modules { background: #fff; padding: 80px 0; border-top: 1px solid var(--line); }
    .other-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; }
    .other-mod {
      display: block; padding: 16px 18px;
      background: var(--bg-soft); border: 1px solid var(--line); border-radius: 12px;
      text-decoration: none; color: var(--ink);
      transition: border-color .2s ease, background .2s ease, transform .2s ease;
    }
    .other-mod:hover { border-color: var(--blue-300); background: #fff; transform: translateY(-2px); color: var(--ink); }
    .other-mod strong { display: block; font-size: .92rem; margin-bottom: 2px; }
    .other-mod small { font-size: .78rem; color: var(--soft); }

    /* Bottom CTA */
    .cat-bottom { background: var(--ink); color: #fff; padding: 90px 0; position: relative; overflow: hidden; }
    .cat-bottom::before { content: ""; position: absolute; top: -200px; left: 50%; transform: translateX(-50%); width: 1100px; height: 600px; background: radial-gradient(ellipse at center, rgba(59,130,246,.28) 0%, transparent 55%); pointer-events: none; }
    .cat-bottom-inner { position: relative; z-index: 1; max-width: 720px; margin: 0 auto; text-align: center; }
    .cat-bottom h2 { color: #fff; margin: 0 0 16px; }
    .cat-bottom h2 .serif-italic { color: var(--blue-300); }
    .cat-bottom p { color: rgba(255,255,255,.7); font-size: 1.1rem; margin: 0 0 28px; }
    .cat-bottom .btn-primary { background: #fff; color: var(--ink); }
    .cat-bottom .btn-primary:hover { background: var(--blue-100); color: var(--ink); }
    .cat-bottom .btn-ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.2); }
    .cat-bottom .btn-ghost:hover { background: rgba(255,255,255,.08); border-color: #fff; color: #fff; }

    @media (max-width: 980px) {
      .process-strip-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
      section { padding: 64px 0; }
      .cat-hero { padding: 56px 0 50px; }
      .process-strip-grid { grid-template-columns: 1fr; }
      .item-grid { grid-template-columns: 1fr; }
      .cat-meta { gap: 14px; padding: 12px 16px; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <section class="cat-hero">
    <div class="container cat-hero-inner">
      <div class="breadcrumbs">
        <a href="{{ url('/') }}">Home</a> <span>›</span>
        <a href="{{ url('/services') }}">Platform</a> <span>›</span>
        <strong style="color:var(--ink);">{{ $cat['title'] }}</strong>
      </div>
      <span class="cat-hero-icon" aria-hidden="true">{!! $iconMap[$cat['icon']] ?? $iconMap['sparkle'] !!}</span>
      <h1>{{ $cat['title'] }}</h1>
      <p class="tagline">{{ $cat['tagline'] }}</p>
      <p class="hero-blurb">{{ $cat['hero'] }}</p>
      <div class="cat-meta">
        <div><strong>{{ count($cat['items']) }}</strong> services</div>
        <div>From <strong>${{ number_format($minPrice) }}</strong></div>
        <div><strong>{{ ucfirst($cat['eyebrow']) }}</strong> module</div>
      </div>
    </div>
  </section>

  <section class="process-strip">
    <div class="container">
      <div class="process-strip-grid">
        @foreach ($cat['process'] as $i => $step)
          <div class="process-step">
            <span class="step-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <h4>{{ $step[0] }}</h4>
            <p>{{ $step[1] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="items-section">
    <div class="container">
      <div class="items-head">
        <h2>Pick a service<span class="count">{{ count($cat['items']) }} available</span></h2>
        <p class="filter-note">Tap any card to see what's included, timeline, and add to cart.</p>
      </div>

      <div class="item-grid">
        @foreach ($cat['items'] as $it)
          <a class="item-card" href="{{ url('/shop/'.$it['slug']) }}">
            @if (!empty($it['tag']))
              <span class="tag {{ $it['tag'] }}">{{ $it['tag'] }}</span>
            @endif
            <h3>{{ $it['name'] }}</h3>
            <p class="blurb">{{ $it['blurb'] }}</p>
            <div class="price-row">
              <span class="price">${{ number_format($it['price']) }}</span>
              <span class="cycle">{{ $cycleLabel[$it['cycle']] ?? '' }}</span>
            </div>
            <div class="row-foot">
              <span class="timeline">{{ $it['timeline'] }}</span>
              <span class="arrow">View details →</span>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  <section class="other-modules">
    <div class="container">
      <h2 style="font-size:clamp(1.4rem, 2.6vw, 1.8rem); margin:0 0 22px;">Other modules</h2>
      <div class="other-grid">
        @foreach ($allCats as $other)
          @if ($other['id'] !== $cat['id'])
            <a class="other-mod" href="{{ url('/services/'.$other['id']) }}">
              <strong>{{ $other['title'] }}</strong>
              <small>{{ $other['tagline'] }}</small>
            </a>
          @endif
        @endforeach
      </div>
    </div>
  </section>

  <section class="cat-bottom">
    <div class="container cat-bottom-inner">
      <h2>Need a custom <span class="serif-italic">{{ Str::lower(explode(' ', $cat['title'])[0]) }}</span> engagement?</h2>
      <p>Pick a package above to get started, or talk to us about a fully scoped engagement.</p>
      <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
        <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Browse Shop →</a>
        <a href="{{ url('/') }}#contact" class="btn btn-ghost btn-lg">Book a strategy call</a>
      </div>
    </div>
  </section>

  @include('partials.footer')

@endsection
