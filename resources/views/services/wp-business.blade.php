@extends('layouts.app')

@section('title', 'WordPress Business Site — Digirisers')
@section('description', '5–7 page Elementor business sites tuned for inbound leads — clear positioning, fast load times, and the editor your team can actually maintain.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .biz { background: #fafbfc; }
    .biz-hero { padding: 90px 0 70px; display: grid; grid-template-columns: 1fr 1.1fr; gap: 64px; align-items: center; }
    .biz-hero .copy { order: 1; }
    .biz-hero figure { order: 2; position: relative; border-radius: 28px; overflow: hidden; aspect-ratio: 5/4; box-shadow: 0 60px 110px -50px rgba(11,16,32,.5); }
    .biz-hero figure img { width: 100%; height: 100%; object-fit: cover; }
    .biz-hero figure::before { content: ""; position: absolute; inset: 0; background: linear-gradient(45deg, rgba(20,184,166,.15) 0%, transparent 50%); z-index: 1; }
    .biz-eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: .76rem; font-weight: 700; color: #0d9488; letter-spacing: .1em; text-transform: uppercase; margin-bottom: 16px; }
    .biz-eyebrow::before { content: ""; width: 24px; height: 1.5px; background: #0d9488; }
    .biz-hero h1 { font-size: clamp(2.2rem, 4.4vw, 3.4rem); margin: 0 0 18px; line-height: 1.05; }
    .biz-hero h1 em { color: #0d9488; font-family: var(--font-serif); font-weight: 400; font-style: italic; }
    .biz-hero p { font-size: 1.05rem; color: var(--muted); line-height: 1.65; max-width: 520px; margin: 0 0 22px; }
    .biz-steps { background: #fff; padding: 90px 0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
    .biz-steps h2 { text-align: center; max-width: 640px; margin: 0 auto 50px; }
    .biz-steps ol { list-style: none; counter-reset: step; padding: 0; margin: 0; display: grid; gap: 22px; max-width: 760px; margin: 0 auto; }
    .biz-steps li { counter-increment: step; display: grid; grid-template-columns: 64px 1fr; gap: 22px; align-items: start; padding: 22px; background: #f0fdfa; border-radius: 16px; border: 1px solid #ccfbf1; }
    .biz-steps li::before { content: counter(step, decimal-leading-zero); display: grid; place-items: center; width: 48px; height: 48px; background: #0d9488; color: #fff; border-radius: 12px; font-weight: 700; font-size: 1.05rem; }
    .biz-steps h3 { font-size: 1.05rem; margin: 0 0 6px; }
    .biz-steps p { color: var(--muted); font-size: .94rem; margin: 0; line-height: 1.6; }
    .biz-cta { background: #0d9488; color: #fff; padding: 80px 0; text-align: center; }
    .biz-cta h2 { color: #fff; margin: 0 0 12px; }
    .biz-cta p { color: rgba(255,255,255,.85); max-width: 520px; margin: 0 auto 26px; }
    @media (max-width: 880px) { .biz-hero { grid-template-columns: 1fr; padding-top: 50px; } .biz-hero .copy { order: 2; } .biz-hero figure { order: 1; aspect-ratio: 4/3; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <main class="biz">
    <div class="container biz-hero">
      <div class="copy">
        <span class="biz-eyebrow">Elementor business site</span>
        <h1>The website your <em>sales team</em> actually wants to send.</h1>
        <p>Most agency builds optimize for visual delight. We optimize for the conversation that follows the click — clear positioning, qualifier-led copy, and a contact flow that books a call instead of disappearing into a generic inbox.</p>
        <p style="font-size:.92rem; color:var(--soft);">5 to 7 pages, Elementor-based, hand-tuned mobile. Two weeks from kickoff.</p>
        <div style="margin-top:28px;">
          @auth
            <a href="{{ route('contact') }}?service=wp-business" class="btn btn-primary">Start the build</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </div>
      </div>
      <figure><img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1400&q=80&auto=format&fit=crop" alt="Modern office workspace"></figure>
    </div>

    <section class="biz-steps">
      <div class="container">
        <h2>How it ships in two weeks.</h2>
        <ol>
          <li><div><h3>Day 1–3 · Positioning workshop</h3><p>One 90-minute session to write the headline, value props, and qualifier copy. We leave with the three sentences that drive the rest of the site.</p></div></li>
          <li><div><h3>Day 4–8 · Design + build</h3><p>Wireframes Tuesday, design Thursday, build the following Monday. You see desktop and mobile previews live as we go — no surprise reveals.</p></div></li>
          <li><div><h3>Day 9–11 · Content + polish</h3><p>You ship copy on a shared doc; we paste, format, optimize for length, and tune the line breaks so each section breathes properly on a phone.</p></div></li>
          <li><div><h3>Day 12–14 · Launch</h3><p>DNS, SSL, contact-form testing, GA4 + GTM, sitemap, schema. We hand-off a 6-page Loom showing how to update everything yourself.</p></div></li>
        </ol>
      </div>
    </section>

    <section class="biz-cta">
      <div class="container">
        <h2>Have your new site live in two weeks.</h2>
        <p>Fixed scope, fixed timeline, no monthly retainer required.</p>
        @auth
          <a href="{{ route('contact') }}?service=wp-business" class="btn btn-light">Book the kickoff →</a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-light">Create account to see pricing →</a>
        @endauth
      </div>
    </section>
  </main>

  @include('partials.footer')
@endsection
