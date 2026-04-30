@extends('layouts.app')

@section('title', 'Custom Site + Integrations — Digirisers')
@section('description', 'A custom website wired into your CRM, payment, scheduling, and analytics stack — every form, every event, every webhook tested before launch.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ig-hero { position: relative; min-height: 78vh; display: grid; place-items: center; overflow: hidden; }
    .ig-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .ig-hero::after { content: ""; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(15,23,42,.85) 0%, rgba(30,58,138,.55) 100%); }
    .ig-hero .container { position: relative; z-index: 1; max-width: 880px; text-align: center; color: #fff; padding: 80px 24px; }
    .ig-hero h1 { color: #fff; font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 0 0 18px; letter-spacing: -0.035em; }
    .ig-hero h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #93c5fd; }
    .ig-hero p { font-size: 1.1rem; color: rgba(255,255,255,.85); max-width: 600px; margin: 0 auto 28px; line-height: 1.6; }
    .ig-eyebrow { display: inline-block; font-size: .72rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; padding: 7px 14px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); border-radius: 999px; color: #93c5fd; margin-bottom: 22px; backdrop-filter: blur(10px); }
    .ig-alt { padding: 80px 0; background: #fff; }
    .ig-alt-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; margin-bottom: 80px; }
    .ig-alt-grid:nth-child(even) > div:first-child { order: 2; }
    .ig-alt-grid h2 { font-size: clamp(1.5rem, 2.6vw, 2rem); margin: 0 0 14px; }
    .ig-alt-grid p { color: var(--muted); line-height: 1.65; }
    .ig-alt-grid figure { border-radius: 18px; overflow: hidden; aspect-ratio: 4/3; box-shadow: 0 30px 60px -30px rgba(11,16,32,.35); }
    .ig-alt-grid figure img { width: 100%; height: 100%; object-fit: cover; }
    .ig-stack { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
    .ig-stack span { padding: 8px 12px; background: #f1f5f9; border-radius: 10px; font-size: .78rem; font-weight: 600; color: var(--ink); text-align: center; }
    .ig-cta { padding: 80px 0; text-align: center; background: #0f172a; color: #fff; }
    .ig-cta h2 { color: #fff; }
    @media (max-width: 880px) { .ig-alt-grid { grid-template-columns: 1fr; } .ig-alt-grid:nth-child(even) > div:first-child { order: 1; } .ig-stack { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ig-hero">
    <img src="https://images.unsplash.com/photo-1581090464777-f3220bbe1b8b?w=1800&q=80&auto=format&fit=crop" alt="Engineer working on integrations">
    <div class="container">
      <span class="ig-eyebrow">Site + integrations</span>
      <h1>The site is the <em>visible</em> part. Most of the value is the wiring.</h1>
      <p>Form to CRM. CRM to email. Email to calendar. Calendar to Slack. Stripe to your accounting. We design and ship the front-end, then quietly wire your stack so a single submitted lead reaches everyone who needs to know.</p>
      @auth
        <a href="{{ route('contact') }}?service=custom-site-integrations" class="btn btn-primary">Plan the integration</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth
    </div>
  </section>

  <section class="ig-alt">
    <div class="container">

      <div class="ig-alt-grid">
        <div>
          <h2>Forms that don't lose leads.</h2>
          <p>Every form sends to your CRM with a verified payload, fires a confirmation email, attaches UTM data, and posts to Slack — within 90 seconds, every time. We test each path with synthetic submissions before launch and set up uptime monitoring on the webhook.</p>
          <div class="ig-stack"><span>HubSpot</span><span>Salesforce</span><span>GHL</span><span>Pipedrive</span></div>
        </div>
        <figure><img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200&q=80&auto=format&fit=crop" alt="CRM dashboard"></figure>
      </div>

      <div class="ig-alt-grid">
        <div>
          <h2>Payments and scheduling that just work.</h2>
          <p>Stripe checkout, Calendly or Cal.com, Plaid for ACH if you need it. We handle the webhook handlers, the failure cases, the receipts, and the calendar holds — so a sale on the site appears in your accounting and on your team's calendar without anyone copy-pasting.</p>
          <div class="ig-stack"><span>Stripe</span><span>Cal.com</span><span>Calendly</span><span>QuickBooks</span></div>
        </div>
        <figure><img src="https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?w=1200&q=80&auto=format&fit=crop" alt="Scheduling and payments"></figure>
      </div>

      <div class="ig-alt-grid">
        <div>
          <h2>Analytics you'll actually look at.</h2>
          <p>GA4 + GTM with server-side events for the moments that matter. A small Looker Studio dashboard tuned to your three KPIs — not the default 47-widget mess. You leave with a dashboard your CFO will read and your CMO will trust.</p>
          <div class="ig-stack"><span>GA4</span><span>GTM</span><span>Looker</span><span>Segment</span></div>
        </div>
        <figure><img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=80&auto=format&fit=crop" alt="Analytics dashboard"></figure>
      </div>

    </div>
  </section>

  <section class="ig-cta">
    <div class="container">
      <h2>Stop letting leads die in the gap between systems.</h2>
      <p style="color:rgba(255,255,255,.7); max-width:540px; margin:0 auto 26px;">A custom site, your stack wired tight, monitoring in place. 4–6 weeks.</p>
      @auth
        <a href="{{ route('contact') }}?service=custom-site-integrations" class="btn btn-light">Scope the build →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-light">Create account &amp; view pricing →</a>
      @endauth
    </div>
  </section>

  @include('partials.footer')
@endsection
