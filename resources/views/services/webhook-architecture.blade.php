@extends('layouts.app')
@section('title', 'Webhook Architecture — Digirisers')
@section('description', 'A custom webhook architecture for high-throughput, mission-critical event flows. Idempotent, observable, retry-aware — built where Zapier would buckle.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .wh { background: #0a0a0a; color: #fff; padding: 100px 0; min-height: 95vh; position: relative; overflow: hidden; }
    .wh::after { content: ""; position: absolute; bottom: -300px; right: -200px; width: 800px; height: 800px; background: radial-gradient(circle, rgba(34,197,94,.18), transparent 65%); pointer-events: none; }
    .wh .container { position: relative; }
    .wh h1 { color: #fff; font-size: clamp(2.2rem, 4.4vw, 3.4rem); margin: 14px 0 16px; max-width: 760px; }
    .wh h1 em { color: #4ade80; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .wh .tag { font-size:.72rem; font-weight:700; color:#4ade80; background:rgba(74,222,128,.12); padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; border: 1px solid rgba(74,222,128,.25); }
    .wh .lede { color: #d4d4d8; font-size: 1.06rem; max-width: 600px; line-height: 1.65; margin: 0 0 28px; }
    .wh-six { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; margin-top: 50px; }
    .wh-six > div { padding: 20px 16px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 12px; transition: background .25s ease, border-color .25s ease; }
    .wh-six > div:hover { background: rgba(74,222,128,.06); border-color: rgba(74,222,128,.3); }
    .wh-six .label { font-family: var(--font-mono); color: #4ade80; font-size: .68rem; letter-spacing: .14em; }
    .wh-six h3 { color: #fff; margin: 8px 0 4px; font-size: .92rem; }
    .wh-six p { color: #a1a1aa; font-size: .8rem; margin: 0; line-height: 1.5; }
    .wh-bar { padding: 70px 0; background: #fafafa; color: var(--ink); }
    .wh-bar h2 { text-align: center; max-width: 580px; margin: 0 auto 30px; }
    .wh-bar p { text-align: center; max-width: 620px; margin: 0 auto; color: var(--muted); line-height: 1.65; }
    @media (max-width: 880px) { .wh-six { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="wh">
    <div class="container">
      <span class="tag">Webhook · custom flow</span>
      <h1>For event flows where <em>"sometimes it works"</em> isn't acceptable.</h1>
      <p class="lede">Stripe webhooks, Calendly bookings, Shopify orders, Twilio SMS replies — these are the events that, if missed, cost you money or trust. Zapier and Make are great until the volume passes 50k/month or the latency requirement drops below 30 seconds. Then you need real architecture.</p>
      @auth
        <a href="{{ route('contact') }}?service=webhook-architecture" class="btn btn-primary">Architect the flow →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth

      <div class="wh-six">
        <div><span class="label">RECEIVE</span><h3>Edge-deployed</h3><p>Cloudflare Worker or AWS Lambda — sub-100ms ingest from anywhere.</p></div>
        <div><span class="label">VERIFY</span><h3>Signature checks</h3><p>HMAC validation on every payload. Replay-attack windows enforced.</p></div>
        <div><span class="label">QUEUE</span><h3>Persistent</h3><p>Postgres or SQS. Events durably stored before any processing.</p></div>
        <div><span class="label">PROCESS</span><h3>Idempotent</h3><p>Duplicate events are no-ops. Reruns safe. Outbox pattern where it matters.</p></div>
        <div><span class="label">RETRY</span><h3>Exponential backoff</h3><p>Transient failures retry up to 8 times. Permanent failures alert.</p></div>
        <div><span class="label">OBSERVE</span><h3>Full trace</h3><p>Every event tagged with a trace ID, queryable end-to-end in Datadog or your tool.</p></div>
      </div>
    </div>
  </section>

  <section class="wh-bar">
    <div class="container">
      <h2>Built where it has to scale.</h2>
      <p>We've built webhook architectures handling 2M+ events daily for fintech and e-commerce clients. The principles are the same at any volume — idempotent, observable, recoverable — but the platform choices vary. We pick what fits your stack, not what fits a portfolio.</p>
    </div>
  </section>

  @include('partials.footer')
@endsection
