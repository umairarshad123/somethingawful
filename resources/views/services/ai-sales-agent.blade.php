@extends('layouts.app')
@section('title', 'AI Sales & Appointment Setter — Digirisers')
@section('description', 'An AI sales agent that qualifies inbound leads in conversation, books the right ones, and routes the rest to nurture — running on your CRM in real time.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .sa-hero { position: relative; min-height: 78vh; display: grid; place-items: center; overflow: hidden; }
    .sa-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .sa-hero::after { content: ""; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(7,89,133,.85) 0%, rgba(2,132,199,.55) 100%); }
    .sa-hero .container { position: relative; z-index: 1; max-width: 800px; text-align: center; color: #fff; padding: 80px 24px; }
    .sa-hero h1 { color: #fff; font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 18px 0 18px; }
    .sa-hero h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #7dd3fc; }
    .sa-hero p { color: rgba(255,255,255,.85); font-size: 1.08rem; max-width: 560px; margin: 0 auto 28px; line-height: 1.65; }
    .sa-hero .pill { display:inline-block; font-size:.74rem; color:#7dd3fc; background:rgba(255,255,255,.1); padding:7px 14px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,.2); }
    .sa-flow { padding: 90px 0; background: #fff; }
    .sa-flow h2 { text-align: center; max-width: 600px; margin: 0 auto 50px; }
    .sa-pipe { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; align-items: stretch; }
    .sa-stage { padding: 22px; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 14px; position: relative; transition: transform .25s ease, box-shadow .25s ease; }
    .sa-stage:hover { transform: translateY(-3px); box-shadow: 0 18px 36px -16px rgba(2,132,199,.4); }
    .sa-stage:not(:last-child)::after { content: "→"; position: absolute; right: -16px; top: 50%; transform: translateY(-50%); font-size: 1.6rem; color: #0284c7; z-index: 1; font-weight: 700; }
    .sa-stage strong { display: block; font-size: .92rem; color: #075985; margin-bottom: 6px; }
    .sa-stage p { font-size: .82rem; color: var(--muted); margin: 0; line-height: 1.5; }
    @media (max-width: 880px) { .sa-pipe { grid-template-columns: 1fr; } .sa-stage::after { display: none; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="sa-hero">
    <img src="https://images.unsplash.com/photo-1556745757-8d76bdb6984b?w=1800&q=80&auto=format&fit=crop" alt="Sales conversation">
    <div class="container">
      <span class="pill">AI sales agent</span>
      <h1>Qualify in conversation. Book the <em>right</em> meetings.</h1>
      <p>SDR teams cost $80k+ per seat to do a job that's largely scripted: ask five questions, route the qualified, nurture the rest. We deploy an AI agent that does it in real time, 24/7, on your forms and chat, and books straight into your calendar.</p>
      @auth
        <a href="{{ route('contact') }}?service=ai-sales-agent" class="btn btn-light">Map your funnel →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-light">Sign in to view pricing</a>
      @endauth
    </div>
  </section>

  <section class="sa-flow">
    <div class="container">
      <h2>From form fill to calendar invite.</h2>
      <div class="sa-pipe">
        <div class="sa-stage"><strong>1 · Capture</strong><p>Lead submits form, opens chat, or replies to email. Agent picks it up within seconds.</p></div>
        <div class="sa-stage"><strong>2 · Qualify</strong><p>Five conversational questions tuned to your ICP — company size, budget, timeline, fit signals.</p></div>
        <div class="sa-stage"><strong>3 · Score</strong><p>Lead scored A/B/C on the spot. Posted to your CRM with the full transcript attached.</p></div>
        <div class="sa-stage"><strong>4 · Route</strong><p>A's get a calendar link with the right rep. B's enter nurture. C's receive a polite no with resources.</p></div>
        <div class="sa-stage"><strong>5 · Handoff</strong><p>Rep sees the conversation before the call. No "tell me about yourself" cold opens.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
