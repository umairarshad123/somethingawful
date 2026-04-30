@extends('layouts.app')

@section('title', 'Services — Digirisers')
@section('description', 'Every service in the Digirisers platform — websites, AI agents, SEO, paid ads, CRM automation, organic marketing, hosting, and brand. Transparent pricing.')
@section('robots', 'index,follow')

@php
  $cats = collect(config('catalog.categories', []))->sortBy('order')->values();
  $totalItems = $cats->sum(fn ($c) => count($c['items']));
  $iconMap = [
    'monitor'  => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="14" rx="2"/><line x1="8" y1="20" x2="16" y2="20"/><line x1="12" y1="18" x2="12" y2="20"/></svg>',
    'brain'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4a3 3 0 0 0-3 3v1a3 3 0 0 0-2 5 3 3 0 0 0 2 5 3 3 0 0 0 3 3 3 3 0 0 0 3-3V7a3 3 0 0 0-3-3z"/><path d="M15 4a3 3 0 0 1 3 3v1a3 3 0 0 1 2 5 3 3 0 0 1-2 5 3 3 0 0 1-3 3 3 3 0 0 1-3-3"/></svg>',
    'search'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>',
    'target'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
    'workflow' => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><path d="M6.5 10v4a3 3 0 0 0 3 3H14"/></svg>',
    'megaphone'=> '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-8v18l-18-8v-2z"/><path d="M11 13v6a2 2 0 0 0 4 0v-3"/></svg>',
    'shield'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
    'sparkle'  => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l2 5 5 2-5 2-2 5-2-5-5-2 5-2z"/></svg>',
  ];
@endphp

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    section { padding: 100px 0; position: relative; }
    .container { max-width: 1240px; }

    .svc-hero {
      position: relative; overflow: hidden;
      background: var(--grad-soft);
      padding: 90px 0 70px;
      border-bottom: 1px solid var(--line);
    }
    .svc-hero::before {
      content: ""; position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(148,163,184,.15) 1px, transparent 1px),
        linear-gradient(90deg, rgba(148,163,184,.15) 1px, transparent 1px);
      background-size: 56px 56px;
      mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%);
      pointer-events: none;
    }
    .svc-hero::after {
      content: ""; position: absolute; top: -160px; left: 50%; transform: translateX(-50%);
      width: 1100px; height: 600px;
      background: radial-gradient(ellipse at center, rgba(59,130,246,.22) 0%, transparent 55%);
      pointer-events: none;
    }
    .svc-hero-inner { position: relative; z-index: 1; max-width: 820px; text-align: center; margin: 0 auto; }
    .svc-hero h1 { margin-bottom: 18px; }
    .svc-hero p { font-size: 1.15rem; color: var(--muted); max-width: 660px; margin: 0 auto 32px; }
    .svc-stats { display: inline-flex; gap: 32px; flex-wrap: wrap; justify-content: center; margin-top: 8px; }
    .svc-stat strong { display: block; font-size: 1.6rem; font-weight: 800; color: var(--ink); letter-spacing: -0.02em; }
    .svc-stat small { font-size: .8rem; color: var(--soft); text-transform: uppercase; letter-spacing: .08em; font-weight: 600; }

    /* Modules grid */
    .modules { background: #fff; padding: 90px 0; }
    .module-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 18px;
    }
    .module {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 22px;
      padding: 28px 24px 24px;
      display: flex; flex-direction: column;
      position: relative; overflow: hidden;
      transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
      text-decoration: none;
      color: inherit;
    }
    .module::before {
      content: ""; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: var(--grad);
      transform: scaleX(0); transform-origin: left;
      transition: transform .5s ease;
    }
    .module:hover { transform: translateY(-4px); border-color: var(--blue-300); box-shadow: var(--shadow-lg); color: inherit; }
    .module:hover::before { transform: scaleX(1); }
    .module-num {
      position: absolute; top: 22px; right: 24px;
      font-family: var(--font-mono); font-size: .72rem;
      color: var(--soft-2); letter-spacing: .08em; font-weight: 600;
    }
    .module-icon {
      width: 48px; height: 48px; border-radius: 12px;
      background: var(--blue-50); color: var(--blue-700);
      display: grid; place-items: center;
      margin-bottom: 16px;
      transition: background .3s ease, color .3s ease, transform .3s ease;
    }
    .module:hover .module-icon { background: var(--ink); color: #fff; transform: rotate(-6deg) scale(1.05); }
    .module h3 {
      font-size: 1.05rem; font-weight: 700; color: var(--ink);
      margin: 0 0 6px; letter-spacing: -0.015em;
    }
    .module .tagline { font-size: .82rem; color: var(--blue-700); font-weight: 600; margin: 0 0 12px; letter-spacing: -0.005em; }
    .module p.blurb { font-size: .9rem; color: var(--soft); margin: 0 0 16px; line-height: 1.5; }
    .module ul { list-style: none; margin: 0 0 18px; padding: 0; display: grid; gap: 6px; flex: 1; }
    .module ul li {
      position: relative; padding-left: 16px;
      font-size: .82rem; color: var(--muted); line-height: 1.4;
    }
    .module ul li::before {
      content: ""; position: absolute; left: 0; top: 7px;
      width: 6px; height: 6px; border-radius: 50%;
      background: var(--blue-200); border: 1.5px solid var(--blue-500);
    }
    .module-foot {
      display: flex; align-items: center; justify-content: space-between;
      padding-top: 14px; border-top: 1px dashed var(--line);
      gap: 10px;
    }
    .module-from { font-size: .78rem; color: var(--soft); font-family: var(--font-mono); }
    .module-from strong { color: var(--ink); font-weight: 700; }
    .module-cta {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 7px 12px; border-radius: 999px;
      font-size: .78rem; font-weight: 600;
      background: var(--bg-soft);
      color: var(--ink);
      transition: background .2s ease, color .2s ease;
    }
    .module:hover .module-cta { background: var(--ink); color: #fff; }

    /* Bottom CTA */
    .svc-bottom { background: var(--ink); color: #fff; padding: 90px 0; position: relative; overflow: hidden; }
    .svc-bottom::before { content: ""; position: absolute; top: -200px; left: 50%; transform: translateX(-50%); width: 1100px; height: 600px; background: radial-gradient(ellipse at center, rgba(59,130,246,.28) 0%, transparent 55%); pointer-events: none; }
    .svc-bottom-inner { position: relative; z-index: 1; max-width: 720px; margin: 0 auto; text-align: center; }
    .svc-bottom h2 { color: #fff; margin: 0 0 16px; }
    .svc-bottom h2 .serif-italic { color: var(--blue-300); }
    .svc-bottom p { color: rgba(255,255,255,.7); font-size: 1.1rem; margin: 0 0 28px; }
    .svc-bottom .btn-primary { background: #fff; color: var(--ink); }
    .svc-bottom .btn-primary:hover { background: var(--blue-100); color: var(--ink); }
    .svc-bottom .btn-ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.2); }
    .svc-bottom .btn-ghost:hover { background: rgba(255,255,255,.08); border-color: #fff; color: #fff; }

    @media (max-width: 1080px) {
      .module-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
      section { padding: 70px 0; }
      .module-grid { grid-template-columns: 1fr; }
      .svc-hero { padding: 70px 0 50px; }
      .svc-stats { gap: 20px; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <section class="svc-hero">
    <div class="container svc-hero-inner">
      <span class="eyebrow"><span class="dot"></span><span>Platform Catalog</span></span>
      <h1>Every system. <span class="gradient-text">One platform.</span></h1>
      <p>The full Digirisers platform — eight modules, {{ $totalItems }} priced services. Pick what you need, or hire the whole stack. Real prices. Real timelines. No bloated agency retainers.</p>
      <div class="svc-stats">
        <div class="svc-stat"><strong>{{ count($cats) }}</strong><small>Modules</small></div>
        <div class="svc-stat"><strong>{{ $totalItems }}</strong><small>Services</small></div>
        <div class="svc-stat"><strong>From $25</strong><small>Starting price</small></div>
        <div class="svc-stat"><strong>1–3 wks</strong><small>Avg. delivery</small></div>
      </div>
    </div>
  </section>

  <section class="modules">
    <div class="container">
      <div class="module-grid">
        @foreach ($cats as $i => $c)
          @php
            $idx = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
            $minPrice = collect($c['items'])->min('price');
          @endphp
          <a class="module" href="{{ url('/services/'.$c['id']) }}">
            <span class="module-num">{{ $idx }} / 08</span>
            <div class="module-icon">{!! $iconMap[$c['icon']] ?? $iconMap['sparkle'] !!}</div>
            <h3>{{ $c['title'] }}</h3>
            <p class="tagline">{{ $c['tagline'] }}</p>
            <p class="blurb">{{ $c['blurb'] }}</p>
            <ul>
              @foreach (array_slice($c['items'], 0, 4) as $it)
                <li>{{ Str::limit($it['name'], 38) }}</li>
              @endforeach
              @if (count($c['items']) > 4)
                <li style="color:var(--blue-700); font-weight:600;">+ {{ count($c['items']) - 4 }} more</li>
              @endif
            </ul>
            <div class="module-foot">
              @auth
                <span class="module-from">From <strong>${{ number_format($minPrice) }}</strong></span>
              @else
                <span class="module-from" style="color:var(--blue-700); font-weight:600;">
                  <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px; margin-right:3px;" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  Sign in for pricing
                </span>
              @endauth
              <span class="module-cta">Explore →</span>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  <section class="svc-bottom">
    <div class="container svc-bottom-inner">
      <h2>Ready to <span class="serif-italic">scale?</span></h2>
      <p>Pick services off the shelf in our Shop, or talk to us about a custom growth engagement.</p>
      <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
        <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Shop services →</a>
        <a href="{{ route('contact') }}" class="btn btn-ghost btn-lg">Book a strategy call</a>
      </div>
    </div>
  </section>

  @include('partials.footer')

@endsection
