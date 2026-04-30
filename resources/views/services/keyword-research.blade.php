@extends('layouts.app')
@section('title', 'Keyword Research & Strategy Doc — Digirisers')
@section('description', 'A keyword research deliverable that\'s actually a strategy: clusters, intent mapping, content gaps, and a 12-month publishing plan in one shared doc.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .kr { padding: 80px 0; }
    .kr h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 0 0 16px; max-width: 720px; }
    .kr h1 em { color: #0d9488; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .kr .tag { display:inline-block; font-size:.74rem; font-weight:700; color:#115e59; background:#ccfbf1; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .kr .lede { color: var(--muted); font-size: 1.06rem; line-height: 1.65; max-width: 600px; margin: 16px 0 28px; }
    .kr-cluster { padding: 70px 0; }
    .kr-cluster h2 { max-width: 580px; margin: 0 0 30px; }
    .kr-tags { display: flex; flex-wrap: wrap; gap: 8px; padding: 30px; background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 16px; margin-bottom: 22px; }
    .kr-tags .anchor { padding: 7px 14px; background: #0d9488; color: #fff; border-radius: 999px; font-size: .82rem; font-weight: 600; }
    .kr-tags .kw { padding: 6px 12px; background: #fff; border: 1px solid #99f6e4; color: #115e59; border-radius: 999px; font-size: .82rem; font-weight: 500; transition: background .2s ease; cursor: default; }
    .kr-tags .kw:hover { background: #ccfbf1; }
    .kr-tags .kw .vol { font-family: var(--font-mono); color: var(--soft); margin-left: 6px; font-size: .72rem; }
    .kr-deliv { padding: 70px 0; background: #f0fdfa; border-top: 1px solid var(--line); }
    .kr-deliv h2 { text-align: center; max-width: 600px; margin: 0 auto 36px; }
    .kr-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
    .kr-cell { padding: 24px; background: #fff; border-radius: 14px; border: 1px solid #ccfbf1; }
    .kr-cell h3 { font-size: 1rem; margin: 0 0 8px; color: #0d9488; }
    .kr-cell p { font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .kr-row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container kr">
    <span class="tag">Keyword research · doc</span>
    <h1 style="margin-top:14px;">A research doc that doubles as a <em>roadmap</em>.</h1>
    <p class="lede">A list of keywords with search volumes is a starting point, not a deliverable. We map every relevant query in your space to user intent, group them into topical clusters, and hand you a 12-month publishing schedule that builds topical authority in a specific order.</p>
    @auth
      <a href="{{ route('contact') }}?service=keyword-research" class="btn btn-primary">Brief us in →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="container kr-cluster">
    <h2>What a topical cluster looks like.</h2>
    <div class="kr-tags">
      <span class="anchor">[Anchor topic]</span>
      <span class="kw">enterprise CRM<span class="vol">· 3.6k</span></span>
      <span class="kw">CRM for B2B SaaS<span class="vol">· 1.2k</span></span>
      <span class="kw">CRM vs. spreadsheet<span class="vol">· 880</span></span>
      <span class="kw">how to migrate CRMs<span class="vol">· 720</span></span>
      <span class="kw">best CRM for outbound<span class="vol">· 590</span></span>
      <span class="kw">CRM with email automation<span class="vol">· 480</span></span>
      <span class="kw">CRM for 5-person team<span class="vol">· 320</span></span>
      <span class="kw">CRM ROI calculation<span class="vol">· 210</span></span>
      <span class="kw">CRM data hygiene<span class="vol">· 190</span></span>
    </div>
    <p style="color:var(--soft); font-size:.92rem; max-width:680px; margin:0;">One anchor pillar, eight supporting articles, internal-link topology mapped out for you. Repeat across the 6-8 clusters that matter in your category.</p>
  </section>

  <section class="kr-deliv">
    <div class="container">
      <h2>What's in the final doc.</h2>
      <div class="kr-row">
        <div class="kr-cell"><h3>1,500+ keywords</h3><p>Sourced from Ahrefs + SEMrush + Google Suggest + Reddit + Quora. De-duplicated, intent-tagged.</p></div>
        <div class="kr-cell"><h3>6-8 clusters</h3><p>Each with one pillar topic, 6-12 supporting articles, and a recommended publishing order.</p></div>
        <div class="kr-cell"><h3>12-month plan</h3><p>Month-by-month publishing schedule with primary/secondary keyword targets per piece.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
