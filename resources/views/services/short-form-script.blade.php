@extends('layouts.app')
@section('title', 'Short-Form Video Scriptwriting — Digirisers')
@section('description', 'Scripts for TikTok, Reels, and Shorts that hook in the first second and pay off in fifteen — written by writers who actually study the algorithm.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .sc { padding: 90px 0; }
    .sc h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 14px 0 18px; max-width: 720px; }
    .sc h1 em { color: #f97316; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .sc .tag { font-size:.74rem; font-weight:700; color:#9a3412; background:#ffedd5; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .sc p.lede { color: var(--muted); font-size: 1.06rem; line-height: 1.65; max-width: 600px; margin: 0 0 28px; }
    .sc-script { padding: 60px 0; background: #18181b; color: #fafafa; }
    .sc-script .container { max-width: 820px; }
    .sc-script h2 { color: #fff; margin: 0 0 30px; font-size: 1.5rem; }
    .sc-line { display: grid; grid-template-columns: 100px 1fr; gap: 24px; padding: 16px 0; border-bottom: 1px solid #27272a; align-items: start; }
    .sc-line .timestamp { font-family: var(--font-mono); color: #fb923c; font-size: .82rem; font-weight: 700; }
    .sc-line .text { font-size: 1rem; line-height: 1.6; color: #fafafa; }
    .sc-line .text small { display: block; color: #a1a1aa; font-style: italic; margin-top: 4px; font-size: .8rem; }
    .sc-bar { padding: 70px 0; max-width: 880px; margin: 0 auto; text-align: center; }
    .sc-bar h2 { margin: 0 0 14px; }
    .sc-bar p { color: var(--muted); font-size: 1rem; line-height: 1.65; }
    @media (max-width: 720px) { .sc-line { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container sc">
    <span class="tag">Short-form scripts · per script</span>
    <h1 style="margin-top:14px;">Hook in <em>1.4 seconds</em>, payoff before fifteen.</h1>
    <p class="lede">Most short-form scripts die because they front-load context. Ours don't. We open with the most curiosity-arousing line possible, deliver the value mid-clip, and earn the rewatch — which is what the algorithm actually scores.</p>
    @auth
      <a href="{{ route('contact') }}?service=short-form-script" class="btn btn-primary">Brief us a script →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="sc-script">
    <div class="container">
      <h2>Sample script structure.</h2>
      <div class="sc-line"><span class="timestamp">0:00 - 0:02</span><div class="text">"You're holding your phone wrong. Here's the proof."<small>HOOK · pattern interrupt + curiosity gap</small></div></div>
      <div class="sc-line"><span class="timestamp">0:02 - 0:06</span><div class="text">Cut to: hand reaching for phone. Shows the bad grip everyone uses.<small>SETUP · visual confirms what they're already doing</small></div></div>
      <div class="sc-line"><span class="timestamp">0:06 - 0:10</span><div class="text">"It's killing your battery faster, your wrist is screaming, and there's a 3-second fix nobody told you."<small>STAKES · personal cost stacked, payoff teased</small></div></div>
      <div class="sc-line"><span class="timestamp">0:10 - 0:13</span><div class="text">Demonstrate: switch to correct grip. Quick before/after.<small>PAYOFF · the actual fix, visually obvious</small></div></div>
      <div class="sc-line"><span class="timestamp">0:13 - 0:15</span><div class="text">"If this saved your thumb, the second slide saves your back. Follow."<small>CTA · loop-bait + follow ask in same line</small></div></div>
    </div>
  </section>

  <section class="sc-bar">
    <h2>Voice-matched. Brand-aware. Algorithm-tuned.</h2>
    <p>Scripts are written specific to your founder's speech patterns, your category's visual conventions, and the platform's current algorithmic preferences. We don't write a "TikTok" — we write a script for your audience watching on TikTok this month.</p>
  </section>

  @include('partials.footer')
@endsection
