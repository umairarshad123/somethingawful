@extends('layouts.app')
@section('title', 'API Security Hardening — Digirisers')
@section('description', 'API security hardening — auth, rate limiting, schema validation, and the OWASP API Top 10 audited and fixed across your endpoints.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ap-h { background: #0a0a0a; color: #fff; padding: 100px 0; min-height: 90vh; position: relative; overflow: hidden; }
    .ap-h::after { content: ""; position: absolute; bottom: -40%; right: -10%; width: 700px; height: 700px; background: radial-gradient(circle, rgba(239,68,68,.15), transparent 65%); }
    .ap-h .container { position: relative; max-width: 1100px; }
    .ap-h h1 { color: #fff; font-size: clamp(2.2rem, 4.4vw, 3.4rem); margin: 14px 0 18px; max-width: 740px; }
    .ap-h h1 em { color: #f87171; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .ap-h .tag { font-size:.72rem; font-weight:700; color:#f87171; background:rgba(239,68,68,.1); padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; border:1px solid rgba(239,68,68,.25); }
    .ap-h p.lede { color: #d4d4d8; font-size: 1.06rem; line-height: 1.65; max-width: 600px; margin: 0 0 28px; }
    .ap-owasp { padding: 50px 0 0; }
    .ap-owasp h2 { color: #fff; margin: 0 0 22px; font-size: 1.4rem; }
    .ap-owasp .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; max-width: 920px; }
    .ap-owasp .row { display: grid; grid-template-columns: 80px 1fr 80px; gap: 14px; padding: 14px 18px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 10px; align-items: center; }
    .ap-owasp .row strong { color: #f87171; font-family: var(--font-mono); font-size: .8rem; }
    .ap-owasp .row span { color: #d4d4d8; font-size: .88rem; }
    .ap-owasp .row .st { font-family: var(--font-mono); font-size: .72rem; padding: 3px 8px; border-radius: 6px; text-align: center; font-weight: 700; }
    .ap-owasp .row .st.fix { background: rgba(34,197,94,.15); color: #4ade80; }
    @media (max-width: 880px) { .ap-owasp .grid { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ap-h">
    <div class="container">
      <span class="tag">API security · hardening</span>
      <h1>The endpoints scanners <em>love</em> to find. We patch them first.</h1>
      <p class="lede">Most APIs ship with at least three of the OWASP API Top 10 vulnerabilities. We audit your endpoints, write the missing auth checks, add rate limiting, validate every request payload against a schema, and document the result so the next developer can read it.</p>
      @auth
        <a href="{{ route('contact') }}?service=api-security" class="btn btn-primary">Audit the API →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth

      <div class="ap-owasp">
        <h2>Coverage of OWASP API Top 10 (2023).</h2>
        <div class="grid">
          <div class="row"><strong>API1</strong><span>Broken Object Level Auth</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API2</strong><span>Broken Authentication</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API3</strong><span>Broken Property Level Auth</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API4</strong><span>Unrestricted Resource Consumption</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API5</strong><span>Broken Function Level Auth</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API6</strong><span>Unrestricted Sensitive Flows</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API7</strong><span>SSRF</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API8</strong><span>Security Misconfiguration</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API9</strong><span>Improper Inventory Management</span><span class="st fix">FIXED</span></div>
          <div class="row"><strong>API10</strong><span>Unsafe Consumption of APIs</span><span class="st fix">FIXED</span></div>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
