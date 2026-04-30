@extends('layouts.app')

@section('title', 'E-commerce Store — Digirisers')
@section('description', 'A 25-product e-commerce store that converts at 3%+ from day one — Shopify or WooCommerce, hand-styled, payment-ready, and tuned for mobile checkout.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ec { background: #fff; }
    .ec-split { display: grid; grid-template-columns: 1fr 1fr; min-height: 88vh; }
    .ec-split-l { background: #0c0a09; color: #fff; padding: 80px 56px; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; }
    .ec-split-l::before { content: ""; position: absolute; bottom: -40%; left: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(245,158,11,.18), transparent 70%); }
    .ec-split-l .num { font-family: var(--font-mono); font-size: .76rem; color: #f59e0b; letter-spacing: .14em; margin-bottom: 28px; }
    .ec-split-l h1 { color: #fff; font-size: clamp(2.2rem, 4vw, 3.4rem); margin: 0 0 18px; line-height: 1.05; position: relative; }
    .ec-split-l h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #fbbf24; }
    .ec-split-l p { color: rgba(255,255,255,.72); font-size: 1.05rem; line-height: 1.65; max-width: 480px; position: relative; }
    .ec-split-r { position: relative; overflow: hidden; }
    .ec-split-r img { width: 100%; height: 100%; object-fit: cover; }
    .ec-checks { padding: 80px 0; background: #fafaf9; }
    .ec-checks h2 { text-align: center; max-width: 640px; margin: 0 auto 44px; }
    .ec-checks ul { list-style: none; padding: 0; margin: 0; max-width: 760px; margin: 0 auto; display: grid; gap: 12px; }
    .ec-checks li { display: grid; grid-template-columns: 28px 1fr; gap: 14px; padding: 18px 22px; background: #fff; border: 1px solid var(--line); border-radius: 12px; transition: border-color .2s ease, transform .2s ease; }
    .ec-checks li:hover { border-color: #f59e0b; transform: translateX(4px); }
    .ec-checks li svg { color: #f59e0b; margin-top: 3px; }
    .ec-checks li strong { color: var(--ink); display: block; margin-bottom: 4px; font-size: .96rem; }
    .ec-checks li span { color: var(--muted); font-size: .9rem; line-height: 1.55; }
    .ec-strip { padding: 80px 0; }
    .ec-strip .row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 22px; align-items: center; }
    .ec-strip .row figure { aspect-ratio: 1; border-radius: 16px; overflow: hidden; background: #f5f5f4; }
    .ec-strip .row figure img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s ease; }
    .ec-strip .row figure:hover img { transform: scale(1.06); }
    .ec-cta { padding: 90px 0; background: #fef3c7; text-align: center; }
    .ec-cta h2 { margin: 0 0 14px; }
    @media (max-width: 880px) { .ec-split { grid-template-columns: 1fr; } .ec-split-l { padding: 60px 24px; } .ec-strip .row { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <main class="ec">
    <section class="ec-split">
      <div class="ec-split-l">
        <span class="num">SKU 005 · ECOMMERCE</span>
        <h1>An online store that doesn't <em>look like a template</em>.</h1>
        <p>Most ecommerce builds reuse the same five Shopify themes. Yours won't. We build a 25-product store with bespoke product pages, a checkout tuned for mobile thumbs, and a homepage that stops the scroll. Up to 25 SKUs in the first launch.</p>
        <div style="margin-top:32px; position:relative;">
          @auth
            <a href="{{ route('contact') }}?service=ecommerce" class="btn btn-primary">Open a store →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing →</a>
          @endauth
        </div>
      </div>
      <div class="ec-split-r">
        <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1400&q=80&auto=format&fit=crop" alt="Online store packaging">
      </div>
    </section>

    <section class="ec-checks">
      <div class="container">
        <h2>What's actually included.</h2>
        <ul>
          <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>25 product pages, each individually styled</strong><span>Not a single shared template card. Image cropping, copy, and CTA tuned per SKU based on margin and intent.</span></div></li>
          <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Mobile-first checkout</strong><span>Three-step flow with auto-fill, address validation, Apple/Google Pay, and a guest option that doesn't punish first-time buyers.</span></div></li>
          <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Abandoned cart, post-purchase, win-back flows</strong><span>Three Klaviyo or Shopify-native flows live at launch — pre-written, A/B-ready, and tuned to your category.</span></div></li>
          <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Reviews, FAQs, and trust seals</strong><span>Imported from your existing reviews if any, otherwise we write five "honest sample" reviews you approve before launch.</span></div></li>
          <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Analytics + conversion tracking</strong><span>GA4, Meta Pixel, TikTok Pixel, Klaviyo events. Server-side where it matters. We test every event end-to-end.</span></div></li>
        </ul>
      </div>
    </section>

    <section class="ec-strip">
      <div class="container">
        <div class="row">
          <figure><img src="https://images.unsplash.com/photo-1556742111-a301076d9d18?w=600&q=80&auto=format&fit=crop" alt="Product photo 1"></figure>
          <figure><img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80&auto=format&fit=crop" alt="Product photo 2"></figure>
          <figure><img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?w=600&q=80&auto=format&fit=crop" alt="Product photo 3"></figure>
          <figure><img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80&auto=format&fit=crop" alt="Product photo 4"></figure>
        </div>
      </div>
    </section>

    <section class="ec-cta">
      <div class="container">
        <h2>Have a store you're proud to send to friends.</h2>
        <p style="color:#78350f; max-width: 540px; margin: 0 auto 26px;">4–6 weeks. Shopify or WooCommerce. Up to 25 SKUs at launch.</p>
        @auth
          <a href="{{ route('contact') }}?service=ecommerce" class="btn btn-primary">Start the store →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Create account &amp; view pricing →</a>
        @endauth
      </div>
    </section>
  </main>

  @include('partials.footer')
@endsection
