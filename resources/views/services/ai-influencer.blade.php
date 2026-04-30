@extends('layouts.app')
@section('title', 'AI Influencer System Setup — Digirisers')
@section('description', 'A self-running AI persona that posts daily content, builds an audience, and drives traffic — designed for niches where founders won\'t go on camera.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ai-inf { background: linear-gradient(135deg, #18181b 0%, #27272a 100%); color: #fff; padding: 110px 0 80px; min-height: 90vh; position: relative; overflow: hidden; }
    .ai-inf::before { content: ""; position: absolute; top: 20%; left: -100px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(236,72,153,.18), transparent 65%); }
    .ai-inf::after { content: ""; position: absolute; bottom: 0; right: -200px; width: 700px; height: 500px; background: radial-gradient(circle, rgba(139,92,246,.18), transparent 65%); }
    .ai-inf .container { position: relative; }
    .ai-inf h1 { color: #fff; font-size: clamp(2.4rem, 5vw, 3.8rem); margin: 18px 0 18px; letter-spacing: -0.04em; }
    .ai-inf h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; background: linear-gradient(135deg,#f472b6,#a78bfa); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .ai-inf .tag { display:inline-block; font-size:.74rem; font-weight:700; color:#f472b6; background:rgba(244,114,182,.1); padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; border: 1px solid rgba(244,114,182,.25); }
    .ai-inf .lede { color: #d4d4d8; font-size: 1.1rem; max-width: 600px; line-height: 1.65; margin: 0 0 28px; }
    .ai-inf-bar { padding: 70px 0; background: #fafafa; color: var(--ink); }
    .ai-inf-bar h2 { text-align: center; max-width: 600px; margin: 0 auto 36px; }
    .ai-inf-bar .row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; max-width: 1000px; margin: 0 auto; }
    .ai-inf-bar .cell { padding: 28px; background: #fff; border: 1px solid var(--line); border-radius: 16px; }
    .ai-inf-bar .cell .step { font-family: var(--font-mono); color: #ec4899; font-size: .76rem; letter-spacing: .12em; }
    .ai-inf-bar .cell h3 { margin: 8px 0 8px; font-size: 1.05rem; }
    .ai-inf-bar .cell p { font-size: .92rem; color: var(--muted); margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .ai-inf-bar .row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ai-inf">
    <div class="container">
      <span class="tag">AI Influencer · setup</span>
      <h1>An audience that grows while you <em>sleep</em>.</h1>
      <p class="lede">Some founders should be on camera. Most shouldn't. We design and operationalize an AI persona — voice, look, opinions, posting style — that builds an audience in your niche on TikTok, Instagram, or X. Daily posts, real engagement, links to your offer.</p>
      <p>
        @auth
          <a href="{{ route('contact') }}?service=ai-influencer" class="btn btn-primary">Build the persona →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
        @endauth
      </p>
    </div>
  </section>

  <section class="ai-inf-bar">
    <div class="container">
      <h2>The four-week build.</h2>
      <div class="row">
        <div class="cell"><span class="step">WEEK 1</span><h3>Persona design</h3><p>Voice, niche, opinions, look. We document the character so every post stays consistent over time.</p></div>
        <div class="cell"><span class="step">WEEK 2</span><h3>Content engine</h3><p>50-post backlog generated. Visual templates locked. Hook-format library built. We post daily for a month from this initial batch.</p></div>
        <div class="cell"><span class="step">WEEK 3</span><h3>Engagement system</h3><p>Replies, comments, DMs handled by the persona. Sentiment-aware. Escalates to humans on real opportunities.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
