@extends('layouts.app')

@section('title', $item['name'] . ' — Digirisers')
@section('description', $item['blurb'])
@section('robots', 'index,follow')

@php
  $cycleLabel = ['project' => 'one-time', 'mo' => '/month', 'week' => '/week', 'per Zap' => 'per Zap', 'per script' => 'per script', 'per asset' => 'per asset'];
  $cycleNote = [
    'project'    => 'One-time fee. Scope confirmed on call.',
    'mo'         => 'Monthly retainer. Cancel anytime.',
    'week'       => 'Per platform, billed weekly.',
    'per Zap'    => 'Per Zap built. Volume discount available.',
    'per script' => 'Per script. Volume discount available.',
    'per asset'  => 'Per creative asset. Volume discount available.',
  ];
  $related = collect($cat['items'])->where('slug', '!=', $item['slug'])->take(3)->values();
  $allCats = collect(config('catalog.categories', []))->sortBy('order')->values();

  /* Curated Unsplash hero per catalog category. Used as a soft photographic
     accent on the right of the hero. Falls back to a gradient if a category
     is missing. */
  $categoryHero = [
    'websites'        => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1400&q=80&auto=format&fit=crop',
    'seo'             => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1400&q=80&auto=format&fit=crop',
    'paid-ads'        => 'https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=1400&q=80&auto=format&fit=crop',
    'ai'              => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=1400&q=80&auto=format&fit=crop',
    'crm-automation'  => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1400&q=80&auto=format&fit=crop',
    'organic'         => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=1400&q=80&auto=format&fit=crop',
    'hosting'         => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1400&q=80&auto=format&fit=crop',
    'branding'        => 'https://images.unsplash.com/photo-1561070791-2526d30994b8?w=1400&q=80&auto=format&fit=crop',
  ];
  $heroImage = $categoryHero[$cat['id']] ?? $categoryHero['websites'];

  $faqs = [
    ['How does payment work?', 'No payment is taken on this site. After you submit an order request, we confirm scope on a 15-minute call, send a contract and invoice (Stripe or wire), and kick off when the deposit clears.'],
    ['What if my project is bigger than this package?', 'These are starting prices for the most common scope. If your project needs more — more pages, integrations, custom work — we adjust on the discovery call before any commitment. No surprise invoices.'],
    ['Can I bundle multiple services?', 'Yes — most clients order 2–4 services together. Add everything to your cart and we\'ll quote the bundle (often with a discount) on the confirmation call.'],
    ['How do revisions work?', 'Each package includes the revision rounds noted in "What\'s included". Additional rounds are billed hourly at $95/hr.'],
    ['What if I\'m not happy?', 'If we deliver outside scope or below the agreed quality bar, we fix it on us. We carry a 14-day satisfaction window on every project package — if we can\'t make it right, we refund.'],
  ];
@endphp

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    section { padding: 80px 0; position: relative; }
    .container { max-width: 1240px; }

    /* Hero */
    .pdp-hero {
      position: relative; overflow: hidden;
      background: var(--grad-soft);
      padding: 60px 0 80px;
      border-bottom: 1px solid var(--line);
    }
    .pdp-hero::before {
      content: ""; position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(148,163,184,.12) 1px, transparent 1px),
        linear-gradient(90deg, rgba(148,163,184,.12) 1px, transparent 1px);
      background-size: 56px 56px;
      mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%);
      pointer-events: none;
    }
    .pdp-hero-inner {
      position: relative; z-index: 1;
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 60px;
      align-items: start;
    }
    .breadcrumbs { font-size: .85rem; color: var(--soft); margin-bottom: 22px; font-family: var(--font-mono); letter-spacing: .02em; }
    .breadcrumbs a { color: var(--blue-700); }
    .breadcrumbs a:hover { color: var(--blue-900); }
    .breadcrumbs span { margin: 0 8px; opacity: .5; }

    .pdp-tag {
      display: inline-block;
      font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em;
      padding: 5px 10px; border-radius: 999px; margin-bottom: 14px;
    }
    .pdp-tag.popular { background: var(--ink); color: #fff; }
    .pdp-tag.new { background: var(--blue-600); color: #fff; }

    .pdp-cat-link {
      display: inline-block;
      font-size: .8rem; font-weight: 600;
      color: var(--blue-700); text-transform: uppercase; letter-spacing: .1em;
      margin-bottom: 12px;
    }
    .pdp-hero h1 { font-size: clamp(1.9rem, 4vw, 2.8rem); margin-bottom: 14px; letter-spacing: -0.03em; }
    .pdp-blurb { font-size: 1.1rem; color: var(--muted); margin: 0 0 22px; line-height: 1.55; }
    .pdp-detail { font-size: 1rem; color: var(--muted); line-height: 1.7; margin: 0 0 28px; }

    .pdp-meta-grid {
      display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
      margin-bottom: 32px;
    }
    .pdp-meta { padding: 14px 16px; background: #fff; border: 1px solid var(--line); border-radius: 12px; }
    .pdp-meta strong { display: block; font-size: .72rem; color: var(--soft); text-transform: uppercase; letter-spacing: .08em; font-weight: 600; margin-bottom: 4px; }
    .pdp-meta span { font-size: .92rem; color: var(--ink); font-weight: 600; }

    /* Photographic hero accent (Unsplash). Below the meta grid on desktop,
       full-width on mobile. */
    .pdp-photo {
      position: relative;
      margin-top: 28px;
      border-radius: 22px; overflow: hidden;
      aspect-ratio: 16 / 9;
      background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
      box-shadow: 0 30px 60px -25px rgba(11,16,32,.35);
    }
    .pdp-photo img {
      position: absolute; inset: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      mix-blend-mode: luminosity; opacity: .85;
      transition: transform .8s ease, opacity .3s ease;
    }
    .pdp-photo:hover img { transform: scale(1.04); opacity: 1; mix-blend-mode: normal; }
    .pdp-photo::after {
      content: ""; position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(30,58,138,.55) 0%, rgba(11,16,32,.15) 50%, transparent 100%);
      pointer-events: none;
    }
    .pdp-photo-tag {
      position: absolute; top: 18px; left: 18px;
      z-index: 1;
      display: inline-flex; align-items: center; gap: 6px;
      padding: 7px 14px;
      background: rgba(255,255,255,.92);
      backdrop-filter: blur(10px);
      border-radius: 999px;
      font-size: .72rem; font-weight: 700;
      color: #0b1020; text-transform: uppercase; letter-spacing: .08em;
    }
    .pdp-photo-tag .dot {
      width: 6px; height: 6px; border-radius: 50%;
      background: #2563eb;
      box-shadow: 0 0 0 3px rgba(37,99,235,.25);
    }

    /* Locked-pricing card shown to guests in place of the buy panel. */
    .pdp-locked {
      position: relative; overflow: hidden;
      background: linear-gradient(135deg, #f5f8ff 0%, #eff6ff 100%);
      border: 1.5px dashed #93c5fd;
      border-radius: 22px;
      padding: 28px;
      text-align: center;
    }
    .pdp-locked::before {
      content: ""; position: absolute; inset: -40% -10% auto auto;
      width: 220px; height: 220px;
      background: radial-gradient(circle, rgba(59,130,246,.25), transparent 70%);
      pointer-events: none;
    }
    .pdp-locked-icon {
      width: 56px; height: 56px;
      margin: 0 auto 14px;
      display: grid; place-items: center;
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      color: #fff; border-radius: 16px;
      box-shadow: 0 18px 40px -16px rgba(37,99,235,.6);
      position: relative; z-index: 1;
    }
    .pdp-locked h3 {
      font-size: 1.35rem; font-weight: 700; color: #0b1020;
      margin: 0 0 8px; letter-spacing: -0.02em;
      position: relative; z-index: 1;
    }
    .pdp-locked p {
      font-size: .94rem; color: #475569; margin: 0 0 22px; line-height: 1.55;
      position: relative; z-index: 1;
    }
    .pdp-locked .pdp-actions { position: relative; z-index: 1; }
    .pdp-locked .price-blur {
      filter: blur(6px); user-select: none;
      font-size: 2.4rem; font-weight: 800; color: #0b1020;
      letter-spacing: -0.03em; line-height: 1;
      margin-bottom: 18px;
      position: relative; z-index: 1;
    }

    /* Buy card */
    .pdp-buy {
      position: sticky; top: 100px;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 22px;
      padding: 28px;
      box-shadow: var(--shadow-lg);
    }
    .pdp-buy .price-from { font-size: .72rem; font-weight: 600; color: var(--soft); text-transform: uppercase; letter-spacing: .08em; }
    .pdp-buy .price-row { display: flex; align-items: baseline; gap: 6px; margin: 4px 0 4px; }
    .pdp-buy .price-amt { font-size: 2.6rem; font-weight: 800; color: var(--ink); letter-spacing: -0.03em; line-height: 1; }
    .pdp-buy .price-cycle { font-size: 1rem; color: var(--soft); font-weight: 500; }
    .pdp-buy .price-note { font-size: .82rem; color: var(--soft); margin: 0 0 22px; line-height: 1.5; }
    .pdp-actions { display: grid; gap: 10px; margin-bottom: 18px; }
    .btn-add {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 14px 18px; border-radius: 12px;
      font-family: inherit; font-size: .95rem; font-weight: 600;
      background: var(--ink); color: #fff;
      border: 0; cursor: pointer;
      transition: background .2s ease, transform .2s ease, box-shadow .25s ease;
    }
    .btn-add:hover { background: var(--blue-700); transform: translateY(-1px); box-shadow: 0 14px 30px -10px rgba(37,99,235,.55); }
    .btn-add.added { background: #16a34a; }
    .btn-add.added:hover { background: #15803d; }
    .btn-wa {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 13px 18px; border-radius: 12px;
      font-family: inherit; font-size: .9rem; font-weight: 600;
      background: #25D366; color: #fff;
      text-decoration: none;
      transition: background .2s ease, transform .2s ease;
    }
    .btn-wa:hover { background: #1ea952; transform: translateY(-1px); color: #fff; }
    .pdp-trust {
      display: grid; gap: 8px;
      padding-top: 18px; border-top: 1px dashed var(--line);
      font-size: .82rem; color: var(--muted);
    }
    .pdp-trust div { display: flex; align-items: center; gap: 8px; }
    .pdp-trust svg { color: #16a34a; flex-shrink: 0; }

    /* Body sections */
    .pdp-body { background: #fff; }
    .pdp-body-inner { display: grid; grid-template-columns: 1.4fr 1fr; gap: 60px; align-items: start; }
    .pdp-section { margin-bottom: 56px; }
    .pdp-section:last-child { margin-bottom: 0; }
    .pdp-section h2 { font-size: clamp(1.4rem, 2.4vw, 1.8rem); margin: 0 0 18px; letter-spacing: -0.025em; }
    .pdp-section p { color: var(--muted); line-height: 1.65; }

    .includes-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 10px; }
    .includes-list li {
      display: flex; gap: 12px; align-items: flex-start;
      padding: 12px 14px;
      background: var(--bg-soft);
      border: 1px solid var(--line);
      border-radius: 12px;
      transition: border-color .2s ease, transform .2s ease;
    }
    .includes-list li:hover { border-color: var(--blue-300); transform: translateX(2px); }
    .includes-list .check {
      width: 22px; height: 22px; border-radius: 50%;
      background: var(--blue-50); color: var(--blue-700);
      display: grid; place-items: center; flex-shrink: 0;
      margin-top: 1px;
    }
    .includes-list span { font-size: .92rem; color: var(--ink); font-weight: 500; }

    /* Sidebar */
    .pdp-side { display: grid; gap: 22px; }
    .pdp-side-card { padding: 22px; background: var(--bg-soft); border: 1px solid var(--line); border-radius: 16px; }
    .pdp-side-card h3 { font-size: 1rem; font-weight: 700; color: var(--ink); margin: 0 0 12px; letter-spacing: -0.01em; }
    .pdp-side-card p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }

    /* FAQ */
    .pdp-faq { background: var(--bg-soft); border-top: 1px solid var(--line); }
    .pdp-faq-inner { max-width: 880px; margin: 0 auto; }
    .pdp-faq h2 { text-align: center; margin-bottom: 32px; }
    .faq { background: #fff; border: 1px solid var(--line); border-radius: 14px; margin-bottom: 10px; overflow: hidden; }
    .faq summary {
      cursor: pointer;
      padding: 16px 20px;
      font-weight: 600; font-size: .96rem; color: var(--ink);
      list-style: none; position: relative;
      transition: background .2s ease;
    }
    .faq summary::-webkit-details-marker { display: none; }
    .faq summary::after {
      content: "+"; position: absolute; right: 20px; top: 50%; transform: translateY(-50%);
      font-size: 1.4rem; font-weight: 400; color: var(--blue-600);
      transition: transform .2s ease;
    }
    .faq[open] summary::after { content: "−"; }
    .faq summary:hover { background: var(--bg-soft); }
    .faq p { padding: 0 20px 18px; margin: 0; color: var(--muted); font-size: .92rem; line-height: 1.65; }

    /* Related */
    .related { background: #fff; border-top: 1px solid var(--line); }
    .related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .related-card {
      display: flex; flex-direction: column;
      padding: 22px;
      background: var(--bg-soft); border: 1px solid var(--line); border-radius: 16px;
      text-decoration: none; color: inherit;
      transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    .related-card:hover { border-color: var(--blue-300); transform: translateY(-3px); box-shadow: var(--shadow); color: inherit; }
    .related-card h4 { font-size: 1rem; font-weight: 700; color: var(--ink); margin: 0 0 6px; letter-spacing: -0.01em; }
    .related-card .blurb { font-size: .85rem; color: var(--soft); margin: 0 0 14px; line-height: 1.5; flex: 1; }
    .related-card .price { font-size: 1.15rem; font-weight: 800; color: var(--ink); }
    .related-card .cycle { font-size: .8rem; color: var(--soft); margin-left: 4px; font-weight: 500; }

    /* Bottom CTA */
    .pdp-bottom { background: var(--ink); color: #fff; padding: 80px 0; position: relative; overflow: hidden; }
    .pdp-bottom::before { content: ""; position: absolute; top: -200px; left: 50%; transform: translateX(-50%); width: 1100px; height: 600px; background: radial-gradient(ellipse at center, rgba(59,130,246,.28) 0%, transparent 55%); pointer-events: none; }
    .pdp-bottom-inner { position: relative; z-index: 1; max-width: 720px; margin: 0 auto; text-align: center; }
    .pdp-bottom h2 { color: #fff; margin: 0 0 16px; }
    .pdp-bottom h2 .serif-italic { color: var(--blue-300); }
    .pdp-bottom p { color: rgba(255,255,255,.7); font-size: 1.08rem; margin: 0 0 26px; }
    .pdp-bottom .btn-primary { background: #fff; color: var(--ink); }
    .pdp-bottom .btn-primary:hover { background: var(--blue-100); color: var(--ink); }
    .pdp-bottom .btn-ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.2); }
    .pdp-bottom .btn-ghost:hover { background: rgba(255,255,255,.08); border-color: #fff; color: #fff; }

    @media (max-width: 980px) {
      .pdp-hero-inner, .pdp-body-inner { grid-template-columns: 1fr; gap: 32px; }
      .pdp-buy { position: static; }
      .related-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
      section { padding: 60px 0; }
      .pdp-hero { padding: 36px 0 56px; }
      .pdp-meta-grid { grid-template-columns: 1fr; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <section class="pdp-hero">
    <div class="container">
      <div class="breadcrumbs">
        <a href="{{ url('/') }}">Home</a> <span>›</span>
        <a href="{{ url('/shop') }}">Shop</a> <span>›</span>
        <a href="{{ url('/services/'.$cat['id']) }}">{{ $cat['title'] }}</a> <span>›</span>
        <strong style="color:var(--ink);">{{ Str::limit($item['name'], 32) }}</strong>
      </div>

      <div class="pdp-hero-inner">
        <div>
          @if (!empty($item['tag']))
            <span class="pdp-tag {{ $item['tag'] }}">{{ $item['tag'] }}</span>
          @endif
          <a class="pdp-cat-link" href="{{ url('/services/'.$cat['id']) }}">{{ $cat['eyebrow'] }} · {{ $cat['title'] }} →</a>
          <h1>{{ $item['name'] }}</h1>
          <p class="pdp-blurb">{{ $item['blurb'] }}</p>
          <p class="pdp-detail">{{ $item['detail'] }}</p>

          <div class="pdp-meta-grid">
            <div class="pdp-meta"><strong>Timeline</strong><span>{{ $item['timeline'] }}</span></div>
            <div class="pdp-meta"><strong>Ideal for</strong><span>{{ $item['idealFor'] }}</span></div>
          </div>

          <figure class="pdp-photo" aria-hidden="true">
            <span class="pdp-photo-tag"><span class="dot"></span>{{ $cat['title'] }}</span>
            <img src="{{ $heroImage }}" alt="" loading="lazy" decoding="async" />
          </figure>
        </div>

        @auth
          <aside class="pdp-buy">
            <span class="price-from">Starting at</span>
            <div class="price-row">
              <span class="price-amt">${{ number_format($item['price']) }}</span>
              <span class="price-cycle">{{ $cycleLabel[$item['cycle']] ?? '' }}</span>
            </div>
            <p class="price-note">{{ $cycleNote[$item['cycle']] ?? '' }}</p>

            <div class="pdp-actions">
              <a class="btn-add" href="{{ route('checkout.show', $item['slug']) }}" style="background:#4AAE18; text-decoration:none;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Buy now · checkout
              </a>
              <a class="btn-wa" id="waBtn" href="{{ route('contact') }}#contact" style="background:linear-gradient(135deg,#3b82f6 0%,#1e3a8a 100%);">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                Talk to us first
              </a>
            </div>

            <div class="pdp-trust">
              <div>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span>No payment taken on this site</span>
              </div>
              <div>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span>Scope confirmed on a 15-min call</span>
              </div>
              <div>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span>14-day satisfaction window</span>
              </div>
            </div>
          </aside>
        @else
          <aside class="pdp-buy pdp-locked">
            <div class="pdp-locked-icon">
              <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h3>Pricing for verified members</h3>
            <p>We share full package pricing with signed-in customers so we can stay private about the rate card. Create a free account in 30 seconds to see this package's price.</p>
            <div aria-hidden="true" class="price-blur">${{ number_format($item['price']) }}</div>

            <div class="pdp-actions">
              <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn-wa" style="background:linear-gradient(135deg,#3b82f6 0%,#1e3a8a 100%);">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11V7a5 5 0 0 1 9.9-1"/><rect x="3" y="11" width="18" height="11" rx="2"/></svg>
                Create account &amp; view pricing
              </a>
              <a href="{{ route('auth.show') }}" class="btn-add" style="background:transparent; color:#0b1020; border:1px solid #cbd5e1;">
                Already have an account? Sign in
              </a>
            </div>

            <div class="pdp-trust">
              <div>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span>Free account, no payment info needed</span>
              </div>
              <div>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span>Save your cart across devices</span>
              </div>
              <div>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span>14-day satisfaction window on every package</span>
              </div>
            </div>
          </aside>
        @endauth
      </div>
    </div>
  </section>

  <section class="pdp-body">
    <div class="container">
      <div class="pdp-body-inner">
        <div>
          <div class="pdp-section">
            <h2>What's included</h2>
            <ul class="includes-list">
              @foreach ($item['includes'] as $inc)
                <li>
                  <span class="check"><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                  <span>{{ $inc }}</span>
                </li>
              @endforeach
            </ul>
          </div>

          <div class="pdp-section">
            <h2>How we work</h2>
            <ul class="includes-list">
              @foreach ($cat['process'] as $i => $step)
                <li>
                  <span class="check" style="background:var(--ink); color:#fff;">{{ $i + 1 }}</span>
                  <span><strong style="color:var(--ink);">{{ $step[0] }}.</strong> {{ $step[1] }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        </div>

        <aside class="pdp-side">
          <div class="pdp-side-card">
            <h3>Why pick this package</h3>
            <p>{{ $item['blurb'] }} Most clients see results within their first 2–4 weeks of going live, with full ROI typically inside the first quarter.</p>
          </div>
          <div class="pdp-side-card">
            <h3>Need something custom?</h3>
            <p>Bigger scope? Tighter timeline? Multi-region rollout? Tell us on the discovery call — we routinely scope custom engagements off these starting points.</p>
            <a href="{{ route('contact') }}" style="display:inline-block; margin-top:12px; font-size:.88rem; font-weight:600; color:var(--blue-700);">Talk to a strategist →</a>
          </div>
          <div class="pdp-side-card">
            <h3>Bundle it</h3>
            <p>Pair with a related service in {{ $cat['title'] }} for compounding results — bundles are typically 5–15% cheaper than ordering individually.</p>
            <a href="{{ url('/services/'.$cat['id']) }}" style="display:inline-block; margin-top:12px; font-size:.88rem; font-weight:600; color:var(--blue-700);">See bundle ideas →</a>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <section class="pdp-faq">
    <div class="container pdp-faq-inner">
      <h2>Frequently asked</h2>
      @foreach ($faqs as $f)
        <details class="faq">
          <summary>{{ $f[0] }}</summary>
          <p>{{ $f[1] }}</p>
        </details>
      @endforeach
    </div>
  </section>

  @if ($related->isNotEmpty())
    <section class="related">
      <div class="container">
        <h2 style="font-size:clamp(1.4rem, 2.4vw, 1.8rem); margin:0 0 22px; letter-spacing:-0.025em;">More from {{ $cat['title'] }}</h2>
        <div class="related-grid">
          @foreach ($related as $r)
            <a class="related-card" href="{{ url('/shop/'.$r['slug']) }}">
              <h4>{{ $r['name'] }}</h4>
              <p class="blurb">{{ $r['blurb'] }}</p>
              @auth
                <div>
                  <span class="price">${{ number_format($r['price']) }}</span>
                  <span class="cycle">{{ $cycleLabel[$r['cycle']] ?? '' }}</span>
                </div>
              @else
                <div style="display:inline-flex; align-items:center; gap:6px; padding:7px 12px; background:#eff6ff; border-radius:999px; font-size:.78rem; font-weight:600; color:#1d4ed8; align-self:flex-start;">
                  <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  Sign in to view pricing
                </div>
              @endauth
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <section class="pdp-bottom">
    <div class="container pdp-bottom-inner">
      <h2>Ready to <span class="serif-italic">start?</span></h2>
      <p>Add this to your cart, browse for more, or submit your order request directly. We'll confirm scope and pricing before any commitment.</p>
      <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
        <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Browse all services →</a>
        <a href="{{ route('contact') }}" class="btn btn-ghost btn-lg">Book a strategy call</a>
      </div>
    </div>
  </section>

  @include('partials.footer')

@endsection

@push('scripts')
  <script>
    (function () {
      const STORAGE_KEY = 'digi_cart_v2';
      const addBtn   = document.getElementById('addBtn');
      const addLabel = document.getElementById('addLabel');
      if (!addBtn) return;

      const loadCart = () => { try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; } catch (e) { return []; } };
      const saveCart = (cart) => localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));

      const refresh = () => {
        const cart = loadCart();
        const inCart = cart.some(i => i.sku === addBtn.dataset.sku);
        addBtn.classList.toggle('added', inCart);
        addLabel.textContent = inCart ? 'In cart ✓ — view shop' : 'Add to cart';
      };
      refresh();

      addBtn.addEventListener('click', () => {
        const cart = loadCart();
        const sku = addBtn.dataset.sku;
        const idx = cart.findIndex(i => i.sku === sku);
        if (idx >= 0) {
          // already in cart — go to shop
          window.location.href = "{{ url('/shop') }}";
          return;
        }
        cart.push({
          sku,
          name:  addBtn.dataset.name,
          price: Number(addBtn.dataset.price),
          cycle: addBtn.dataset.cycle,
          cat:   addBtn.dataset.cat,
        });
        saveCart(cart);
        refresh();
      });
    })();
  </script>
@endpush
