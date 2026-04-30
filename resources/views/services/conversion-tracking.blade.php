@extends('layouts.app')
@section('title', 'Conversion Tracking & Attribution Setup — Digirisers')
@section('description', 'Server-side conversion tracking, multi-touch attribution, and a Looker dashboard that finally tells you which channels drive revenue.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ct { padding: 90px 0; }
    .ct h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); max-width: 720px; margin: 14px 0 18px; }
    .ct h1 em { color: #4f46e5; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .ct .tag { font-size:.74rem; font-weight:700; color:#3730a3; background:#eef2ff; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .ct p.lede { color: var(--muted); font-size: 1.06rem; max-width: 640px; line-height: 1.65; }
    .ct-six { padding: 60px 0; display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; }
    .ct-six > div { padding: 20px 18px; background: #fff; border: 1px solid var(--line); border-radius: 12px; transition: border-color .2s ease; }
    .ct-six > div:hover { border-color: #6366f1; }
    .ct-six .num { font-family: var(--font-mono); font-size: 1.4rem; color: #4f46e5; font-weight: 800; line-height: 1; margin-bottom: 8px; }
    .ct-six h3 { font-size: .92rem; margin: 0 0 4px; }
    .ct-six p { font-size: .82rem; color: var(--muted); margin: 0; line-height: 1.5; }
    .ct-stack { padding: 70px 0; background: linear-gradient(180deg, #fff 0%, #eef2ff 100%); border-top: 1px solid var(--line); }
    .ct-stack h2 { text-align: center; margin: 0 0 36px; max-width: 540px; margin: 0 auto 36px; }
    .ct-stack .layers { max-width: 720px; margin: 0 auto; display: grid; gap: 8px; }
    .ct-stack .layer { padding: 18px 22px; background: #fff; border: 1.5px solid #c7d2fe; border-radius: 14px; display: grid; grid-template-columns: 100px 1fr; gap: 18px; align-items: center; }
    .ct-stack .layer strong { font-family: var(--font-mono); font-size: .76rem; color: #4f46e5; letter-spacing: .12em; }
    .ct-stack .layer span { font-size: .92rem; color: var(--ink); }
    .ct-stack .layer small { color: var(--muted); font-size: .82rem; display:block; margin-top: 3px; }
    @media (max-width: 880px) { .ct-six { grid-template-columns: 1fr 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container ct">
    <span class="tag">Tracking · attribution</span>
    <h1>Stop guessing which channel <em>actually works</em>.</h1>
    <p class="lede">iOS 14, third-party cookie deprecation, and platform-attribution self-grading have made measurement a mess. We rebuild your tracking from the ground up: server-side, deterministic where possible, and reported in one place — so you can defund the channel that quietly hasn't been working.</p>
    <p style="margin-top:22px;">
      @auth
        <a href="{{ route('contact') }}?service=conversion-tracking" class="btn btn-primary">Audit your stack →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth
    </p>

    <div class="ct-six">
      <div><span class="num">14</span><h3>Events instrumented</h3><p>The right events at the right granularity.</p></div>
      <div><span class="num">3</span><h3>Pixels deployed</h3><p>Server-side via your domain, not the platforms'.</p></div>
      <div><span class="num">1</span><h3>Source of truth</h3><p>One BigQuery / Postgres warehouse, not three dashboards.</p></div>
      <div><span class="num">5d</span><h3>Avg setup time</h3><p>Standard stack. Custom takes 10-14 days.</p></div>
      <div><span class="num">~12%</span><h3>Conversion uplift</h3><p>Reported uplift via better attribution, not new ads.</p></div>
      <div><span class="num">365d</span><h3>Lookback retained</h3><p>Self-hosted data, not deleted by Meta in 28 days.</p></div>
    </div>
  </section>

  <section class="ct-stack">
    <div class="container">
      <h2>The four-layer attribution stack we ship.</h2>
      <div class="layers">
        <div class="layer"><strong>LAYER 1</strong><div><span>Client-side GTM</span><small>Standard event firing on user actions. Fast, low-friction baseline.</small></div></div>
        <div class="layer"><strong>LAYER 2</strong><div><span>Server-side GTM</span><small>Pixels fire from your subdomain so iOS / ITP doesn't strip them.</small></div></div>
        <div class="layer"><strong>LAYER 3</strong><div><span>Conversion API direct</span><small>Meta CAPI, Google Enhanced Conversions, TikTok EAPI — deterministic match keys.</small></div></div>
        <div class="layer"><strong>LAYER 4</strong><div><span>Warehouse + Looker</span><small>All raw events into BigQuery, modeled with dbt, surfaced in Looker as your single dashboard.</small></div></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
