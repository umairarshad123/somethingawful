@extends('layouts.app')
@section('title', 'Programmatic SEO Build — Digirisers')
@section('description', 'A data-fed template-driven SEO build that ships 500 indexable pages in two weeks — landing every long-tail keyword in your category.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .pg { padding: 90px 0; }
    .pg-hero { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; }
    .pg h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 18px; }
    .pg h1 em { color: #ea580c; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .pg .tag { font-size:.74rem; font-weight:700; color:#9a3412; background:#ffedd5; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .pg .lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 480px; }
    .pg-code { background: #0a0a0a; border-radius: 18px; padding: 24px; font-family: var(--font-mono); font-size: .82rem; color: #e4e4e7; line-height: 1.7; overflow: hidden; }
    .pg-code .k { color: #f97316; }
    .pg-code .v { color: #84cc16; }
    .pg-code .c { color: #71717a; }
    .pg-cards { padding: 70px 0; }
    .pg-cards h2 { text-align: center; max-width: 600px; margin: 0 auto 50px; }
    .pg-vert { display: grid; grid-template-columns: 1fr; gap: 14px; max-width: 820px; margin: 0 auto; }
    .pg-step { display: grid; grid-template-columns: 80px 1fr; gap: 24px; padding: 26px 28px; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 16px; align-items: center; }
    .pg-step .n { font-family: var(--font-mono); font-size: 2.2rem; font-weight: 700; color: #ea580c; line-height: 1; }
    .pg-step h3 { font-size: 1.08rem; margin: 0 0 6px; }
    .pg-step p { color: var(--muted); margin: 0; font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .pg-hero { grid-template-columns: 1fr; } .pg-step { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container pg">
    <div class="pg-hero">
      <div>
        <span class="tag">Programmatic SEO · 500 pages</span>
        <h1>Ship <em>500 pages</em> in two weeks. All ranked, all indexed.</h1>
        <p class="lede">Programmatic SEO uses your structured data — products, locations, comparisons, "best X for Y" — and renders unique pages for every variant. Done well, it captures every long-tail search in your space. Done poorly, it gets you a manual penalty. We've shipped over 60,000 programmatic pages without a single penalty.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=programmatic-seo" class="btn btn-primary">Plan your build →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <pre class="pg-code"><span class="c">// Sample template input</span>
<span class="k">[city]</span>:        <span class="v">"Boston"</span>
<span class="k">[service]</span>:     <span class="v">"plumber"</span>
<span class="k">[neighborhoods]</span>: <span class="v">[</span><span class="v">"Back Bay"</span>, <span class="v">"Beacon Hill"</span>, <span class="v">"South End"</span><span class="v">]</span>
<span class="k">[avg_rating]</span>:  <span class="v">4.7</span>
<span class="k">[reviews_count]</span>: <span class="v">238</span>
<span class="k">[median_price]</span>: <span class="v">"$185"</span>

<span class="c">→ generates 500 pages</span>
<span class="c">→ each one unique, indexable, fast</span>
<span class="c">→ all earned organically</span></pre>
    </div>
  </section>

  <section class="pg-cards">
    <div class="container">
      <h2>How we keep it from looking like spam.</h2>
      <div class="pg-vert">
        <div class="pg-step"><span class="n">01</span><div><h3>Genuine data sources</h3><p>We don't fabricate. Pages are sourced from your real product database, your real reviews, real census data, real public APIs. Every fact is verifiable.</p></div></div>
        <div class="pg-step"><span class="n">02</span><div><h3>Variation, not just substitution</h3><p>Each page has 4-7 sections. The mix and order vary by intent. Two pages targeting similar queries don't read like Mad Libs of each other.</p></div></div>
        <div class="pg-step"><span class="n">03</span><div><h3>Internal linking topology</h3><p>Every page links to 3-5 related pages by relevance, not template. Search engines see a real graph, not an isolated tile farm.</p></div></div>
        <div class="pg-step"><span class="n">04</span><div><h3>Fast, semantic, accessible</h3><p>Static rendering or ISR. Lighthouse 95+ across the board. Real schema. Each page passes a strict QA gate before it goes live.</p></div></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
