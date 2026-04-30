@extends('layouts.app')

@section('title', 'Shop — Digirisers')
@section('description', 'Shop the Digirisers platform — fixed-price packages for websites, AI agents, SEO, ads, automation, hosting, and brand. Add to cart, send your order, and get started.')
@section('robots', 'index,follow')

@php
  $cats = collect(config('catalog.categories', []))->sortBy('order')->values();
  $totalItems = $cats->sum(fn ($c) => count($c['items']));
  $cycleLabel = ['project' => 'one-time', 'mo' => '/month', 'week' => '/week', 'per Zap' => 'per Zap', 'per script' => 'per script', 'per asset' => 'per asset'];
@endphp

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    section { padding: 90px 0; position: relative; }
    .container { max-width: 1240px; }

    .shop-hero { position: relative; overflow: hidden; background: var(--grad-soft); padding: 90px 0 60px; border-bottom: 1px solid var(--line); }
    .shop-hero::before { content: ""; position: absolute; inset: 0; background-image: linear-gradient(rgba(148,163,184,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(148,163,184,.15) 1px, transparent 1px); background-size: 56px 56px; mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%); -webkit-mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%); pointer-events: none; }
    .shop-hero::after { content: ""; position: absolute; top: -160px; left: 50%; transform: translateX(-50%); width: 1100px; height: 600px; background: radial-gradient(ellipse at center, rgba(59,130,246,.22) 0%, transparent 55%); pointer-events: none; }
    .shop-hero-inner { position: relative; z-index: 1; max-width: 820px; text-align: center; margin: 0 auto; }
    .shop-hero h1 { margin-bottom: 18px; }
    .shop-hero p { font-size: 1.15rem; color: var(--muted); max-width: 660px; margin: 0 auto 32px; }

    /* Filter bar */
    .filter-bar { position: sticky; top: 76px; z-index: 50; background: rgba(255,255,255,.94); backdrop-filter: saturate(180%) blur(12px); -webkit-backdrop-filter: saturate(180%) blur(12px); border-bottom: 1px solid var(--line); padding: 16px 0; }
    .filter-inner { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; justify-content: space-between; }
    .filter-pills { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .filter-pill { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; font-size: .85rem; font-weight: 600; background: #fff; border: 1px solid var(--line); border-radius: 999px; color: var(--muted); cursor: pointer; transition: all .2s ease; font-family: inherit; }
    .filter-pill:hover { color: var(--ink); border-color: var(--ink); }
    .filter-pill.active { background: var(--ink); color: #fff; border-color: var(--ink); }
    .filter-pill .count { font-size: .72rem; padding: 1px 7px; border-radius: 999px; background: var(--blue-50); color: var(--blue-700); font-weight: 700; }
    .filter-pill.active .count { background: rgba(255,255,255,.18); color: #fff; }
    .filter-search { display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1px solid var(--line); border-radius: 999px; padding: 7px 14px; min-width: 240px; }
    .filter-search svg { color: var(--soft); flex-shrink: 0; }
    .filter-search input { border: 0; outline: 0; background: transparent; font-family: inherit; font-size: .88rem; color: var(--ink); flex: 1; min-width: 0; }
    .filter-search input::placeholder { color: var(--soft-2); }

    /* Catalog */
    .catalog { background: #fff; padding: 56px 0 100px; }
    .cat-section { margin-bottom: 56px; scroll-margin-top: 160px; }
    .cat-section:last-child { margin-bottom: 0; }
    .cat-head { display: flex; align-items: end; justify-content: space-between; gap: 20px; flex-wrap: wrap; margin-bottom: 28px; padding-bottom: 18px; border-bottom: 1px solid var(--line); }
    .cat-head h2 { margin: 0; font-size: clamp(1.5rem, 2.6vw, 2rem); letter-spacing: -0.025em; }
    .cat-head h2 .cat-num { display: inline-block; font-family: var(--font-mono); font-size: .8rem; color: var(--blue-700); margin-right: 10px; vertical-align: middle; background: var(--blue-50); padding: 4px 10px; border-radius: 8px; font-weight: 600; letter-spacing: .04em; }
    .cat-head p { margin: 4px 0 0; color: var(--soft); font-size: .95rem; max-width: 520px; }

    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 18px; }
    .product { position: relative; background: #fff; border: 1px solid var(--line); border-radius: 18px; padding: 22px 22px 20px; display: flex; flex-direction: column; transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; text-decoration: none; color: inherit; }
    .product.hidden { display: none; }
    .product:hover { transform: translateY(-3px); border-color: var(--blue-300); box-shadow: var(--shadow-lg); color: inherit; }
    .product.featured { background: linear-gradient(180deg, #f5f8ff 0%, #fff 60%); border-color: var(--blue-300); box-shadow: var(--shadow); }
    .product-tag { position: absolute; top: 14px; right: 14px; font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; padding: 4px 9px; border-radius: 999px; }
    .product-tag.popular { background: var(--ink); color: #fff; }
    .product-tag.new { background: var(--blue-600); color: #fff; }

    .product h3 { font-size: 1.02rem; font-weight: 700; color: var(--ink); margin: 0 0 6px; letter-spacing: -0.015em; padding-right: 60px; }
    .product .blurb { font-size: .85rem; color: var(--soft); margin: 0 0 16px; line-height: 1.5; flex: 1; }

    .price-row { display: flex; align-items: baseline; gap: 4px; margin-bottom: 4px; }
    .price-from { font-size: .72rem; font-weight: 600; color: var(--soft); text-transform: uppercase; letter-spacing: .08em; margin-right: 6px; }
    .price-amt { font-size: 1.7rem; font-weight: 800; color: var(--ink); letter-spacing: -0.025em; line-height: 1; }
    .price-cycle { font-size: .82rem; color: var(--soft); font-weight: 500; }
    .price-note { font-size: .72rem; color: var(--soft-2); margin-bottom: 14px; font-family: var(--font-mono); letter-spacing: .02em; }

    .product-actions { display: flex; gap: 8px; }
    .product-cta {
      flex: 1;
      display: inline-flex; align-items: center; justify-content: center; gap: 6px;
      padding: 11px 14px; border-radius: 12px;
      font-size: .85rem; font-weight: 600;
      background: var(--ink); color: #fff;
      border: 0; cursor: pointer; font-family: inherit;
      transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    .product-cta:hover { background: var(--blue-700); transform: translateY(-1px); box-shadow: 0 10px 24px -10px rgba(37,99,235,.6); }
    .product-cta.added { background: #16a34a; }
    .product-cta.added:hover { background: #15803d; }
    .product-link {
      display: inline-flex; align-items: center; justify-content: center;
      padding: 11px 14px; border-radius: 12px;
      font-size: .85rem; font-weight: 600;
      background: #fff; color: var(--ink);
      border: 1px solid var(--line);
      text-decoration: none;
      transition: all .2s ease;
    }
    .product-link:hover { border-color: var(--ink); color: var(--ink); }
    .product.featured .product-cta { background: var(--grad); box-shadow: 0 8px 22px -8px rgba(37,99,235,.5); }

    /* Locked-pricing CTA shown to guests in place of the price + buttons. */
    .price-locked {
      display: flex; align-items: center; gap: 10px;
      padding: 14px;
      background: linear-gradient(135deg, #f5f8ff 0%, #eff6ff 100%);
      border: 1px dashed var(--blue-300);
      border-radius: 14px;
      color: var(--blue-700);
      font-size: .82rem; font-weight: 600;
      margin-bottom: 10px;
    }
    .price-locked svg { flex-shrink: 0; color: var(--blue-600); }
    .price-locked-body { flex: 1; }
    .price-locked-body strong { display: block; color: var(--ink); font-size: .92rem; margin-bottom: 1px; letter-spacing: -0.01em; }
    .price-locked-body span { display: block; font-weight: 500; color: var(--soft); font-size: .76rem; line-height: 1.4; }
    .product-actions-locked {
      display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
    }
    .price-unlock {
      display: inline-flex; align-items: center; justify-content: center; gap: 6px;
      padding: 11px 14px; border-radius: 12px;
      font-size: .85rem; font-weight: 600;
      background: var(--grad); color: #fff;
      text-decoration: none;
      box-shadow: 0 8px 22px -8px rgba(37,99,235,.5);
      transition: transform .2s ease, box-shadow .25s ease;
    }
    .price-unlock:hover { transform: translateY(-1px); box-shadow: 0 14px 28px -8px rgba(37,99,235,.55); color: #fff; }

    .empty-state { grid-column: 1 / -1; padding: 60px 20px; text-align: center; color: var(--soft); font-size: .95rem; border: 2px dashed var(--line); border-radius: 18px; }

    /* Floating cart */
    .cart-fab { position: fixed; bottom: 28px; right: 28px; z-index: 80; display: inline-flex; align-items: center; gap: 10px; padding: 14px 22px; background: var(--ink); color: #fff; border-radius: 999px; box-shadow: 0 20px 50px -10px rgba(11,16,32,.4); font-weight: 600; font-size: .95rem; cursor: pointer; border: 0; font-family: inherit; transform: translateY(120%); transition: transform .3s ease; }
    .cart-fab.show { transform: translateY(0); }
    .cart-fab:hover { background: var(--blue-700); }
    .cart-fab .cart-count { background: var(--blue-500); color: #fff; font-size: .72rem; font-weight: 700; width: 22px; height: 22px; border-radius: 50%; display: grid; place-items: center; }

    .cart-drawer { position: fixed; top: 0; right: 0; bottom: 0; width: min(440px, 100vw); background: #fff; box-shadow: -20px 0 60px -20px rgba(11,16,32,.3); z-index: 200; display: flex; flex-direction: column; transform: translateX(100%); transition: transform .35s ease; }
    .cart-drawer.open { transform: translateX(0); }
    .cart-overlay { position: fixed; inset: 0; background: rgba(11,16,32,.45); z-index: 190; opacity: 0; pointer-events: none; transition: opacity .3s ease; }
    .cart-overlay.show { opacity: 1; pointer-events: auto; }
    .cart-head { padding: 22px 24px; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; }
    .cart-head h3 { margin: 0; font-size: 1.1rem; color: var(--ink); }
    .cart-close { background: transparent; border: 0; cursor: pointer; width: 36px; height: 36px; border-radius: 10px; display: grid; place-items: center; color: var(--muted); transition: background .2s ease, color .2s ease; }
    .cart-close:hover { background: var(--bg-soft); color: var(--ink); }
    .cart-body { flex: 1; overflow-y: auto; padding: 18px 24px; }
    .cart-empty { text-align: center; padding: 60px 20px; color: var(--soft); }
    .cart-empty svg { color: var(--soft-2); margin-bottom: 16px; }
    .cart-empty p { margin: 0 0 6px; font-size: .95rem; color: var(--ink); font-weight: 600; }
    .cart-empty small { font-size: .85rem; color: var(--soft); }
    .cart-item { display: grid; grid-template-columns: 1fr auto; gap: 8px 14px; padding: 14px 0; border-bottom: 1px solid var(--line-2); align-items: start; }
    .cart-item:last-child { border-bottom: 0; }
    .cart-item h4 { margin: 0 0 4px; font-size: .92rem; font-weight: 600; color: var(--ink); }
    .cart-item small { display: block; font-size: .78rem; color: var(--soft); }
    .cart-item .ci-price { font-weight: 700; color: var(--ink); font-size: .92rem; white-space: nowrap; }
    .cart-item .ci-cycle { font-size: .72rem; color: var(--soft); }
    .ci-remove { background: transparent; border: 0; cursor: pointer; color: var(--soft); font-size: .78rem; padding: 4px 0; font-family: inherit; grid-column: 1 / -1; text-align: left; transition: color .2s ease; }
    .ci-remove:hover { color: #ef4444; }
    .cart-foot { padding: 18px 24px 22px; border-top: 1px solid var(--line); background: var(--bg-soft); }
    .cart-totals { display: grid; gap: 6px; margin-bottom: 14px; font-size: .88rem; }
    .cart-totals .row { display: flex; justify-content: space-between; color: var(--muted); }
    .cart-totals .row strong { color: var(--ink); font-weight: 700; }
    .cart-totals .grand { border-top: 1px dashed var(--line); padding-top: 8px; margin-top: 6px; font-size: 1rem; }
    .cart-checkout { width: 100%; padding: 14px 20px; border-radius: 12px; background: #25D366; color: #fff; font-weight: 600; font-size: .95rem; border: 0; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; justify-content: center; gap: 10px; transition: background .2s ease, transform .2s ease, box-shadow .2s ease; }
    .cart-checkout:hover { background: #1ea952; transform: translateY(-1px); box-shadow: 0 10px 24px -10px rgba(37,211,102,.6); }
    .cart-note { font-size: .75rem; color: var(--soft); text-align: center; margin: 12px 0 0; line-height: 1.5; }

    .saas-strip { background: var(--ink); color: #fff; padding: 36px 0; }
    .saas-strip-inner { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
    .saas-pill { display: flex; align-items: start; gap: 14px; }
    .saas-pill svg { color: var(--blue-300); flex-shrink: 0; margin-top: 2px; }
    .saas-pill strong { display: block; color: #fff; font-size: .92rem; margin-bottom: 2px; }
    .saas-pill small { color: rgba(255,255,255,.65); font-size: .82rem; line-height: 1.5; }

    @media (max-width: 980px) {
      .saas-strip-inner { grid-template-columns: repeat(2, 1fr); }
      .filter-bar { top: 70px; }
    }
    @media (max-width: 640px) {
      section { padding: 60px 0; }
      .shop-hero { padding: 60px 0 40px; }
      .filter-search { width: 100%; }
      .saas-strip-inner { grid-template-columns: 1fr; }
      .cart-fab { bottom: 16px; right: 16px; padding: 12px 18px; font-size: .9rem; }
      .product-actions { flex-direction: column; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <section class="shop-hero">
    <div class="container shop-hero-inner">
      <span class="eyebrow"><span class="dot"></span><span>Shop the Platform</span></span>
      <h1>Pick services off the <span class="gradient-text">shelf.</span></h1>
      <p>Transparent pricing for every Digirisers service. Read the details, add what you need, send the order — we'll confirm scope and invoice separately. No payment charged on this site.</p>
      <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
        @auth
          <button type="button" class="btn btn-primary btn-lg" id="openCartBtn">View cart</button>
          <a href="{{ url('/services') }}" class="btn btn-ghost btn-lg">Browse modules</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary btn-lg">Create account to see pricing</a>
          <a href="{{ url('/services') }}" class="btn btn-ghost btn-lg">Browse modules</a>
        @endauth
      </div>
    </div>
  </section>

  <div class="filter-bar">
    <div class="container filter-inner">
      <div class="filter-pills" id="filterPills">
        <button type="button" class="filter-pill active" data-filter="all">All <span class="count">{{ $totalItems }}</span></button>
        @foreach ($cats as $c)
          <button type="button" class="filter-pill" data-filter="{{ $c['id'] }}">{{ Str::limit(explode(' ', $c['title'])[0], 14, '') }} <span class="count">{{ count($c['items']) }}</span></button>
        @endforeach
      </div>
      <label class="filter-search" aria-label="Search services">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="search" id="shopSearch" placeholder="Search {{ $totalItems }} services…" autocomplete="off">
      </label>
    </div>
  </div>

  <section class="catalog">
    <div class="container">
      @foreach ($cats as $i => $c)
        <div class="cat-section" id="cat-{{ $c['id'] }}" data-cat="{{ $c['id'] }}">
          <div class="cat-head">
            <div>
              <h2><span class="cat-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad(count($cats), 2, '0', STR_PAD_LEFT) }}</span>{{ $c['title'] }}</h2>
              <p>{{ $c['blurb'] }}</p>
            </div>
            <a href="{{ url('/services/'.$c['id']) }}" class="btn btn-ghost" style="font-size:.88rem; padding:9px 18px;">Read more →</a>
          </div>

          <div class="product-grid">
            @foreach ($c['items'] as $item)
              @php
                $tag = $item['tag'] ?? null;
                $featured = $tag === 'popular';
              @endphp
              <article
                class="product @if($featured) featured @endif"
                data-cat="{{ $c['id'] }}"
                data-name="{{ $item['name'] }}"
                data-sku="{{ $item['slug'] }}"
                data-price="{{ $item['price'] }}"
                data-cycle="{{ $item['cycle'] }}"
              >
                @if($tag)
                  <span class="product-tag {{ $tag }}">{{ $tag }}</span>
                @endif
                <h3>{{ $item['name'] }}</h3>
                <p class="blurb">{{ $item['blurb'] }}</p>
                @auth
                  <div class="price-row">
                    <span class="price-from">From</span>
                    <span class="price-amt">${{ number_format($item['price']) }}</span>
                    <span class="price-cycle">{{ $cycleLabel[$item['cycle']] ?? '' }}</span>
                  </div>
                  <div class="price-note">{{ $item['timeline'] }}</div>
                  <div class="product-actions">
                    <a class="product-cta" href="{{ route('checkout.show', $item['slug']) }}" style="background:#4AAE18; text-decoration:none;">
                      <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      Buy now
                    </a>
                    <a class="product-link" href="{{ url('/shop/'.$item['slug']) }}">Details</a>
                  </div>
                @else
                  <div class="price-locked">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <div class="price-locked-body">
                      <strong>Sign in to view pricing</strong>
                      <span>{{ $item['timeline'] }}</span>
                    </div>
                  </div>
                  <div class="product-actions-locked">
                    <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="price-unlock">
                      <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11V7a5 5 0 0 1 9.9-1"/><rect x="3" y="11" width="18" height="11" rx="2"/></svg>
                      View pricing
                    </a>
                    <a class="product-link" href="{{ url('/shop/'.$item['slug']) }}">Details →</a>
                  </div>
                @endauth
              </article>
            @endforeach
          </div>
        </div>
      @endforeach

      <div class="empty-state" id="emptyState" style="display:none;">
        <strong>No services match your search.</strong><br/>
        <small>Try a different keyword or clear the filters.</small>
      </div>
    </div>
  </section>

  <section class="saas-strip">
    <div class="container saas-strip-inner">
      <div class="saas-pill">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        <div><strong>No payment required</strong><small>Send your order, we'll quote and invoice separately.</small></div>
      </div>
      <div class="saas-pill">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <div><strong>Fast turnaround</strong><small>Most projects kick off within 48 hours of confirmation.</small></div>
      </div>
      <div class="saas-pill">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <div><strong>Secure & compliant</strong><small>OWASP best practices and data privacy by default.</small></div>
      </div>
      <div class="saas-pill">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        <div><strong>Real humans + AI</strong><small>One team for strategy, build, and growth — never offshore-only.</small></div>
      </div>
    </div>
  </section>

  @auth
  <button type="button" class="cart-fab" id="cartFab" aria-label="Open cart">
    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
    <span>Cart</span>
    <span class="cart-count" id="cartCount">0</span>
  </button>
  @endauth

  @auth
  <div class="cart-overlay" id="cartOverlay"></div>
  <aside class="cart-drawer" id="cartDrawer" aria-label="Shopping cart" aria-hidden="true">
    <div class="cart-head">
      <h3>Your order</h3>
      <button type="button" class="cart-close" id="cartClose" aria-label="Close cart">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="cart-body" id="cartBody">
      <div class="cart-empty" id="cartEmpty">
        <svg viewBox="0 0 24 24" width="42" height="42" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
        <p>Your cart is empty</p>
        <small>Add services to start building your order.</small>
      </div>
    </div>
    <div class="cart-foot" id="cartFoot" style="display:none;">
      <div class="cart-totals">
        <div class="row"><span>One-time projects</span><strong id="totalProject">$0</strong></div>
        <div class="row"><span>Monthly retainers</span><strong id="totalMonthly">$0/mo</strong></div>
        <div class="row"><span>Other (weekly / per-unit)</span><strong id="totalOther">$0</strong></div>
        <div class="row grand"><span>Subtotal due upfront</span><strong id="totalUpfront">$0</strong></div>
      </div>
      <button type="button" class="cart-checkout" id="cartCheckout">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        Submit order request
      </button>
      <p class="cart-note">No payment is taken on this site. We'll review your scope, confirm pricing, and invoice you separately.</p>
    </div>
  </aside>
  @endauth

  @include('partials.footer')

@endsection

@push('scripts')
  <script>
    (function () {
      const STORAGE_KEY = 'digi_cart_v2';
      const products    = document.querySelectorAll('.product');
      const filterPills = document.querySelectorAll('.filter-pill');
      const searchInput = document.getElementById('shopSearch');
      const emptyState  = document.getElementById('emptyState');
      const catSections = document.querySelectorAll('.cat-section');
      const cartFab     = document.getElementById('cartFab');
      const cartCountEl = document.getElementById('cartCount');
      const cartDrawer  = document.getElementById('cartDrawer');
      const cartOverlay = document.getElementById('cartOverlay');
      const cartEnabled = !!cartFab; // Cart UI is rendered only for signed-in users.
      const cartClose   = document.getElementById('cartClose');
      const cartBody    = document.getElementById('cartBody');
      const cartEmpty   = document.getElementById('cartEmpty');
      const cartFoot    = document.getElementById('cartFoot');
      const totalProjectEl = document.getElementById('totalProject');
      const totalMonthlyEl = document.getElementById('totalMonthly');
      const totalOtherEl   = document.getElementById('totalOther');
      const totalUpfrontEl = document.getElementById('totalUpfront');
      const cartCheckout   = document.getElementById('cartCheckout');
      const openCartBtn    = document.getElementById('openCartBtn');

      const loadCart = () => { try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; } catch (e) { return []; } };
      const saveCart = (cart) => localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
      let cart = loadCart();

      const fmt = (n) => '$' + Number(n).toLocaleString('en-US');
      const cycleLabel = { project: 'one-time', mo: '/month', week: '/week', 'per Zap': 'per Zap', 'per script': 'per script', 'per asset': 'per asset' };

      const renderCart = () => {
        const skus = new Set(cart.map(i => i.sku));
        document.querySelectorAll('.product').forEach(p => {
          const btn = p.querySelector('.js-add');
          const lbl = btn?.querySelector('.js-add-label');
          if (skus.has(p.dataset.sku)) {
            btn?.classList.add('added');
            if (lbl) lbl.textContent = 'Added ✓';
          } else {
            btn?.classList.remove('added');
            if (lbl) lbl.textContent = 'Add to cart';
          }
        });

        if (!cartEnabled) return; // Guests don't render the cart UI.

        cartCountEl.textContent = cart.length;
        if (cart.length > 0) cartFab.classList.add('show');
        else cartFab.classList.remove('show');

        if (cart.length === 0) {
          cartEmpty.style.display = '';
          cartFoot.style.display = 'none';
          cartBody.querySelectorAll('.cart-item').forEach(n => n.remove());
          return;
        }
        cartEmpty.style.display = 'none';
        cartFoot.style.display = '';
        cartBody.querySelectorAll('.cart-item').forEach(n => n.remove());

        cart.forEach((item, idx) => {
          const row = document.createElement('div');
          row.className = 'cart-item';
          row.innerHTML = `
            <div><h4>${item.name}</h4><small>${item.cat}</small></div>
            <div style="text-align:right;">
              <div class="ci-price">${fmt(item.price)}</div>
              <div class="ci-cycle">${cycleLabel[item.cycle] || ''}</div>
            </div>
            <button type="button" class="ci-remove" data-idx="${idx}">Remove</button>
          `;
          cartBody.appendChild(row);
        });

        const totalProject = cart.filter(i => i.cycle === 'project').reduce((s, i) => s + i.price, 0);
        const totalMonthly = cart.filter(i => i.cycle === 'mo').reduce((s, i) => s + i.price, 0);
        const totalOther   = cart.filter(i => i.cycle !== 'project' && i.cycle !== 'mo').reduce((s, i) => s + i.price, 0);
        totalProjectEl.textContent = fmt(totalProject);
        totalMonthlyEl.textContent = fmt(totalMonthly) + '/mo';
        totalOtherEl.textContent   = fmt(totalOther);
        totalUpfrontEl.textContent = fmt(totalProject + totalOther);

        cartBody.querySelectorAll('.ci-remove').forEach(btn => {
          btn.addEventListener('click', () => {
            cart.splice(Number(btn.dataset.idx), 1);
            saveCart(cart); renderCart();
          });
        });
      };

      products.forEach(prod => {
        prod.querySelector('.js-add')?.addEventListener('click', (e) => {
          e.preventDefault();
          const sku = prod.dataset.sku;
          const exists = cart.findIndex(i => i.sku === sku);
          if (exists >= 0) {
            cart.splice(exists, 1);
          } else {
            const catSection = prod.closest('.cat-section');
            const catName = catSection?.querySelector('h2')?.textContent.replace(/^\d+\s*\/\s*\d+/, '').trim() || '';
            cart.push({ sku, name: prod.dataset.name, price: Number(prod.dataset.price), cycle: prod.dataset.cycle, cat: catName });
          }
          saveCart(cart); renderCart();
        });
      });

      const applyFilters = () => {
        const activeFilter = document.querySelector('.filter-pill.active')?.dataset.filter || 'all';
        const q = (searchInput.value || '').trim().toLowerCase();
        let visibleAny = false;
        catSections.forEach(sec => {
          let secVisible = false;
          sec.querySelectorAll('.product').forEach(p => {
            const matchesCat = activeFilter === 'all' || p.dataset.cat === activeFilter;
            const text = (p.dataset.name + ' ' + p.querySelector('.blurb').textContent).toLowerCase();
            const matchesSearch = !q || text.includes(q);
            const show = matchesCat && matchesSearch;
            p.classList.toggle('hidden', !show);
            if (show) { secVisible = true; visibleAny = true; }
          });
          sec.style.display = secVisible ? '' : 'none';
        });
        emptyState.style.display = visibleAny ? 'none' : '';
      };
      filterPills.forEach(pill => pill.addEventListener('click', () => {
        filterPills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        applyFilters();
      }));
      searchInput.addEventListener('input', applyFilters);

      if (cartEnabled) {
        const openCart = () => { cartDrawer.classList.add('open'); cartOverlay.classList.add('show'); cartDrawer.setAttribute('aria-hidden', 'false'); };
        const closeCart = () => { cartDrawer.classList.remove('open'); cartOverlay.classList.remove('show'); cartDrawer.setAttribute('aria-hidden', 'true'); };
        cartFab.addEventListener('click', openCart);
        openCartBtn?.addEventListener('click', openCart);
        cartClose.addEventListener('click', closeCart);
        cartOverlay.addEventListener('click', closeCart);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeCart(); });

        cartCheckout.addEventListener('click', () => {
          if (cart.length === 0) return;
          // Cart contents persist in localStorage (digi_cart_v2). The contact
          // page reads them via the ?cart=1 flag and prefills the message.
          window.location.href = "{{ route('contact') }}?cart=1#contact";
        });
      }

      renderCart();
    })();
  </script>
@endpush
