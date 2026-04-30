@extends('layouts.app')
@section('title', 'Social Media Management — Digirisers')
@section('description', 'Monthly social media management — content, posting cadence, community engagement, and analytics — handled by a senior strategist per platform.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .sm { padding: 90px 0; background: linear-gradient(180deg, #fff 0%, #fdf2f8 100%); }
    .sm-hero { text-align: center; max-width: 820px; margin: 0 auto; }
    .sm h1 { font-size: clamp(2.4rem, 5vw, 3.6rem); margin: 18px 0 18px; }
    .sm h1 em { font-family: var(--font-serif); font-style: italic; font-weight: 400; background: linear-gradient(135deg,#ec4899,#f59e0b); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .sm .tag { display:inline-block; font-size:.74rem; font-weight:700; color:#9d174d; background:#fce7f3; padding:7px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .sm p.lede { color: var(--muted); font-size: 1.08rem; max-width: 620px; margin: 0 auto 28px; line-height: 1.65; }
    .sm-feed { padding: 60px 0; }
    .sm-feed .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; max-width: 1100px; margin: 0 auto; }
    .sm-feed figure { aspect-ratio: 1; border-radius: 16px; overflow: hidden; }
    .sm-feed img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s ease; }
    .sm-feed figure:hover img { transform: scale(1.06); }
    .sm-list { padding: 70px 0; background: #fff; border-top: 1px solid var(--line); }
    .sm-list h2 { text-align: center; max-width: 600px; margin: 0 auto 36px; }
    .sm-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; max-width: 920px; margin: 0 auto; }
    .sm-row > div { padding: 26px; background: #fdf2f8; border-radius: 14px; border: 1px solid #fbcfe8; }
    .sm-row h3 { color: #be185d; font-size: 1.05rem; margin: 0 0 8px; }
    .sm-row p { color: var(--muted); font-size: .92rem; margin: 0; line-height: 1.55; }
    @media (max-width: 880px) { .sm-feed .grid { grid-template-columns: 1fr 1fr; } .sm-row { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="sm">
    <div class="container sm-hero">
      <span class="tag">Social · monthly retainer</span>
      <h1>Posts that <em>sound like a person</em>, not your brand guidelines.</h1>
      <p class="lede">Most agency social is the audience equivalent of elevator music — there, technically. We write posts that make your audience pause mid-scroll, in your founder's actual voice, posted at the cadence the algorithm rewards. One platform per retainer.</p>
      @auth
        <a href="{{ route('contact') }}?service=social-management" class="btn btn-primary">Pick a platform →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth
    </div>
  </section>

  <section class="sm-feed">
    <div class="container">
      <div class="grid">
        <figure><img src="https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=600&q=80&auto=format&fit=crop" alt="Social feed 1"></figure>
        <figure><img src="https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=600&q=80&auto=format&fit=crop" alt="Social feed 2"></figure>
        <figure><img src="https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=600&q=80&auto=format&fit=crop" alt="Social feed 3"></figure>
        <figure><img src="https://images.unsplash.com/photo-1611944212129-29977ae1398c?w=600&q=80&auto=format&fit=crop" alt="Social feed 4"></figure>
      </div>
    </div>
  </section>

  <section class="sm-list">
    <div class="container">
      <h2>What's in the monthly retainer.</h2>
      <div class="sm-row">
        <div><h3>20 posts written + scheduled</h3><p>Voice-matched to your founder. Mix of insight, story, polarizing-take, and "what we learned" formats. No "Happy Monday!" filler.</p></div>
        <div><h3>3 short-form videos</h3><p>Scripted by us, recorded by you (or your founder). One reel, one TikTok, one LinkedIn vertical. Captions, hooks, edits done.</p></div>
        <div><h3>Daily community engagement</h3><p>Replies to every comment, DMs to high-intent followers, comments on adjacent accounts in your niche. Real engagement, not bots.</p></div>
        <div><h3>Monthly performance review</h3><p>30-min call walking through what worked, what didn't, what we're testing next. Plus a 1-page written summary for your records.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
