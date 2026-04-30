@extends('layouts.app')
@section('title', 'Predictive Automation & Personalization — Digirisers')
@section('description', 'Predictive models that score every visitor, customer, and lead in real time — then route experiences based on what they\'re actually likely to do next.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .pa { padding: 80px 0 100px; }
    .pa-hero { max-width: 880px; margin: 0 auto 64px; text-align: center; }
    .pa-tag { display:inline-block; font-size:.74rem; font-weight:700; color:#7c2d12; background:#fff7ed; padding:6px 14px; border-radius:999px; letter-spacing:.14em; text-transform:uppercase; }
    .pa-hero h1 { font-size: clamp(2.4rem, 5vw, 3.8rem); margin: 18px 0 18px; letter-spacing: -0.035em; }
    .pa-hero h1 em { color: #ea580c; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .pa-hero p { font-size: 1.12rem; color: var(--muted); max-width: 640px; margin: 0 auto 28px; line-height: 1.65; }
    .pa-photo { max-width: 1100px; margin: 0 auto 70px; aspect-ratio: 21/9; border-radius: 26px; overflow: hidden; }
    .pa-photo img { width: 100%; height: 100%; object-fit: cover; }
    .pa-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 40px; align-items: start; padding: 60px 0; border-top: 1px solid var(--line); }
    .pa-row > div { padding: 0 12px; }
    .pa-row .stat { font-size: 3rem; font-weight: 800; color: #ea580c; line-height: 1; letter-spacing: -0.03em; }
    .pa-row h3 { font-size: 1.05rem; margin: 12px 0 8px; }
    .pa-row p { color: var(--muted); font-size: .92rem; line-height: 1.6; }
    @media (max-width: 880px) { .pa-row { grid-template-columns: 1fr; gap: 30px; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <main class="container pa">
    <div class="pa-hero">
      <span class="pa-tag">Predictive · personalization</span>
      <h1>Stop showing the <em>same site</em> to everyone.</h1>
      <p>Generic personalization changes a name in an email. Real predictive personalization scores who's about to churn, who's ready to upgrade, and who's just browsing — then changes the page each visitor sees, the offer they're shown, and the email they get next.</p>
      @auth
        <a href="{{ route('contact') }}?service=predictive-automation" class="btn btn-primary">Pilot a model →</a>
      @else
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
      @endauth
    </div>

    <figure class="pa-photo"><img src="https://images.unsplash.com/photo-1535378917042-10a22c95931a?w=1800&q=80&auto=format&fit=crop" alt="Predictive analytics visualization"></figure>

    <div class="pa-row">
      <div>
        <span class="stat">3.4×</span>
        <h3>Lift on returning-visitor conversion</h3>
        <p>When pricing, social proof, and CTAs adapt to predicted intent, returning visitors convert at 3.4× the rate of the static experience. Median across 9 deployments.</p>
      </div>
      <div>
        <span class="stat">37%</span>
        <h3>Reduction in churn-flagged accounts</h3>
        <p>Customers flagged "high churn risk" who receive the predictive intervention (offer, outreach, or product nudge) churn 37% less often within 60 days.</p>
      </div>
      <div>
        <span class="stat">~2 weeks</span>
        <h3>From kickoff to live model</h3>
        <p>We start with the data you already have — orders, visits, support tickets — and ship the first model in a fortnight. No 6-month "data warehouse" prerequisite.</p>
      </div>
    </div>
  </main>

  @include('partials.footer')
@endsection
