@extends('layouts.app')
@section('title', 'Backlink Outreach — Digirisers')
@section('description', 'Earned backlinks from real publications, real journalists, real podcasts. No PBN, no link schemes, no shortcuts that get you penalized.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .bl { padding: 90px 0; }
    .bl-hero { display: grid; grid-template-columns: 1.2fr 1fr; gap: 60px; align-items: center; }
    .bl h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 16px; }
    .bl h1 em { color: #be185d; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .bl .tag { font-size:.74rem; font-weight:700; color:#9d174d; background:#fce7f3; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .bl .lede { color: var(--muted); font-size: 1.06rem; line-height: 1.65; max-width: 460px; }
    .bl-imgwrap { aspect-ratio: 4/5; border-radius: 24px; overflow: hidden; box-shadow: 0 50px 100px -40px rgba(190,24,93,.25); }
    .bl-imgwrap img { width: 100%; height: 100%; object-fit: cover; }
    .bl-strip { padding: 60px 0; border-top: 1px solid var(--line); margin-top: 70px; }
    .bl-strip h2 { text-align: center; max-width: 580px; margin: 0 auto 40px; }
    .bl-pubs { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; max-width: 1080px; margin: 0 auto; }
    .bl-pub { padding: 18px; background: #fafaf9; border: 1px solid var(--line); border-radius: 12px; text-align: center; font-size: .82rem; font-weight: 600; color: var(--ink); transition: background .2s ease, border-color .2s ease; }
    .bl-pub:hover { background: #fdf2f8; border-color: #fbcfe8; }
    .bl-pub small { display: block; font-size: .7rem; color: var(--soft); margin-top: 4px; font-family: var(--font-mono); font-weight: 500; }
    .bl-promise { padding: 70px 0; text-align: center; max-width: 700px; margin: 0 auto; }
    .bl-promise h2 { margin: 0 0 14px; font-size: clamp(1.4rem, 2.6vw, 2rem); }
    .bl-promise p { color: var(--muted); line-height: 1.65; margin: 0; }
    @media (max-width: 880px) { .bl-hero { grid-template-columns: 1fr; } .bl-pubs { grid-template-columns: repeat(2, 1fr); } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container bl">
    <div class="bl-hero">
      <div>
        <span class="tag">Outreach · earned links</span>
        <h1>Backlinks earned in <em>conversations</em>, not from a marketplace.</h1>
        <p class="lede">PBN links, paid placements, and "guest posts on a thousand sites" used to work. Now they're a fast path to a manual penalty. We do real outreach: we pitch real journalists, real podcasters, real authoritative bloggers — with angles they want to cover anyway.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=backlink-outreach" class="btn btn-primary">Plan a campaign →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <div class="bl-imgwrap"><img src="https://images.unsplash.com/photo-1558403194-611308249627?w=1200&q=80&auto=format&fit=crop" alt="Network of nodes"></figure></div>
    </div>

    <div class="bl-strip">
      <h2>Sample placements from the last 90 days.</h2>
      <div class="bl-pubs">
        <div class="bl-pub">Forbes.com<small>DA 95</small></div>
        <div class="bl-pub">Inc.com<small>DA 93</small></div>
        <div class="bl-pub">Search Engine Journal<small>DA 84</small></div>
        <div class="bl-pub">HubSpot Blog<small>DA 92</small></div>
        <div class="bl-pub">Marketing Brew<small>DA 78</small></div>
        <div class="bl-pub">Built In<small>DA 80</small></div>
      </div>
    </div>
  </section>

  <section class="bl-promise">
    <h2>What we won't do.</h2>
    <p>No PBN. No "link schemes." No paid guest posts on sites with 90% sponsored content. No comment spam. No "1,000 backlinks for $99." If we wouldn't be proud to send your CMO the screenshot of how a link was earned, we don't take the placement. Slower, but the rankings stick.</p>
  </section>

  @include('partials.footer')
@endsection
