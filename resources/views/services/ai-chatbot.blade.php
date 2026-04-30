@extends('layouts.app')
@section('title', 'AI Web Chatbot / Knowledge Base — Digirisers')
@section('description', 'A grounded AI chatbot trained on your real documentation, deployed to your site, that refuses to answer questions it doesn\'t know.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .cb { background: #0a0a0a; color: #fff; }
    .cb-hero { padding: 100px 0 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; min-height: 70vh; }
    .cb-hero h1 { color: #fff; font-size: clamp(2.2rem, 4.5vw, 3.4rem); margin: 14px 0 18px; line-height: 1.05; }
    .cb-hero h1 em { color: #34d399; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .cb-hero p { color: rgba(255,255,255,.72); font-size: 1.06rem; line-height: 1.65; max-width: 480px; }
    .cb-tag { display: inline-flex; align-items: center; gap: 8px; font-size: .74rem; font-weight: 700; color: #34d399; letter-spacing: .12em; text-transform: uppercase; }
    .cb-tag::before { content: ""; width: 8px; height: 8px; border-radius: 50%; background: #34d399; box-shadow: 0 0 12px #34d399; animation: cb-pulse 2s infinite; }
    @keyframes cb-pulse { 50% { opacity: .4; } }
    .cb-bubble { background: linear-gradient(180deg, #18181b 0%, #0a0a0a 100%); border: 1px solid rgba(52,211,153,.2); border-radius: 22px; padding: 26px; }
    .cb-msg { padding: 10px 14px; margin: 8px 0; border-radius: 14px; font-size: .9rem; line-height: 1.5; }
    .cb-msg.user { background: #34d399; color: #0a0a0a; max-width: 80%; margin-left: auto; }
    .cb-msg.bot { background: #18181b; color: #d4d4d8; max-width: 90%; border: 1px solid #27272a; }
    .cb-msg.bot strong { color: #34d399; }
    .cb-row { padding: 70px 0; background: #fafafa; color: var(--ink); }
    .cb-row h2 { text-align: center; max-width: 600px; margin: 0 auto 30px; }
    .cb-row .sub { text-align: center; max-width: 580px; margin: 0 auto 44px; color: var(--muted); font-size: 1rem; line-height: 1.6; }
    .cb-strip { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    .cb-strip div { padding: 22px; background: #fff; border-radius: 14px; border: 1px solid #e4e4e7; }
    .cb-strip h3 { font-size: 1rem; margin: 0 0 6px; }
    .cb-strip p { font-size: .88rem; color: var(--muted); margin: 0; }
    @media (max-width: 880px) { .cb-hero { grid-template-columns: 1fr; padding-top: 60px; } .cb-strip { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <main class="cb">
    <section class="container cb-hero">
      <div>
        <span class="cb-tag">AI Chatbot · grounded</span>
        <h1>An assistant that <em>refuses</em> to make things up.</h1>
        <p>Generic chatbots hallucinate confidently. Ours is wired to your docs, your help center, and your past tickets — and it tells the user "I don't know — let me get a human" when the right answer isn't in scope. Honesty as a feature.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=ai-chatbot" class="btn btn-primary">Build your bot →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <div class="cb-bubble">
        <div class="cb-msg user">Do you ship internationally?</div>
        <div class="cb-msg bot"><strong>Yes</strong> — we ship to 47 countries. Standard delivery is 7–10 business days. From the <em>Shipping</em> doc you provided.</div>
        <div class="cb-msg user">What about Vietnam?</div>
        <div class="cb-msg bot">I don't have shipping info for Vietnam in our docs. Connecting you to a human now — they'll reply within 4 hours.</div>
      </div>
    </section>

    <section class="cb-row">
      <div class="container">
        <h2>What we wire up.</h2>
        <p class="sub">A grounded RAG pipeline, your existing knowledge sources, and an escalation path that hands off to humans cleanly.</p>
        <div class="cb-strip">
          <div><h3>Document ingestion</h3><p>Your help center, internal wiki, PDFs, past Zendesk tickets — chunked and indexed weekly.</p></div>
          <div><h3>Grounded retrieval</h3><p>Every answer cites the source doc. No source = no answer = handoff to support.</p></div>
          <div><h3>Site widget + Slack</h3><p>Embedded in your site or as a Slack bot for internal teams. Same brain, two faces.</p></div>
        </div>
      </div>
    </section>
  </main>

  @include('partials.footer')
@endsection
