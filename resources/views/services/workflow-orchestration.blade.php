@extends('layouts.app')
@section('title', 'AI Workflow Orchestration — Digirisers')
@section('description', 'Multi-step AI workflows orchestrated in n8n or custom code — branching, retries, human-in-the-loop, and full observability included.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .wo-hero { padding: 90px 0 30px; display: grid; grid-template-columns: 1fr 1.2fr; gap: 60px; align-items: center; }
    .wo-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 16px; }
    .wo-hero h1 em { color: #6366f1; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .wo-hero p { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 480px; }
    .wo-tag { font-size:.72rem; font-weight:700; color:#4338ca; background:#eef2ff; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .wo-diag { aspect-ratio: 5/4; background: #fff; border: 1px solid var(--line); border-radius: 22px; padding: 28px; box-shadow: 0 30px 60px -30px rgba(11,16,32,.25); position: relative; }
    .wo-node { position: absolute; padding: 10px 14px; background: #eef2ff; border: 1.5px solid #6366f1; border-radius: 10px; font-size: .78rem; font-weight: 600; color: #312e81; }
    .wo-node.alt { background: #faf5ff; border-color: #a855f7; color: #581c87; }
    .wo-node.ok { background: #f0fdf4; border-color: #22c55e; color: #14532d; }
    .wo-arrow { position: absolute; height: 1.5px; background: linear-gradient(90deg, #6366f1, #a855f7); }
    .wo-final { padding: 70px 0; background: #fafafa; }
    .wo-final h2 { max-width: 580px; margin: 0 0 30px; }
    .wo-final ul { list-style: none; padding: 0; margin: 0; display: grid; gap: 12px; max-width: 720px; }
    .wo-final li { padding: 16px 22px; background: #fff; border-radius: 12px; border: 1px solid var(--line); display: grid; grid-template-columns: 24px 1fr; gap: 14px; }
    .wo-final li svg { color: #6366f1; margin-top: 2px; }
    .wo-final strong { display: block; margin-bottom: 4px; }
    .wo-final span { color: var(--muted); font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .wo-hero { grid-template-columns: 1fr; padding-top: 60px; } .wo-diag { aspect-ratio: 4/3; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container wo-hero">
    <div>
      <span class="wo-tag">Orchestration · n8n / custom</span>
      <h1>Workflows that <em>handle</em> the messy middle.</h1>
      <p>Single-prompt AI calls fall over the moment a workflow has branching, retries, human review, or rate limits. We orchestrate the whole thing — n8n if it fits, custom Node/Python if it doesn't — with proper observability, idempotency, and graceful degradation.</p>
      <p style="margin-top:24px;">
        @auth
          <a href="{{ route('contact') }}?service=workflow-orchestration" class="btn btn-primary">Map your workflow →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>
    </div>
    <div class="wo-diag" aria-hidden="true">
      <span class="wo-node" style="top:30px; left:30px;">Trigger · Form</span>
      <span class="wo-arrow" style="top:48px; left:160px; width:60px;"></span>
      <span class="wo-node" style="top:30px; left:235px;">LLM · Classify</span>
      <span class="wo-node alt" style="top:120px; left:80px;">Branch A: Auto</span>
      <span class="wo-node alt" style="top:120px; left:230px;">Branch B: Review</span>
      <span class="wo-arrow" style="top:140px; left:200px; width:30px;"></span>
      <span class="wo-node ok" style="top:210px; left:120px;">CRM · Update</span>
      <span class="wo-node ok" style="top:210px; left:260px;">Slack · Notify</span>
    </div>
  </section>

  <section class="wo-final">
    <div class="container">
      <h2>What "production-grade" means here.</h2>
      <ul>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Idempotent steps</strong><span>Reruns are safe. We design every node to handle "ran twice" gracefully — no duplicate emails, no double-charged cards.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Retry with backoff</strong><span>Transient failures retry exponentially. Permanent failures land in a dead-letter queue with a Slack alert.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Human-in-the-loop</strong><span>Confidence threshold or rule-based routing pauses the flow for review. Reviewer responses feed back into the workflow.</span></div></li>
        <li><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><div><strong>Observability</strong><span>Every run logged with full input/output trace. Filterable dashboard. We see when things break before you do.</span></div></li>
      </ul>
    </div>
  </section>

  @include('partials.footer')
@endsection
