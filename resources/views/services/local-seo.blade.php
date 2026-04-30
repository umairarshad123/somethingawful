@extends('layouts.app')
@section('title', 'Local SEO Setup — Digirisers')
@section('description', 'Google Business Profile setup, local citations, and the foundational on-map work that makes you the obvious choice for "near me" searches.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ls { padding: 90px 0; }
    .ls-row { display: grid; grid-template-columns: 1.3fr 1fr; gap: 60px; align-items: center; }
    .ls h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 12px 0 18px; }
    .ls h1 em { color: #d97706; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .ls .lede { color: var(--muted); font-size: 1.08rem; line-height: 1.65; max-width: 540px; }
    .ls .tag { font-size:.74rem; font-weight:700; color:#92400e; background:#fef3c7; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .ls-map { aspect-ratio: 1; border-radius: 22px; overflow: hidden; position: relative; box-shadow: 0 40px 80px -40px rgba(11,16,32,.4); }
    .ls-map img { width: 100%; height: 100%; object-fit: cover; }
    .ls-map .pin { position: absolute; top: 40%; left: 45%; width: 32px; height: 32px; background: #d97706; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 6px 20px rgba(217,119,6,.5); animation: ls-pulse 2.4s infinite; }
    @keyframes ls-pulse { 0% { box-shadow: 0 6px 20px rgba(217,119,6,.5), 0 0 0 0 rgba(217,119,6,.6); } 70% { box-shadow: 0 6px 20px rgba(217,119,6,.5), 0 0 0 22px rgba(217,119,6,0); } 100% { box-shadow: 0 6px 20px rgba(217,119,6,.5), 0 0 0 0 rgba(217,119,6,0); } }
    .ls-checks { padding: 70px 0; border-top: 1px solid var(--line); margin-top: 70px; }
    .ls-checks h2 { max-width: 580px; margin: 0 0 30px; }
    .ls-checks ol { list-style: none; padding: 0; margin: 0; counter-reset: ls; display: grid; gap: 14px; max-width: 780px; }
    .ls-checks li { counter-increment: ls; padding: 18px 22px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; display: grid; grid-template-columns: 36px 1fr; gap: 18px; }
    .ls-checks li::before { content: counter(ls); font-family: var(--font-mono); font-weight: 700; color: #b45309; }
    .ls-checks strong { display:block; margin-bottom: 4px; }
    .ls-checks span { color: var(--muted); font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .ls-row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container ls">
    <div class="ls-row">
      <div>
        <span class="tag">Local SEO · GBP + citations</span>
        <h1>Be the obvious choice for <em>"near me"</em>.</h1>
        <p class="lede">87% of local searches end with a click, call, or visit within 24 hours. Showing up in the local 3-pack is the difference between owning your zip code and watching it go to a competitor with worse work but better fundamentals.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=local-seo" class="btn btn-primary">Claim your map →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <div class="ls-map">
        <img src="https://images.unsplash.com/photo-1597092474874-44dd1f64fcc8?w=1200&q=80&auto=format&fit=crop" alt="Map view">
        <span class="pin"></span>
      </div>
    </div>

    <div class="ls-checks">
      <h2>Six fundamentals we lock down.</h2>
      <ol>
        <li><div><strong>Google Business Profile completion</strong><span>Categories, service areas, hours, attributes, photos. Every field filled correctly the first time, indexable, with the primary category that actually maps to search intent.</span></div></li>
        <li><div><strong>NAP consistency across 50+ directories</strong><span>Name, Address, Phone — identical to the character — across every directory Google trusts. Dupes deleted, conflicts resolved.</span></div></li>
        <li><div><strong>Schema markup on every page</strong><span>LocalBusiness JSON-LD with hours, services, geo coordinates, and review aggregate — so Google reads your site the same way it reads your profile.</span></div></li>
        <li><div><strong>Review acquisition flow</strong><span>A review-request flow tied to your CRM — sent at the moment of highest customer satisfaction, no awkward "please rate us" emails 30 days later.</span></div></li>
        <li><div><strong>Geo-targeted location pages</strong><span>One page per service area, written for that area — neighborhoods, landmarks, local language. Indexed and internally linked.</span></div></li>
        <li><div><strong>Monthly map-pack tracking</strong><span>You get a Looker dashboard showing your rank for the 20 keywords that matter, by zip code. No vanity metrics — only the searches that drive calls.</span></div></li>
      </ol>
    </div>
  </section>

  @include('partials.footer')
@endsection
