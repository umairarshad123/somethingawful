@extends('layouts.app')
@section('title', 'AI Customer Support Agent — Digirisers')
@section('description', 'A 24/7 AI support agent that resolves tier-1 tickets, escalates the rest cleanly, and sounds like your brand — not a stock script.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .sp-hero { padding: 90px 0 60px; }
    .sp-hero .copy { max-width: 720px; }
    .sp-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; }
    .sp-hero h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #0891b2; }
    .sp-hero p { font-size: 1.05rem; color: var(--muted); line-height: 1.65; max-width: 580px; }
    .sp-tag { font-size:.72rem; font-weight:700; color:#0e7490; background:#ecfeff; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .sp-numbers { padding: 40px 0 80px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
    .sp-num { padding: 22px; background: linear-gradient(135deg, #ecfeff 0%, #fff 100%); border: 1px solid #cffafe; border-radius: 16px; }
    .sp-num strong { display:block; font-size:2rem; color:#0891b2; font-weight:800; letter-spacing:-0.02em; }
    .sp-num small { font-size: .82rem; color: var(--muted); }
    .sp-photo { padding: 0 0 80px; }
    .sp-photo figure { aspect-ratio: 21/9; border-radius: 22px; overflow: hidden; }
    .sp-photo img { width: 100%; height: 100%; object-fit: cover; }
    .sp-list { padding: 80px 0; background: #f0f9ff; }
    .sp-list h2 { max-width: 600px; margin: 0 0 30px; }
    .sp-list ul { list-style: none; padding: 0; margin: 0; display: grid; gap: 14px; max-width: 760px; }
    .sp-list li { display: grid; grid-template-columns: 28px 1fr; gap: 16px; padding: 18px 22px; background: #fff; border-radius: 12px; }
    .sp-list li svg { color: #0891b2; margin-top: 3px; }
    .sp-list strong { display: block; margin-bottom: 4px; }
    .sp-list span { color: var(--muted); font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .sp-numbers { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container sp-hero">
    <div class="copy">
      <span class="sp-tag">AI Support · 24/7</span>
      <h1>The night shift you don't have to <em>hire</em>.</h1>
      <p>Tier-1 tickets — "where's my order," "how do I reset," "do you ship to X" — make up 60–80% of inbound support volume. Most don't need a human. We deploy an AI agent trained on your help center and tone of voice, with a clean escalation path so the tickets that DO need a human reach one fast.</p>
      <p style="margin-top:24px;">
        @auth
          <a href="{{ route('contact') }}?service=ai-support-agent" class="btn btn-primary">Plan deployment →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>
    </div>
  </section>

  <div class="container sp-numbers">
    <div class="sp-num"><strong>78%</strong><small>tier-1 ticket deflection</small></div>
    <div class="sp-num"><strong>4.6 / 5</strong><small>customer satisfaction post-resolve</small></div>
    <div class="sp-num"><strong>2 min</strong><small>median response, all hours</small></div>
    <div class="sp-num"><strong>14 days</strong><small>typical deployment</small></div>
  </div>

  <section class="container sp-photo">
    <figure><img src="https://images.unsplash.com/photo-1573497019418-b400bb3ab074?w=1800&q=80&auto=format&fit=crop" alt="Customer support agent at headset"></figure>
  </section>

  <section class="sp-list">
    <div class="container">
      <h2>What's actually deployed.</h2>
      <ul>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Voice match</strong><span>We feed it 50+ of your real past replies so the agent sounds like you. Not "as a large language model."</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Live-data tools</strong><span>Order lookup, refund status, subscription details — wired to your Shopify, Stripe, or internal API. No hallucinated tracking numbers.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Clean escalation</strong><span>Sentiment + topic + customer-tier rules decide when to hand to a human. Full conversation context attached.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Weekly improvement</strong><span>Failed conversations logged. We retrain monthly on the gaps. The agent gets sharper with every ticket.</span></div></li>
      </ul>
    </div>
  </section>

  @include('partials.footer')
@endsection
