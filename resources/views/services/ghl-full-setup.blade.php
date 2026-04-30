@extends('layouts.app')
@section('title', 'GoHighLevel Full Setup — Digirisers')
@section('description', 'A full GoHighLevel deployment — pipelines, automations, calendars, forms, payment workflows, and AI bots configured to your exact business model.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    .gh { padding: 90px 0; background: linear-gradient(180deg, #fff 0%, #fff7ed 100%); }
    .gh-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 50px; align-items: center; }
    .gh h1 { font-size: clamp(2.2rem, 4.4vw, 3.2rem); margin: 14px 0 16px; }
    .gh h1 em { color: #ea580c; font-family: var(--font-serif); font-style: italic; font-weight: 400; }
    .gh .tag { font-size:.74rem; font-weight:700; color:#9a3412; background:#ffedd5; padding:6px 12px; border-radius:999px; letter-spacing:.12em; text-transform:uppercase; }
    .gh .lede { color: var(--muted); font-size: 1.05rem; line-height: 1.65; max-width: 480px; }
    .gh figure { aspect-ratio: 4/3; border-radius: 22px; overflow: hidden; box-shadow: 0 40px 80px -40px rgba(11,16,32,.4); }
    .gh figure img { width: 100%; height: 100%; object-fit: cover; }
    .gh-deliv { padding: 80px 0; }
    .gh-deliv h2 { text-align: center; max-width: 600px; margin: 0 auto 44px; }
    .gh-modules { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; max-width: 920px; margin: 0 auto; }
    .gh-mod { padding: 28px; background: #fff; border: 1px solid #fed7aa; border-radius: 16px; transition: transform .25s ease, border-color .25s ease; }
    .gh-mod:hover { transform: translateX(4px); border-color: #ea580c; }
    .gh-mod h3 { font-size: 1.05rem; margin: 0 0 10px; display: flex; align-items: center; gap: 10px; }
    .gh-mod .icon { width: 36px; height: 36px; border-radius: 10px; background: #fff7ed; color: #ea580c; display: grid; place-items: center; }
    .gh-mod p { color: var(--muted); margin: 0; font-size: .92rem; line-height: 1.55; }
    @media (max-width: 880px) { .gh-grid, .gh-modules { grid-template-columns: 1fr; } }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <section class="container gh">
    <div class="gh-grid">
      <div>
        <span class="tag">GoHighLevel · full setup</span>
        <h1>The CRM that runs your <em>entire</em> agency.</h1>
        <p class="lede">GoHighLevel does the work of HubSpot + Calendly + ConvertKit + a handful of Zapier zaps — but only if you set it up correctly. Most agency teams use 30% of the platform. We configure the other 70% so it actually replaces the tools you're paying for elsewhere.</p>
        <p style="margin-top:24px;">
          @auth
            <a href="{{ route('contact') }}?service=ghl-full-setup" class="btn btn-primary">Plan the buildout →</a>
          @else
            <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="btn btn-primary">Sign in to view pricing</a>
          @endauth
        </p>
      </div>
      <figure><img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200&q=80&auto=format&fit=crop" alt="Marketing dashboard"></figure>
    </div>
  </section>

  <section class="gh-deliv">
    <div class="container">
      <h2>The eight modules we configure end-to-end.</h2>
      <div class="gh-modules">
        <div class="gh-mod"><h3><span class="icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12c0-4.418-4.03-8-9-8s-9 3.582-9 8 4.03 8 9 8c1.5 0 2.91-.32 4.16-.89L21 21l-1.5-3.94"/></svg></span>Pipelines + opportunities</h3><p>Custom pipelines per service line. Stages mapped to real sales activities. Win-rate tracking and stage-conversion reporting on day one.</p></div>
        <div class="gh-mod"><h3><span class="icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></span>Calendars + booking</h3><p>Round-robin or owner-routed bookings, buffer time, qualifier questions, automatic Zoom links, post-booking confirmation flows.</p></div>
        <div class="gh-mod"><h3><span class="icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 8h20M6 12h4"/></svg></span>Forms + surveys</h3><p>Branded forms with conditional logic, file uploads, payment-on-submit, and downstream automations triggered per response path.</p></div>
        <div class="gh-mod"><h3><span class="icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></span>Workflow automations</h3><p>15-30 workflows covering nurture, reactivation, payment failure, review requests, and sales follow-up. Pre-tested before going live.</p></div>
        <div class="gh-mod"><h3><span class="icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 4 12 14.01l-3-3"/><path d="M22 12V4H14"/></svg></span>Email + SMS sequences</h3><p>Pre-built sequences for onboarding, churn-risk, post-purchase, and reactivation. Voice-matched to your brand. Compliance-aware.</p></div>
        <div class="gh-mod"><h3><span class="icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg></span>Membership + payments</h3><p>Stripe integration, recurring billing, dunning flows for failed payments, content drip for paid memberships and courses.</p></div>
        <div class="gh-mod"><h3><span class="icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>Sites + funnels</h3><p>Booking funnels, lead-magnet pages, members-only portals — built within HighLevel so they share data with the CRM natively.</p></div>
        <div class="gh-mod"><h3><span class="icon"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 2 7l10 5 10-5z"/><path d="M2 17l10 5 10-5"/></svg></span>Reporting dashboard</h3><p>One owner dashboard showing leads, opportunities, revenue, and team activity. No 14-tab spelunking required.</p></div>
      </div>
    </div>
  </section>

  @include('partials.footer')
@endsection
