@extends('layouts.app')
@section('title', 'AI Search Optimization — Digirisers')
@section('description', 'AEO is the new SEO. We optimize your site so ChatGPT, Gemini, Perplexity, and Grok cite you when answering buyer questions in your category.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .ae { padding: 90px 0; max-width: 880px; margin: 0 auto; text-align: center; }
    .ae .tag { display:inline-block; font-size:.74rem; font-weight:700; color:#7c3aed; background:#ede9fe; padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .ae h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 18px 0 18px; }
    .ae h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; background:linear-gradient(135deg,#7c3aed,#ec4899); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .ae p { color: var(--muted); font-size: 1.1rem; max-width: 620px; margin: 0 auto 28px; line-height: 1.65; }
    .ae-photo { padding: 0 0 70px; }
    .ae-photo figure { max-width: 1100px; margin: 0 auto; aspect-ratio: 16/8; border-radius: 26px; overflow: hidden; }
    .ae-photo img { width: 100%; height: 100%; object-fit: cover; }
    .ae-vs { padding: 80px 0; background: #f5f3ff; }
    .ae-vs h2 { text-align: center; max-width: 600px; margin: 0 auto 40px; }
    .ae-cmp { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; max-width: 920px; margin: 0 auto; }
    .ae-cmp > div { padding: 28px; border-radius: 18px; }
    .ae-cmp .old { background: #fef2f2; border: 1px solid #fecaca; }
    .ae-cmp .new { background: #f0fdf4; border: 1px solid #bbf7d0; }
    .ae-cmp h3 { font-size: 1.05rem; margin: 0 0 12px; }
    .ae-cmp ul { list-style: none; padding: 0; margin: 0; display: grid; gap: 10px; }
    .ae-cmp li { font-size: .92rem; color: var(--muted); padding-left: 22px; position: relative; line-height: 1.55; }
    .ae-cmp .old li::before { content: "✗"; position: absolute; left: 0; color: #b91c1c; font-weight: 700; }
    .ae-cmp .new li::before { content: "✓"; position: absolute; left: 0; color: #15803d; font-weight: 700; }
    @media (max-width: 720px) { .ae-cmp { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="ae">
    <span class="tag">AEO · ChatGPT / Gemini / Grok</span>
    <h1>Get cited when AI <em>answers</em> the question.</h1>
    <p>40% of high-intent queries now happen inside ChatGPT, Perplexity, Gemini, or AI Overviews — never reaching Google's traditional results. If those answers don't cite you, your visibility erodes whether your "rankings" look healthy or not. We tune your content for AI retrieval, not just blue links.</p>
    @auth
      <a href="{{ route('contact') }}?service=aeo-optimization" class="btn btn-primary">Audit your AI visibility →</a>
    @else
      <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
    @endauth
  </section>

  <section class="ae-photo">
    <figure><img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=1800&q=80&auto=format&fit=crop" alt="AI conversation interface"></figure>
  </section>

  <section class="ae-vs">
    <div class="container">
      <h2>SEO content vs. AEO content.</h2>
      <div class="ae-cmp">
        <div class="old">
          <h3>Traditional SEO content</h3>
          <ul>
            <li>Long, keyword-stuffed</li>
            <li>Buries the answer in the third paragraph</li>
            <li>Optimized for ranking position #1</li>
            <li>Wins by content length</li>
            <li>Ignores how LLMs chunk + retrieve</li>
          </ul>
        </div>
        <div class="new">
          <h3>AEO-optimized content</h3>
          <ul>
            <li>Direct, answer-first</li>
            <li>Question → 40-word definitive answer → context</li>
            <li>Optimized for citation in AI responses</li>
            <li>Wins by clarity + extractability</li>
            <li>Structured for vector retrieval (clean H2s, schema)</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
