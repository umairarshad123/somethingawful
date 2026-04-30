@extends('layouts.app')
@section('title', 'AI Data Processing Bot — Digirisers')
@section('description', 'A custom AI bot that ingests your messy spreadsheets, PDFs, and emails — and outputs clean, validated, structured data your team can actually use.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .db { padding: 100px 0; }
    .db h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); max-width: 740px; margin: 0 0 18px; }
    .db h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; color: #4f46e5; }
    .db .lede { font-size: 1.1rem; color: var(--muted); max-width: 580px; line-height: 1.65; margin: 0 0 28px; }
    .db .six { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; margin-top: 70px; }
    .db .six > div { background: #fff; border: 1px solid var(--line); padding: 22px 18px; border-radius: 14px; transition: border-color .2s ease, transform .2s ease; }
    .db .six > div:hover { border-color: #4f46e5; transform: translateY(-2px); }
    .db .six > div:nth-child(1) { grid-column: span 3; background: linear-gradient(135deg,#eef2ff,#fff); }
    .db .six > div:nth-child(2) { grid-column: span 3; background: linear-gradient(135deg,#fff,#f5f3ff); }
    .db .six > div:nth-child(n+3) { grid-column: span 2; }
    .db .six h3 { margin: 0 0 6px; font-size: 1rem; color: var(--ink); }
    .db .six p { margin: 0; color: var(--muted); font-size: .88rem; line-height: 1.55; }
    .db .six .badge { display: inline-block; font-family: var(--font-mono); font-size: .68rem; color: #4f46e5; background: #eef2ff; padding: 3px 8px; border-radius: 6px; margin-bottom: 8px; }
    .db-card { background: #fff; border: 1px solid var(--line); padding: 40px; border-radius: 22px; margin-top: 70px; display: grid; grid-template-columns: 1.2fr 1fr; gap: 36px; align-items: center; }
    .db-card figure { aspect-ratio: 4/3; border-radius: 14px; overflow: hidden; }
    .db-card figure img { width: 100%; height: 100%; object-fit: cover; }
    .db-card h2 { margin: 0 0 12px; }
    .db-card p { color: var(--muted); line-height: 1.6; }
    @media (max-width: 880px) { .db .six { grid-template-columns: 1fr 1fr; } .db .six > div { grid-column: span 1 !important; } .db-card { grid-template-columns: 1fr; padding: 28px; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container db">
    <span style="font-size:.72rem; font-weight:700; color:#4338ca; background:#eef2ff; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase;">Data processing</span>
    <h1 style="margin-top:18px;">Turn the messy stuff into <em>structured</em> data.</h1>
    <p class="lede">Invoices in PDF. Receipts in email. Spreadsheets with creative formatting. Vendor portals with no API. We build a bot that ingests all of it and writes clean rows to your database — validated, typed, and reconciled.</p>
    @auth
      <a href="{{ route('contact') }}?service=ai-data-bot" class="btn btn-primary">Show us your pile →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth

    <div class="six">
      <div><span class="badge">PARSE</span><h3>From unstructured</h3><p>OCR PDFs, parse emails, extract from screenshots, scrape closed portals — even handwritten forms with high accuracy on standard fields.</p></div>
      <div><span class="badge">VALIDATE</span><h3>To structured + verified</h3><p>Fields typed, ranges checked, duplicates flagged, anomalies surfaced. Confidence score per row so a human only checks what matters.</p></div>
      <div><span class="badge">SYNC</span><h3>To Postgres / Sheets</h3><p>Direct to your warehouse, Sheets, Airtable, or Notion.</p></div>
      <div><span class="badge">ALERT</span><h3>Slack on anomaly</h3><p>Outlier amounts, missing required fields, dupes — flagged in #data-quality.</p></div>
      <div><span class="badge">SCHEDULE</span><h3>Hourly or on-event</h3><p>Cron, webhook, or manual trigger. Logs every run with full traceability.</p></div>
    </div>

    <div class="db-card">
      <figure><img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=80&auto=format&fit=crop" alt="Data on screen"></figure>
      <div>
        <h2>Built for your specific data shape.</h2>
        <p>We start by reviewing 50 sample inputs from your real pile. We extract the schema, write the validation rules with you, and ship a bot that handles your edge cases — not a vendor's idea of them. Custom is the point.</p>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
