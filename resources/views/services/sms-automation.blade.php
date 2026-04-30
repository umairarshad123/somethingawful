@extends('layouts.app')
@section('title', 'SMS Marketing Automation Setup — Digirisers')
@section('description', 'SMS marketing flows that respect the medium — short, timed correctly, opt-in clean, compliance-aware. Twilio, Klaviyo SMS, or Postscript.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ss-hero { padding: 100px 0; max-width: 980px; margin: 0 auto; display: grid; grid-template-columns: 1.2fr 1fr; gap: 60px; align-items: center; }
    .ss-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; }
    .ss-hero h1 em { color: #16a34a; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .ss-hero .tag { font-size:.74rem; font-weight:700; color:#15803d; background:#dcfce7; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .ss-hero .lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; }
    .ss-phone { background: #1a1a1a; border-radius: 36px; padding: 18px; box-shadow: 0 50px 100px -40px rgba(11,16,32,.5); margin: 0 auto; max-width: 320px; }
    .ss-phone-screen { background: #fafafa; border-radius: 24px; padding: 14px 12px; min-height: 480px; }
    .ss-phone .meta { text-align: center; font-size: .78rem; color: var(--soft); margin-bottom: 12px; }
    .ss-msg { padding: 10px 14px; margin: 6px 0; border-radius: 14px; font-size: .82rem; line-height: 1.4; }
    .ss-msg.brand { background: #dcfce7; color: #14532d; max-width: 80%; }
    .ss-msg.user { background: #2563eb; color: #fff; max-width: 70%; margin-left: auto; }
    .ss-msg .when { display: block; font-size: .68rem; color: var(--soft); margin-top: 4px; font-weight: 600; }
    .ss-msg.brand .when { color: #15803d; }
    .ss-msg.user .when { color: #bfdbfe; }
    .ss-comply { padding: 70px 0; background: #f0fdf4; }
    .ss-comply h2 { text-align: center; max-width: 580px; margin: 0 auto 30px; }
    .ss-comply ul { list-style: none; padding: 0; margin: 0; max-width: 760px; margin: 0 auto; display: grid; gap: 12px; }
    .ss-comply li { padding: 16px 22px; background: #fff; border: 1px solid #bbf7d0; border-radius: 12px; display: grid; grid-template-columns: 24px 1fr; gap: 14px; }
    .ss-comply svg { color: #16a34a; margin-top: 3px; }
    .ss-comply strong { display: block; margin-bottom: 4px; }
    .ss-comply span { color: var(--muted); font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .ss-hero { grid-template-columns: 1fr; padding: 60px 0; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container ss-hero">
    <div>
      <span class="tag">SMS · automation</span>
      <h1>The channel where attention is <em>still cheap</em>.</h1>
      <p class="lede">SMS open rates run 95%+. Click rates are 5x email. The catch: send the wrong message at the wrong time and you burn the channel forever — and possibly land your business on a do-not-text list. We build SMS the way it should be done: opt-in clean, short, timed correctly, and TCPA-compliant from the first send.</p>
      <p style="margin-top:24px;">
        @auth
          <a href="{{ route('contact') }}?service=sms-automation" class="btn btn-primary">Set up SMS →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>
    </div>
    <div class="ss-phone">
      <div class="ss-phone-screen">
        <div class="meta">+1 (555) DIGIRSE</div>
        <div class="ss-msg brand">Hey Sarah — your order from Riverside Goods just shipped! 📦 Track at the link below. <span class="when">9:42 AM</span></div>
        <div class="ss-msg user">Thanks!<span class="when">9:43 AM</span></div>
        <div class="ss-msg brand">You're welcome. Reply STOP to opt out anytime. <span class="when">9:43 AM</span></div>
        <div class="ss-msg brand">Heads up — your favorite candle is back in stock. Want first dibs? <span class="when">2 days later</span></div>
      </div>
    </div>
  </section>

  <section class="ss-comply">
    <div class="container">
      <h2>Compliance done right at setup.</h2>
      <ul>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Double opt-in flow</strong><span>Web form → carrier-verified confirmation → first message. No grey-area imports.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>STOP / HELP keywords honored</strong><span>Auto-handled at the platform level. We test the path before launch.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Quiet hours by timezone</strong><span>No 6am Saturday sends. State-by-state rules respected (Texas, Florida have specific limits).</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>10DLC registration</strong><span>For US — we handle brand + campaign registration so your throughput isn't throttled.</span></div></li>
      </ul>
    </div>
  </section>

  @include('partials.footer')
@endsection
