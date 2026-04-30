@extends('layouts.app')
@section('title', 'Technical SEO Audit — Digirisers')
@section('description', 'A technical SEO audit grounded in your actual crawl data. Prioritized issues, written explanations, and exact code-level fixes — not auto-generated nonsense.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ts { background: #f8fafc; padding: 90px 0; min-height: 90vh; }
    .ts h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 0 0 18px; max-width: 720px; }
    .ts h1 em { color: #0e7490; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .ts-tag { font-size:.74rem; font-weight:700; color:#155e75; background:#cffafe; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .ts-lede { color: var(--muted); font-size: 1.08rem; line-height: 1.65; max-width: 600px; margin: 0 0 28px; }
    .ts-bg { display: grid; grid-template-columns: 1.4fr 1fr; gap: 50px; padding: 60px 0; align-items: start; margin-top: 40px; }
    .ts-issues { background: #fff; border: 1px solid var(--line); border-radius: 18px; overflow: hidden; }
    .ts-issues .hd { padding: 16px 22px; background: #0e7490; color: #fff; font-family: var(--font-mono); font-size: .82rem; letter-spacing: .08em; text-transform: uppercase; }
    .ts-issues .row { padding: 16px 22px; border-top: 1px solid var(--line); display: grid; grid-template-columns: 50px 1fr 90px; gap: 14px; align-items: center; }
    .ts-issues .row:nth-child(2) { border-top: 0; }
    .ts-issues .sev { font-family: var(--font-mono); font-size: .72rem; font-weight: 700; padding: 3px 8px; border-radius: 6px; text-align: center; }
    .ts-issues .sev.h { background: #fee2e2; color: #b91c1c; }
    .ts-issues .sev.m { background: #fef3c7; color: #b45309; }
    .ts-issues .sev.l { background: #e0f2fe; color: #075985; }
    .ts-issues .row strong { display: block; font-size: .94rem; margin-bottom: 3px; }
    .ts-issues .row small { color: var(--muted); font-size: .82rem; }
    .ts-issues .pages { font-family: var(--font-mono); font-size: .82rem; color: var(--soft); text-align: right; }
    .ts-side { display: grid; gap: 18px; }
    .ts-side > div { padding: 22px; background: #fff; border-radius: 14px; border: 1px solid var(--line); }
    .ts-side h3 { font-size: .98rem; margin: 0 0 6px; }
    .ts-side p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .ts-bg { grid-template-columns: 1fr; } .ts-issues .row { grid-template-columns: 50px 1fr; } .ts-issues .pages { display: none; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ts">
    <div class="container">
      <span class="ts-tag">Technical SEO · audit</span>
      <h1 style="margin-top:14px;">An audit that speaks <em>code</em>, not slides.</h1>
      <p class="ts-lede">Most SEO audits are PDFs full of "improve site speed" and "add alt tags." We crawl your site with Screaming Frog + a custom Python script, cross-reference Search Console + GA4, and write a fix list with exact line-level changes — not vague recommendations.</p>
      @auth
        <a href="{{ route('contact') }}?service=technical-seo" class="btn btn-primary">Run the audit →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth

      <div class="ts-bg">
        <div class="ts-issues">
          <div class="hd">/ Sample audit findings</div>
          <div class="row"><span class="sev h">HIGH</span><div><strong>Render-blocking JS in head</strong><small>2.3s TTI penalty on mobile</small></div><span class="pages">142 pages</span></div>
          <div class="row"><span class="sev h">HIGH</span><div><strong>Duplicate title tags</strong><small>Identical across paginated archives</small></div><span class="pages">387 pages</span></div>
          <div class="row"><span class="sev m">MED</span><div><strong>Missing canonical tags</strong><small>UTM-tagged URLs indexed separately</small></div><span class="pages">56 pages</span></div>
          <div class="row"><span class="sev m">MED</span><div><strong>Orphan pages</strong><small>No internal links pointing in</small></div><span class="pages">28 pages</span></div>
          <div class="row"><span class="sev l">LOW</span><div><strong>Image sizes oversized</strong><small>Avg 4.2× larger than rendered</small></div><span class="pages">~1100</span></div>
        </div>
        <div class="ts-side">
          <div><h3>Code-level fixes</h3><p>Each issue ships with a diff or pseudo-code your developer can apply directly. No "consult a developer" fluff.</p></div>
          <div><h3>Re-audit at 30 days</h3><p>We re-crawl free of charge and confirm fixes landed — and what new issues snuck in during that month.</p></div>
          <div><h3>Slack channel for questions</h3><p>For 14 days post-delivery your dev team can drop questions in a shared Slack. We respond within a business day.</p></div>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
