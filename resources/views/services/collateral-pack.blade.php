@extends('layouts.app')
@section('title', 'Digital Marketing Collateral Pack — Digirisers')
@section('description', 'Ten polished marketing assets — pitch deck, sales one-pager, case study template, social post pack — designed as a coherent system, not ten random files.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .cp-hero { padding: 100px 0 50px; }
    .cp-hero .row { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
    .cp-hero h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 14px 0 18px; }
    .cp-hero h1 em { color: #65a30d; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .cp-hero .tag { font-size:.74rem; font-weight:700; color:#3f6212; background:#ecfccb; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .cp-hero .lede { color: var(--muted); font-size: 1.06rem; line-height: 1.65; max-width: 480px; }
    .cp-hero figure { aspect-ratio: 4/3; border-radius: 22px; overflow: hidden; box-shadow: 0 40px 80px -40px rgba(11,16,32,.4); }
    .cp-hero figure img { width: 100%; height: 100%; object-fit: cover; }
    .cp-list { padding: 70px 0; background: #f7fee7; border-top: 1px solid #d9f99d; }
    .cp-list h2 { text-align: center; max-width: 600px; margin: 0 auto 36px; }
    .cp-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; max-width: 980px; margin: 0 auto; }
    .cp-asset { padding: 18px 22px; background: #fff; border: 1px solid #d9f99d; border-radius: 12px; display: grid; grid-template-columns: 50px 1fr; gap: 16px; align-items: center; transition: border-color .2s ease, transform .2s ease; }
    .cp-asset:hover { border-color: #65a30d; transform: translateX(3px); }
    .cp-asset .num { font-family: var(--font-mono); color: #65a30d; font-weight: 700; font-size: 1.4rem; line-height: 1; }
    .cp-asset h3 { font-size: 1rem; margin: 0 0 4px; }
    .cp-asset p { font-size: .85rem; color: var(--muted); margin: 0; line-height: 1.5; }
    @media (max-width: 880px) { .cp-hero .row, .cp-grid { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container cp-hero">
    <div class="row">
      <div>
        <span class="tag">Collateral · 10 assets</span>
        <h1>The ten things you'll <em>actually send</em> in the next 90 days.</h1>
        <p class="lede">Most marketing collateral packs ship with 30 templates that nobody opens. We pick the ten you'll genuinely use — pitch deck, one-pager, case-study template, social post pack — and design them as a connected system in your brand, ready to ship.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=collateral-pack" class="btn btn-primary">Plan the pack →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <figure><img src="https://images.unsplash.com/photo-1493612276216-ee3925520721?w=1200&q=80&auto=format&fit=crop" alt="Marketing collateral materials"></figure>
    </div>
  </section>

  <section class="cp-list">
    <div class="container">
      <h2>The ten assets, specifically.</h2>
      <div class="cp-grid">
        <div class="cp-asset"><span class="num">01</span><div><h3>Pitch deck</h3><p>12-slide investor or sales deck. Narrative-driven, not bullet-point soup.</p></div></div>
        <div class="cp-asset"><span class="num">02</span><div><h3>Sales one-pager</h3><p>The PDF you leave behind after a meeting. One page, one ask.</p></div></div>
        <div class="cp-asset"><span class="num">03</span><div><h3>Case-study template</h3><p>Editable layout for case studies. Hero, problem, approach, results.</p></div></div>
        <div class="cp-asset"><span class="num">04</span><div><h3>Service explainer</h3><p>4-page mini-brochure for your highest-margin service offering.</p></div></div>
        <div class="cp-asset"><span class="num">05</span><div><h3>Social post pack</h3><p>15 ready-to-post graphics: announcements, quotes, stats, behind-the-scenes.</p></div></div>
        <div class="cp-asset"><span class="num">06</span><div><h3>Email signature</h3><p>HTML signature block with logo, role, and one current promo.</p></div></div>
        <div class="cp-asset"><span class="num">07</span><div><h3>Letterhead + invoice</h3><p>Branded templates for the docs that actually go out from accounting.</p></div></div>
        <div class="cp-asset"><span class="num">08</span><div><h3>LinkedIn banner + headshot frames</h3><p>For the founder's profile and the team's profiles.</p></div></div>
        <div class="cp-asset"><span class="num">09</span><div><h3>Webinar slide template</h3><p>For the talks and demos you'll give. Same brand, no improvisation needed.</p></div></div>
        <div class="cp-asset"><span class="num">10</span><div><h3>Email newsletter template</h3><p>Built in your ESP — Klaviyo, ConvertKit, or HubSpot — with reusable sections.</p></div></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
