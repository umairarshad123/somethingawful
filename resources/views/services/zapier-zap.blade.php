@extends('layouts.app')
@section('title', 'Zapier Automation (per Zap) — Digirisers')
@section('description', 'Custom Zapier zaps built and tested for your specific workflow. Multi-step, conditional, retry-aware — the kind that doesn\'t silently break in week three.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .zp { padding: 90px 0; }
    .zp h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; max-width: 760px; }
    .zp h1 em { color: #ea580c; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .zp .tag { font-size:.74rem; font-weight:700; color:#7c2d12; background:#ffedd5; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .zp .lede { color: var(--muted); font-size: 1.06rem; max-width: 600px; line-height: 1.65; margin: 0 0 24px; }
    .zp-board { padding: 50px 0; }
    .zp-board figure { aspect-ratio: 16/9; max-width: 1100px; margin: 0 auto; border-radius: 22px; overflow: hidden; }
    .zp-board img { width: 100%; height: 100%; object-fit: cover; }
    .zp-list { padding: 60px 0; background: #fff7ed; }
    .zp-list h2 { text-align: center; max-width: 600px; margin: 0 auto 36px; }
    .zp-cells { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; max-width: 920px; margin: 0 auto; }
    .zp-cell { padding: 22px; background: #fff; border: 1px solid #fed7aa; border-radius: 12px; }
    .zp-cell strong { display: block; color: #c2410c; font-size: .82rem; letter-spacing: .12em; text-transform: uppercase; font-family: var(--font-mono); margin-bottom: 8px; }
    .zp-cell h3 { font-size: 1rem; margin: 0 0 6px; }
    .zp-cell p { color: var(--muted); font-size: .9rem; margin: 0; line-height: 1.55; }
    @media (max-width: 720px) { .zp-cells { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container zp">
    <span class="tag">Zapier · per zap</span>
    <h1 style="margin-top:14px;">Zaps that don't break in <em>week three</em>.</h1>
    <p class="lede">Anyone can drag two boxes together in Zapier. The hard part is what happens when the upstream API rate-limits, the field shape changes, or a record violates your assumptions. We build zaps that handle the failure cases — with logging, alerts, and recovery — so they keep running after you forget about them.</p>
    @auth
      <a href="{{ route('contact') }}?service=zapier-zap" class="btn btn-primary">Spec your zap →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="zp-board">
    <figure><img src="https://images.unsplash.com/photo-1496449903678-68ddcb189a24?w=1800&q=80&auto=format&fit=crop" alt="Workflow boards"></figure>
  </section>

  <section class="zp-list">
    <div class="container">
      <h2>What "production-ready" means in our zaps.</h2>
      <div class="zp-cells">
        <div class="zp-cell"><strong>RELIABILITY</strong><h3>Conditional logic, not just trigger → action</h3><p>Filters, paths, formatters. The zap branches based on real data, not hopes.</p></div>
        <div class="zp-cell"><strong>RECOVERY</strong><h3>Retry + dead-letter queue</h3><p>Transient failures retry. Permanent failures land in a Slack alert with full payload — not silently lost.</p></div>
        <div class="zp-cell"><strong>VISIBILITY</strong><h3>Logged to a Sheet you control</h3><p>Every run logs trigger, transform, output, status. You can audit any record's path without spelunking Zapier's task history.</p></div>
        <div class="zp-cell"><strong>OBSERVABILITY</strong><h3>Slack alert on anomaly</h3><p>If success rate drops below 95% in any 24h window, you get a ping in Slack with the failing payload pattern.</p></div>
        <div class="zp-cell"><strong>DOCUMENTATION</strong><h3>Runbook handoff</h3><p>You get a written one-pager: what the zap does, what triggers it, what to do when it breaks. So your team doesn't need us to maintain it.</p></div>
        <div class="zp-cell"><strong>VOLUME</strong><h3>Tier-aware</h3><p>If your task volume forecasts above 100k/month, we redesign — moving heavy lifting to n8n or a serverless function and using Zapier only at the edges.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
