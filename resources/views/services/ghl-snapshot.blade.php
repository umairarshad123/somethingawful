@extends('layouts.app')
@section('title', 'GHL Snapshot Customization — Digirisers')
@section('description', 'Already running on a HighLevel snapshot? We tune it to your specific operations — branding, automations, copy — without rebuilding from scratch.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .sn { padding: 90px 0; }
    .sn h1 { font-size: clamp(2.2rem, 4.5vw, 3.4rem); margin: 14px 0 16px; max-width: 740px; }
    .sn h1 em { color: #db2777; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .sn .tag { font-size:.74rem; font-weight:700; color:#9d174d; background:#fdf2f8; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .sn p.lede { color: var(--muted); font-size: 1.06rem; max-width: 600px; line-height: 1.65; }
    .sn-photo { padding: 50px 0; }
    .sn-photo figure { aspect-ratio: 5/2; max-width: 1100px; margin: 0 auto; border-radius: 22px; overflow: hidden; }
    .sn-photo img { width: 100%; height: 100%; object-fit: cover; }
    .sn-vs { padding: 60px 0; background: #fdf2f8; }
    .sn-vs h2 { text-align: center; max-width: 580px; margin: 0 auto 36px; }
    .sn-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; max-width: 880px; margin: 0 auto; }
    .sn-grid > div { padding: 28px; background: #fff; border-radius: 16px; }
    .sn-grid .stock { border: 1px solid #fbcfe8; }
    .sn-grid .ours { border: 1.5px solid #db2777; box-shadow: 0 30px 60px -30px rgba(219,39,119,.3); }
    .sn-grid h3 { font-size: 1.05rem; margin: 0 0 12px; }
    .sn-grid ul { list-style: none; padding: 0; margin: 0; display: grid; gap: 10px; }
    .sn-grid li { font-size: .92rem; color: var(--muted); padding-left: 22px; position: relative; line-height: 1.55; }
    .sn-grid .stock li::before { content: "—"; position: absolute; left: 0; color: #94a3b8; }
    .sn-grid .ours li::before { content: "✓"; position: absolute; left: 0; color: #db2777; font-weight: 700; }
    @media (max-width: 720px) { .sn-grid { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container sn">
    <span class="tag">GHL · snapshot tuning</span>
    <h1 style="margin-top:14px;">Stock snapshots are <em>good</em>. Tuned snapshots <em>convert</em>.</h1>
    <p class="lede">Most snapshots you can buy are built for "an agency" — generic copy, generic pipelines, generic automations. We take what you already have and tune the 30+ touchpoints that should reflect your actual brand, your real client journey, and your specific service line.</p>
    <p style="margin-top:22px;">
      @auth
        <a href="{{ route('contact') }}?service=ghl-snapshot" class="btn btn-primary">Send us your snapshot →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth
    </p>
  </section>

  <section class="sn-photo">
    <figure><img src="https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?w=1600&q=80&auto=format&fit=crop" alt="Workflow snapshot interface"></figure>
  </section>

  <section class="sn-vs">
    <div class="container">
      <h2>Stock snapshot vs. tuned snapshot.</h2>
      <div class="sn-grid">
        <div class="stock">
          <h3>Out of the box</h3>
          <ul>
            <li>"Hi @{{first_name}}, thanks for booking" emails</li>
            <li>Generic 5-stage sales pipeline</li>
            <li>Calendar with no qualifier questions</li>
            <li>Trigger names like "New Lead Workflow 2"</li>
            <li>Branded "powered by HighLevel" footer</li>
          </ul>
        </div>
        <div class="ours">
          <h3>After we're done</h3>
          <ul>
            <li>Voice-matched copy specific to your industry</li>
            <li>Pipeline stages that mirror your real sales motion</li>
            <li>Pre-call qualifiers that filter out tire-kickers</li>
            <li>Workflows named in plain language by purpose</li>
            <li>White-labeled with your brand and domain throughout</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
