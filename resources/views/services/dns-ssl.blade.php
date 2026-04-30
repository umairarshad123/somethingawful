@extends('layouts.app')
@section('title', 'DNS & SSL Configuration — Digirisers')
@section('description', 'DNS, SSL, and email-authentication records configured correctly the first time. Cloudflare, Route53, or your registrar — fast propagation, zero downtime.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .dn-hero { padding: 90px 0; max-width: 880px; margin: 0 auto; text-align: center; }
    .dn-hero .tag { display:inline-block; font-size:.74rem; font-weight:700; color:#1d4ed8; background:#dbeafe; padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .dn-hero h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 18px 0 18px; }
    .dn-hero h1 em { color: #1d4ed8; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .dn-hero p { color: var(--muted); font-size: 1.08rem; max-width: 600px; margin: 0 auto 26px; line-height: 1.65; }
    .dn-records { padding: 60px 0; background: #fff; }
    .dn-records h2 { max-width: 600px; margin: 0 0 30px; }
    .dn-table { background: #fafafa; border: 1px solid var(--line); border-radius: 14px; overflow: hidden; font-family: var(--font-mono); font-size: .82rem; max-width: 920px; }
    .dn-table .hd, .dn-table .row { display: grid; grid-template-columns: 80px 200px 1fr 80px; gap: 14px; padding: 12px 18px; align-items: center; }
    .dn-table .hd { background: var(--ink); color: #fff; font-weight: 700; font-size: .76rem; letter-spacing: .08em; text-transform: uppercase; }
    .dn-table .row { border-top: 1px solid var(--line); }
    .dn-table .row strong { color: var(--ink); font-weight: 600; }
    .dn-table .ok { color: #16a34a; font-weight: 700; }
    @media (max-width: 720px) { .dn-table { font-size: .72rem; } .dn-table .hd, .dn-table .row { grid-template-columns: 60px 1fr 80px; } .dn-table .hd > :nth-child(3), .dn-table .row > :nth-child(3) { display: none; } }
    .dn-bar { padding: 60px 0; background: #f0f9ff; border-top: 1px solid var(--line); }
    .dn-bar h3 { text-align: center; max-width: 500px; margin: 0 auto 18px; font-size: 1.4rem; }
    .dn-bar p { text-align: center; color: var(--muted); max-width: 580px; margin: 0 auto; line-height: 1.65; }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="dn-hero">
    <span class="tag">DNS · SSL · email auth</span>
    <h1>The <em>boring</em> records that make the rest of the internet trust you.</h1>
    <p>Misconfigured DNS is the #1 cause of "the website is down but our hosting says it's up." We do the audit, the migration, and the cutover — with a written rollback plan and zero-downtime DNS propagation.</p>
    @auth
      <a href="{{ route('contact') }}?service=dns-ssl" class="btn btn-primary">Book the migration →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="container dn-records">
    <h2>What gets configured.</h2>
    <div class="dn-table">
      <div class="hd"><span>Type</span><span>Host</span><span>Value</span><span>Status</span></div>
      <div class="row"><strong>A</strong><span>@</span><span>104.21.xx.xx</span><span class="ok">OK</span></div>
      <div class="row"><strong>AAAA</strong><span>@</span><span>2606:4700:: ...</span><span class="ok">OK</span></div>
      <div class="row"><strong>CNAME</strong><span>www</span><span>example.com</span><span class="ok">OK</span></div>
      <div class="row"><strong>MX</strong><span>@</span><span>aspmx.l.google.com priority 1</span><span class="ok">OK</span></div>
      <div class="row"><strong>TXT</strong><span>@ (SPF)</span><span>v=spf1 include:_spf.google.com ~all</span><span class="ok">OK</span></div>
      <div class="row"><strong>TXT</strong><span>_dmarc</span><span>v=DMARC1; p=quarantine; rua=mailto:...</span><span class="ok">OK</span></div>
      <div class="row"><strong>TXT</strong><span>google._domainkey</span><span>v=DKIM1; k=rsa; p=MIGfMA0...</span><span class="ok">OK</span></div>
      <div class="row"><strong>SSL</strong><span>Cloudflare</span><span>Full (strict) · Auto-renew</span><span class="ok">OK</span></div>
      <div class="row"><strong>HSTS</strong><span>Headers</span><span>max-age=31536000; preload</span><span class="ok">OK</span></div>
    </div>
  </section>

  <section class="dn-bar">
    <div class="container">
      <h3>Zero-downtime cutover, every time.</h3>
      <p>Lower TTL 24h before. Audit current records. Replicate to new provider. Switch nameservers. Verify globally with a DNS propagation tool. Restore TTL. We plan it as a rollback-able operation — never as a "hopefully this works."</p>
    </div>
  </section>

  @include('partials.footer')
@endsection
