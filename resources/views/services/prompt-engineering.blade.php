@extends('layouts.app')
@section('title', 'Prompt Engineering Package — Digirisers')
@section('description', 'A documented prompt library tuned to your team\'s real tasks — with eval scaffolding so you know which prompts actually work.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .pe { background: #18181b; color: #d4d4d8; padding: 90px 0; min-height: 90vh; }
    .pe h1 { color: #fff; font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 16px; }
    .pe h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #a3e635; }
    .pe .lede { color: #a1a1aa; font-size: 1.06rem; line-height: 1.65; max-width: 580px; margin: 0 0 30px; }
    .pe-tag { font-size:.72rem; font-weight:700; color:#a3e635; background:rgba(163,230,53,.1); padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; border:1px solid rgba(163,230,53,.25); }
    .pe-table { background: #09090b; border-radius: 16px; overflow: hidden; margin: 50px 0; font-family: var(--font-mono); font-size: .82rem; }
    .pe-table .hd { padding: 14px 22px; background: #0c0c0d; color: #71717a; border-bottom: 1px solid #27272a; }
    .pe-table .row { display: grid; grid-template-columns: 1fr 80px 80px; gap: 20px; padding: 16px 22px; border-bottom: 1px solid #18181b; align-items: center; }
    .pe-table .row:last-child { border-bottom: 0; }
    .pe-table .row strong { color: #fff; font-weight: 500; }
    .pe-table .pass { color: #a3e635; }
    .pe-table .fail { color: #f87171; }
    .pe-table .meh { color: #fbbf24; }
    .pe-deliv { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-top: 50px; }
    .pe-deliv > div { padding: 24px; background: #09090b; border: 1px solid #27272a; border-radius: 14px; }
    .pe-deliv h3 { color: #fff; font-size: 1rem; margin: 0 0 8px; }
    .pe-deliv p { color: #a1a1aa; font-size: .88rem; margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .pe-table .row { grid-template-columns: 1fr 60px 60px; gap: 10px; font-size: .76rem; } .pe-deliv { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <main class="pe">
    <div class="container">
      <span class="pe-tag">Prompt eng. package</span>
      <h1>Prompts your team will <em>actually</em> reuse.</h1>
      <p class="lede">"We tried ChatGPT, it's fine sometimes" is a productivity dead end. We sit with three of your teams, document the 20 tasks they repeat weekly, and ship versioned prompts that produce consistent output — with an eval suite so you know when a prompt regresses.</p>
      @auth
        <a href="{{ route('contact') }}?service=prompt-engineering" class="btn btn-primary">Plan it →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth

      <div class="pe-table">
        <div class="hd">/ EVAL RESULTS · sample run</div>
        <div class="row"><span><strong>summarize-meeting-v3</strong></span><span class="pass">PASS</span><span class="pass">94%</span></div>
        <div class="row"><span><strong>extract-action-items-v2</strong></span><span class="pass">PASS</span><span class="pass">91%</span></div>
        <div class="row"><span><strong>draft-followup-email-v4</strong></span><span class="meh">REVIEW</span><span class="meh">78%</span></div>
        <div class="row"><span><strong>classify-ticket-v5</strong></span><span class="pass">PASS</span><span class="pass">96%</span></div>
        <div class="row"><span><strong>generate-spec-v1</strong></span><span class="fail">FAIL</span><span class="fail">62%</span></div>
      </div>

      <div class="pe-deliv">
        <div><h3>Prompt library</h3><p>20+ versioned prompts in your team's voice, organized by task — copyable, paramaterized, and tested.</p></div>
        <div><h3>Eval suite</h3><p>Real test cases scored against expected output. Catches regressions before they reach production.</p></div>
        <div><h3>Team training</h3><p>One 90-min session per team showing how to use, modify, and contribute new prompts to the library.</p></div>
      </div>
    </div>
  </main>

  @include('partials.footer')
@endsection
