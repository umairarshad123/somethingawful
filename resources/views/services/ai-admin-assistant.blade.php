@extends('layouts.app')
@section('title', 'AI Admin Assistant — Digirisers')
@section('description', 'An AI assistant that handles your scheduling, expense filing, meeting notes, and inbox triage — for the price of a Slack license, not a salary.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ad { background: #fef3c7; padding: 90px 0; }
    .ad-grid { display: grid; grid-template-columns: 1fr 1fr; min-height: 75vh; }
    .ad-l { background: #fff; padding: 60px 50px; display: flex; flex-direction: column; justify-content: center; border-radius: 28px 0 0 28px; }
    .ad-r { background: #fbbf24; padding: 60px 50px; display: flex; flex-direction: column; justify-content: center; border-radius: 0 28px 28px 0; color: #422006; }
    .ad-l h1 { font-size: clamp(2rem, 4vw, 3rem); margin: 12px 0 14px; }
    .ad-l h1 em { color: #d97706; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .ad-l p { color: var(--muted); font-size: 1rem; line-height: 1.65; }
    .ad-l .tag { font-size:.72rem; font-weight:700; color:#92400e; background:#fef3c7; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .ad-r h2 { color: #422006; font-size: 1.6rem; margin: 0 0 24px; }
    .ad-r ul { list-style: none; padding: 0; margin: 0; display: grid; gap: 12px; }
    .ad-r li { display: flex; gap: 12px; font-size: .96rem; }
    .ad-r li strong { color: #422006; }
    .ad-r li::before { content: "→"; color: #b45309; flex-shrink: 0; font-weight: 700; }
    .ad-bottom { padding: 70px 0; background: #fff; }
    .ad-bottom .row { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
    .ad-bottom figure { aspect-ratio: 5/4; border-radius: 18px; overflow: hidden; }
    .ad-bottom figure img { width: 100%; height: 100%; object-fit: cover; }
    .ad-bottom h2 { margin: 0 0 14px; }
    .ad-bottom p { color: var(--muted); line-height: 1.65; }
    @media (max-width: 880px) { .ad-grid { grid-template-columns: 1fr; } .ad-l, .ad-r { border-radius: 28px; padding: 40px 28px; margin-bottom: 14px; } .ad-bottom .row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ad">
    <div class="container">
      <div class="ad-grid">
        <div class="ad-l">
          <span class="tag">AI admin · in your inbox</span>
          <h1>Hire a chief-of-staff for the price of a <em>SaaS seat.</em></h1>
          <p>Your inbox eats two hours a day. Your calendar fragments your focus. Receipts pile up. Meeting notes get lost. We deploy an AI assistant inside your existing tools — Gmail, Slack, Calendar — that handles the small things so you can ignore them with a clear conscience.</p>
          <p style="margin-top: 24px;">
            @auth
              <a href="{{ route('contact') }}?service=ai-admin-assistant" class="btn btn-primary">Set it up →</a>
            @else
              <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
            @endauth
          </p>
        </div>
        <div class="ad-r">
          <h2>What it handles, week one.</h2>
          <ul>
            <li><span><strong>Inbox triage.</strong> Drafts replies, flags VIPs, archives newsletters.</span></li>
            <li><span><strong>Scheduling.</strong> Reads context, proposes times, books — in your voice.</span></li>
            <li><span><strong>Meeting notes.</strong> Joins calls, summarizes, posts action items to Slack.</span></li>
            <li><span><strong>Expense filing.</strong> Pulls receipts from Gmail, categorizes, exports to QuickBooks.</span></li>
            <li><span><strong>Follow-through.</strong> Nudges you on commitments you made on calls.</span></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="ad-bottom">
    <div class="container">
      <div class="row">
        <figure><img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=1200&q=80&auto=format&fit=crop" alt="Admin workspace with notes and devices"></figure>
        <div>
          <h2>Built around your specific job.</h2>
          <p>We start with a one-hour audit of your week — Calendar exports, inbox patterns, the recurring tasks that drain you. Then we configure the assistant to that exact workflow. No generic templates. Two-week setup, then we're hands-off.</p>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
