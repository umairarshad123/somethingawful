@extends('layouts.app')
@section('title', 'LinkedIn DM Outreach Campaign — Digirisers')
@section('description', 'A LinkedIn outreach setup that doesn\'t feel like spam — researched targeting, three-step humanized messaging, and reply rates north of 8%.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .li { padding: 90px 0; max-width: 980px; margin: 0 auto; }
    .li h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; max-width: 740px; }
    .li h1 em { color: #0a66c2; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .li .tag { font-size:.74rem; font-weight:700; color:#075e9d; background:#dbeafe; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .li p.lede { color: var(--muted); font-size: 1.06rem; line-height: 1.65; max-width: 600px; margin: 0 0 28px; }
    .li-conv { padding: 60px 0; }
    .li-conv h2 { margin: 0 0 30px; }
    .li-thread { max-width: 640px; padding: 24px; background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 30px 60px -30px rgba(11,16,32,.2); }
    .li-msg { padding: 14px 16px; margin: 8px 0; border-radius: 14px; font-size: .9rem; line-height: 1.55; }
    .li-msg.out { background: #eff6ff; color: var(--ink); border: 1px solid #dbeafe; }
    .li-msg.in { background: #f8fafc; color: var(--ink); border: 1px solid var(--line); margin-left: 30px; }
    .li-msg .meta { display: block; font-size: .72rem; color: var(--soft); margin-bottom: 6px; font-weight: 600; }
    .li-bar { padding: 60px 0; background: #eff6ff; border-top: 1px solid var(--line); }
    .li-bar h2 { text-align: center; max-width: 580px; margin: 0 auto 30px; }
    .li-bar .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; max-width: 920px; margin: 0 auto; }
    .li-bar .cell { padding: 22px 18px; background: #fff; border: 1px solid #bfdbfe; border-radius: 12px; text-align: center; }
    .li-bar .cell strong { display: block; font-size: 1.6rem; color: #0a66c2; font-weight: 800; line-height: 1; margin-bottom: 6px; }
    .li-bar .cell small { font-size: .82rem; color: var(--muted); }
    @media (max-width: 880px) { .li-bar .stats { grid-template-columns: 1fr 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container li">
    <span class="tag">LinkedIn · DM outreach</span>
    <h1>Outreach that <em>opens conversations</em>, not gets you banned.</h1>
    <p class="lede">Templated cold pitches die on LinkedIn. Reply rates under 1%, often flagged as spam, sometimes restricted. We build personalized outreach campaigns: tightly-targeted prospect lists, three-step messaging that references something specific to each person, and tooling that respects LinkedIn's rate limits so your account stays healthy.</p>
    @auth
      <a href="{{ route('contact') }}?service=linkedin-dm" class="btn btn-primary">Plan your outreach →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="container li-conv">
    <h2>What a humanized sequence looks like.</h2>
    <div class="li-thread">
      <div class="li-msg out"><span class="meta">YOU · DAY 1</span>Hey Sarah — saw your post on enterprise procurement complexity. Especially the bit about RFP-to-contract handoff. We just rebuilt that flow for a similar org. Curious what you tried first.</div>
      <div class="li-msg in"><span class="meta">SARAH · DAY 1</span>Thanks for noticing! We did try [tool] but it didn't handle multi-stakeholder approval well. What did you build?</div>
      <div class="li-msg out"><span class="meta">YOU · DAY 1</span>Pretty similar pain. We ended up wiring approvals via [solution] with a tweaked stakeholder graph. Happy to show what worked — short call this week?</div>
      <div class="li-msg in"><span class="meta">SARAH · DAY 2</span>Yeah, send a calendar link.</div>
    </div>
  </section>

  <section class="li-bar">
    <div class="container">
      <h2>What real campaigns return.</h2>
      <div class="stats">
        <div class="cell"><strong>9.2%</strong><small>Reply rate (median)</small></div>
        <div class="cell"><strong>2.4%</strong><small>Meeting-booked rate</small></div>
        <div class="cell"><strong>0</strong><small>Account restrictions across 24 campaigns</small></div>
        <div class="cell"><strong>~14d</strong><small>Lead time, list-build to first send</small></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
