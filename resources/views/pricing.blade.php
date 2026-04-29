@extends('layouts.app')

@section('title', 'Pricing — Digirisers')
@section('description', 'Digirisers pricing — transparent monthly retainers and one-time project rates for SEO, PPC, web design, content, and full-funnel growth.')
@section('robots', 'index,follow')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />

  <style>
    /* Pricing-specific styles — extends legal.css */

    /* Hero tweaks */
    .pricing-hero { padding: 100px 0 60px; }
    .pricing-hero-inner { max-width: 760px; text-align: center; margin: 0 auto; }
    .pricing-hero h1 { letter-spacing: -0.04em; }
    .pricing-hero p { margin-left: auto; margin-right: auto; }
    .pricing-hero .legal-meta { justify-content: center; }

    /* Billing toggle */
    .billing-toggle {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 5px; margin: 32px auto 0;
      background: #fff; border: 1px solid var(--line);
      border-radius: 999px; box-shadow: var(--shadow-xs);
    }
    .billing-toggle button {
      border: 0; background: transparent; cursor: pointer;
      padding: 9px 18px; font-family: inherit; font-size: .9rem;
      font-weight: 600; color: var(--muted); border-radius: 999px;
      transition: all .25s ease;
    }
    .billing-toggle button.active {
      background: var(--ink); color: #fff;
      box-shadow: 0 4px 12px -4px rgba(11,16,32,.4);
    }
    .billing-toggle .save {
      display: inline-block; margin-left: 6px;
      font-size: .68rem; padding: 2px 7px; border-radius: 999px;
      background: var(--blue-50); color: var(--blue-700); font-weight: 700;
    }
    .billing-toggle button.active .save { background: rgba(255,255,255,.18); color: #fff; }

    /* Pricing grid */
    .pricing-section {
      background: #fff; padding: 30px 0 100px;
    }
    .pricing-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
      max-width: 1180px; margin: 0 auto;
    }
    .plan {
      position: relative; display: flex; flex-direction: column;
      background: #fff; border: 1px solid var(--line);
      border-radius: var(--r-lg); padding: 36px 32px 32px;
      transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
    }
    .plan:hover { transform: translateY(-4px); border-color: var(--blue-300); box-shadow: var(--shadow-lg); }

    .plan.featured {
      background: linear-gradient(180deg, #f5f8ff 0%, #fff 60%);
      border-color: var(--blue-300);
      box-shadow: var(--shadow-lg);
      transform: translateY(-8px);
    }
    .plan.featured:hover { transform: translateY(-12px); }

    .plan-badge {
      position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
      background: var(--grad); color: #fff;
      font-size: .7rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .12em;
      padding: 7px 14px; border-radius: 999px;
      box-shadow: 0 8px 20px -6px rgba(37,99,235,.5);
      white-space: nowrap;
    }

    .plan-head { margin-bottom: 22px; }
    .plan-name {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: 1rem; font-weight: 700; color: var(--blue-700);
      text-transform: uppercase; letter-spacing: .12em;
      margin-bottom: 14px;
    }
    .plan-name .ic {
      width: 28px; height: 28px; border-radius: 8px;
      background: var(--blue-50); color: var(--blue-700);
      display: grid; place-items: center;
    }
    .plan.featured .plan-name { color: var(--blue-800); }
    .plan.featured .plan-name .ic { background: var(--grad); color: #fff; }

    .plan-blurb { font-size: .95rem; color: var(--soft); margin: 0 0 18px; min-height: 48px; }

    .price { display: flex; align-items: baseline; gap: 6px; margin-bottom: 6px; }
    .price-currency { font-size: 1.4rem; font-weight: 600; color: var(--ink); }
    .price-amount {
      font-size: 3.4rem; font-weight: 700; color: var(--ink);
      letter-spacing: -0.04em; line-height: 1;
    }
    .plan.featured .price-amount {
      background: var(--grad-alt);
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .price-cycle { font-size: .9rem; color: var(--soft); }
    .price-note {
      display: block; margin: 4px 0 24px;
      font-size: .8rem; color: var(--soft);
    }

    .plan-cta { margin-bottom: 24px; }
    .plan-cta .btn { width: 100%; }
    .plan-cta .btn-outline {
      background: #fff; color: var(--ink); border-color: var(--line);
    }
    .plan-cta .btn-outline:hover {
      background: var(--ink); color: #fff; border-color: var(--ink);
      transform: translateY(-2px); box-shadow: 0 12px 30px -10px rgba(11,16,32,.4);
    }

    .plan-includes {
      font-size: .72rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .12em;
      color: var(--soft); margin: 0 0 14px;
    }
    .plan-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 11px; }
    .plan-list li {
      position: relative; padding-left: 28px;
      font-size: .94rem; color: var(--ink-2); line-height: 1.5;
    }
    .plan-list li::before {
      content: "";
      position: absolute; left: 0; top: 4px;
      width: 18px; height: 18px; border-radius: 50%;
      background: var(--blue-50);
      background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232563eb' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'/></svg>");
      background-size: 11px 11px;
      background-repeat: no-repeat;
      background-position: center;
    }
    .plan-list li strong { font-weight: 600; color: var(--ink); }

    /* Enterprise band */
    .enterprise {
      max-width: 1180px; margin: 28px auto 0;
      background: var(--ink); color: #fff;
      border-radius: var(--r-lg); padding: 40px 44px;
      display: grid; grid-template-columns: 1.4fr 1fr; gap: 40px;
      align-items: center; position: relative; overflow: hidden;
      box-shadow: var(--shadow-lg);
    }
    .enterprise::before {
      content: ""; position: absolute; top: -180px; right: -120px;
      width: 480px; height: 480px; border-radius: 50%;
      background: radial-gradient(circle, rgba(59,130,246,.4) 0%, transparent 60%);
      pointer-events: none;
    }
    .enterprise-text { position: relative; z-index: 1; }
    .enterprise small {
      display: inline-block; font-size: .72rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .14em;
      color: var(--blue-300); margin-bottom: 10px;
    }
    .enterprise h3 { color: #fff; font-size: clamp(1.5rem, 2.6vw, 1.9rem); margin: 0 0 10px; }
    .enterprise p { color: rgba(255,255,255,.72); margin: 0; max-width: 540px; }
    .enterprise-cta { position: relative; z-index: 1; text-align: right; }

    /* Add-ons */
    .addons-section {
      background: var(--bg-soft);
      border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
      padding: 100px 0;
    }
    .addon-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 16px;
      margin-top: 48px;
    }
    .addon {
      background: #fff; border: 1px solid var(--line);
      border-radius: var(--r-md); padding: 26px 24px;
      transition: all .3s ease;
    }
    .addon:hover {
      border-color: var(--blue-300);
      transform: translateY(-3px);
      box-shadow: var(--shadow);
    }
    .addon-name { font-size: 1.05rem; font-weight: 600; color: var(--ink); margin: 0 0 6px; letter-spacing: -0.01em; }
    .addon-blurb { font-size: .9rem; color: var(--soft); margin: 0 0 14px; line-height: 1.5; }
    .addon-price {
      display: inline-flex; align-items: baseline; gap: 4px;
      font-size: 1.1rem; font-weight: 700; color: var(--blue-700);
      letter-spacing: -0.02em;
    }
    .addon-price small { font-size: .75rem; color: var(--soft); font-weight: 500; }

    /* Universal includes strip */
    .includes-strip {
      max-width: 1180px; margin: 80px auto 0;
      padding: 36px 40px;
      background: #fff;
      border: 1px solid var(--line); border-radius: var(--r-lg);
      display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px;
    }
    .include-item {
      display: flex; flex-direction: column; gap: 8px;
    }
    .include-icon {
      width: 36px; height: 36px; border-radius: 10px;
      background: var(--blue-50); color: var(--blue-700);
      display: grid; place-items: center;
    }
    .include-item strong { color: var(--ink); font-size: .98rem; font-weight: 600; }
    .include-item small { color: var(--soft); font-size: .85rem; line-height: 1.5; }

    /* FAQ */
    .faq-section { padding: 100px 0; background: #fff; }
    .faq-grid {
      max-width: 880px; margin: 56px auto 0;
      display: grid; gap: 12px;
    }
    .faq-item {
      background: #fff; border: 1px solid var(--line);
      border-radius: var(--r); overflow: hidden;
      transition: border-color .25s ease;
    }
    .faq-item:hover { border-color: var(--blue-200); }
    .faq-item[open] { border-color: var(--blue-300); box-shadow: var(--shadow-sm); }
    .faq-item summary {
      cursor: pointer; padding: 20px 24px;
      font-weight: 600; font-size: 1.02rem; color: var(--ink);
      list-style: none;
      display: flex; justify-content: space-between; align-items: center; gap: 16px;
    }
    .faq-item summary::-webkit-details-marker { display: none; }
    .faq-item summary::after {
      content: ""; flex-shrink: 0;
      width: 18px; height: 18px;
      background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232563eb' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>") center/contain no-repeat;
      transition: transform .3s ease;
    }
    .faq-item[open] summary::after { transform: rotate(180deg); }
    .faq-item p {
      margin: 0; padding: 0 24px 22px; color: var(--muted);
      font-size: .96rem; line-height: 1.65;
    }

    /* CTA band */
    .cta-band {
      padding: 0 0 120px; background: #fff;
    }
    .cta-card {
      max-width: 1180px; margin: 0 auto;
      background: var(--grad); color: #fff;
      border-radius: var(--r-lg); padding: 60px;
      display: grid; grid-template-columns: 1.4fr 1fr; gap: 40px; align-items: center;
      box-shadow: var(--shadow-lg);
      position: relative; overflow: hidden;
    }
    .cta-card::before {
      content: ""; position: absolute; inset: 0;
      background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.18) 0%, transparent 50%);
      pointer-events: none;
    }
    .cta-card h2 { color: #fff; font-size: clamp(1.8rem, 3vw, 2.4rem); margin: 0 0 12px; letter-spacing: -0.025em; }
    .cta-card p { margin: 0; color: rgba(255,255,255,.85); font-size: 1.05rem; max-width: 520px; }
    .cta-actions { display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap; position: relative; z-index: 1; }

    /* Responsive */
    @media (max-width: 980px) {
      .pricing-grid { grid-template-columns: 1fr; max-width: 480px; }
      .plan.featured { transform: none; }
      .plan.featured:hover { transform: translateY(-4px); }
      .enterprise { grid-template-columns: 1fr; gap: 24px; }
      .enterprise-cta { text-align: left; }
      .includes-strip { grid-template-columns: repeat(2, 1fr); gap: 24px; padding: 28px 28px; }
      .cta-card { grid-template-columns: 1fr; padding: 44px 36px; }
      .cta-actions { justify-content: flex-start; }
    }
    @media (max-width: 640px) {
      .pricing-hero { padding: 60px 0 36px; }
      .billing-toggle button { padding: 8px 14px; font-size: .85rem; }
      .pricing-section { padding: 24px 0 64px; }
      .plan { padding: 30px 26px 26px; border-radius: 22px; }
      .price-amount { font-size: 2.8rem; }
      .enterprise { padding: 32px 26px; border-radius: 22px; }
      .enterprise-cta .btn { width: 100%; }
      .addons-section { padding: 64px 0; }
      .includes-strip { grid-template-columns: 1fr; padding: 24px; gap: 18px; margin-top: 56px; }
      .faq-section { padding: 64px 0; }
      .faq-item summary { padding: 16px 18px; font-size: .95rem; }
      .faq-item p { padding: 0 18px 18px; }
      .cta-band { padding: 0 0 80px; }
      .cta-card { padding: 32px 24px; border-radius: 22px; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <section class="legal-hero pricing-hero">
    <div class="container pricing-hero-inner">
      <span class="eyebrow"><span class="dot"></span><span>Transparent pricing</span></span>
      <h1>Plans that <span class="serif-italic">scale</span> with your <span class="gradient-text">growth</span>.</h1>
      <p>Pick a retainer for ongoing growth, a one-time project for focused outcomes, or a custom program for full-funnel scale. No hidden fees. No surprise invoices. Cancel any retainer with 30 days' notice.</p>

      <div class="billing-toggle" role="tablist" aria-label="Billing cycle">
        <button type="button" class="active" data-cycle="monthly" role="tab" aria-selected="true">Monthly</button>
        <button type="button" data-cycle="quarterly" role="tab" aria-selected="false">Quarterly <span class="save">Save 10%</span></button>
      </div>
    </div>
  </section>

  <section class="pricing-section">
    <div class="container">
      <div class="pricing-grid">

        <!-- LAUNCH -->
        <article class="plan">
          <header class="plan-head">
            <div class="plan-name">
              <span class="ic" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
              </span>
              Launch
            </div>
            <p class="plan-blurb">A focused single-channel program for early-stage and small teams ready to start ranking, ranking, and converting.</p>
            <div class="price">
              <span class="price-currency">$</span>
              <span class="price-amount" data-monthly="499" data-quarterly="449">499</span>
              <span class="price-cycle">/ month</span>
            </div>
            <span class="price-note">Billed in USD. 3-month minimum. Cancel anytime after.</span>
          </header>

          <div class="plan-cta">
            <a href="{{ url('/') }}#contact" class="btn btn-outline">Start with Launch</a>
          </div>

          <h5 class="plan-includes">What's included</h5>
          <ul class="plan-list">
            <li><strong>1 channel focus</strong> — SEO <em>or</em> Paid Ads <em>or</em> Email</li>
            <li>Up to <strong>$3K/mo</strong> ad spend management</li>
            <li><strong>4 content pieces</strong> per month (blog or ad creative)</li>
            <li>Monthly performance reporting</li>
            <li>Quarterly strategy review</li>
            <li>Email support, 24-hour response</li>
          </ul>
        </article>

        <!-- GROWTH (FEATURED) -->
        <article class="plan featured">
          <span class="plan-badge">Most popular</span>
          <header class="plan-head">
            <div class="plan-name">
              <span class="ic" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
              </span>
              Growth
            </div>
            <p class="plan-blurb">Multi-channel growth for serious brands ready to compound traffic, leads, and revenue across the funnel.</p>
            <div class="price">
              <span class="price-currency">$</span>
              <span class="price-amount" data-monthly="1,499" data-quarterly="1,349">1,499</span>
              <span class="price-cycle">/ month</span>
            </div>
            <span class="price-note">Billed in USD. 3-month minimum. Cancel anytime after.</span>
          </header>

          <div class="plan-cta">
            <a href="{{ url('/') }}#contact" class="btn btn-primary">Start with Growth</a>
          </div>

          <h5 class="plan-includes">Everything in Launch, plus</h5>
          <ul class="plan-list">
            <li><strong>Multi-channel</strong> — SEO + Paid Ads + Social</li>
            <li>Up to <strong>$15K/mo</strong> ad spend management</li>
            <li><strong>8 content pieces</strong> per month + creative testing</li>
            <li><strong>Quarterly CRO sprint</strong> with landing-page rebuild</li>
            <li>Bi-weekly strategy calls</li>
            <li>Live dashboard + bi-weekly insights</li>
            <li>Priority support, 12-hour response</li>
          </ul>
        </article>

        <!-- SCALE -->
        <article class="plan">
          <header class="plan-head">
            <div class="plan-name">
              <span class="ic" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m7 14 4-4 4 4 5-5"/></svg>
              </span>
              Scale
            </div>
            <p class="plan-blurb">Full-funnel growth for established teams running multi-channel programs that need a dedicated, multi-discipline crew.</p>
            <div class="price">
              <span class="price-currency">$</span>
              <span class="price-amount" data-monthly="2,999" data-quarterly="2,699">2,999</span>
              <span class="price-cycle">/ month</span>
            </div>
            <span class="price-note">Billed in USD. 3-month minimum. Cancel anytime after.</span>
          </header>

          <div class="plan-cta">
            <a href="{{ url('/') }}#contact" class="btn btn-outline">Start with Scale</a>
          </div>

          <h5 class="plan-includes">Everything in Growth, plus</h5>
          <ul class="plan-list">
            <li><strong>Full-funnel program</strong> — SEO, PPC, Social, Email, CRO</li>
            <li><strong>Unlimited</strong> ad spend management</li>
            <li><strong>12 content pieces</strong> per month + video</li>
            <li><strong>Dedicated growth team</strong></li>
            <li>Weekly strategy calls + Slack channel</li>
            <li>Custom attribution dashboard</li>
            <li>8-hour response SLA, business hours</li>
          </ul>
        </article>

      </div>

      <!-- Enterprise band -->
      <aside class="enterprise" aria-label="Enterprise plan">
        <div class="enterprise-text">
          <small>Enterprise &amp; Custom</small>
          <h3>Need a bespoke program, white-label support, or international scale?</h3>
          <p>For teams running 7- and 8-figure budgets, multi-region campaigns, or complex stacks, we build a custom SOW with dedicated resourcing, white-glove onboarding, and SLAs that match your business.</p>
        </div>
        <div class="enterprise-cta">
          <a href="{{ url('/') }}#contact" class="btn btn-light btn-lg">Talk to sales →</a>
        </div>
      </aside>

      <!-- Universal includes -->
      <div class="includes-strip">
        <div class="include-item">
          <span class="include-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          <strong>No long contracts</strong>
          <small>3-month minimum, then month-to-month with 30 days' notice.</small>
        </div>
        <div class="include-item">
          <span class="include-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4"/><path d="M12 18v4"/><path d="M4.93 4.93l2.83 2.83"/><path d="M16.24 16.24l2.83 2.83"/><path d="M2 12h4"/><path d="M18 12h4"/><path d="M4.93 19.07l2.83-2.83"/><path d="M16.24 7.76l2.83-2.83"/></svg>
          </span>
          <strong>Senior team only</strong>
          <small>No juniors learning on your account. Average 8+ years in-channel.</small>
        </div>
        <div class="include-item">
          <span class="include-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 12l3 3 7-7"/></svg>
          </span>
          <strong>Live reporting</strong>
          <small>Real-time dashboards. You see exactly what we see, every day.</small>
        </div>
        <div class="include-item">
          <span class="include-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9"/><polyline points="3 4 3 12 11 12"/></svg>
          </span>
          <strong>14-day kickoff</strong>
          <small>From signed SOW to first deliverable in two weeks or less.</small>
        </div>
      </div>
    </div>
  </section>

  <section class="addons-section">
    <div class="container">
      <div class="section-head" style="max-width: 720px;">
        <span class="eyebrow"><span class="dot"></span><span>Project work</span></span>
        <h2 style="margin-top:14px;">One-time projects &amp; <span class="serif-italic">add-ons</span></h2>
        <p style="font-size:1.05rem; color:var(--soft); max-width:600px;">Need a focused outcome instead of a retainer? These are the standalone projects we run most often. Pricing is a starting point — final scope is set in a written proposal.</p>
      </div>

      <div class="addon-grid">
        <article class="addon">
          <h4 class="addon-name">Website redesign</h4>
          <p class="addon-blurb">Strategy, UX, design, and build of a conversion-first marketing site. Typical timeline: 6–10 weeks.</p>
          <div class="addon-price">from $2,500 <small>&nbsp;one-time</small></div>
        </article>
        <article class="addon">
          <h4 class="addon-name">SEO audit + 90-day plan</h4>
          <p class="addon-blurb">Technical, on-page, and content audit. Prioritized 90-day roadmap with quick wins. Delivered in 2 weeks.</p>
          <div class="addon-price">from $2,500 <small>&nbsp;one-time</small></div>
        </article>
        <article class="addon">
          <h4 class="addon-name">SEO audit + 90-day plan</h4>
          <p class="addon-blurb">Technical, on-page, and content audit. Prioritized 90-day roadmap with quick wins. Delivered in 2 weeks.</p>
          <div class="addon-price">from $499 <small>&nbsp;one-time</small></div>
        </article>
        <article class="addon">
          <h4 class="addon-name">Brand &amp; positioning sprint</h4>
          <p class="addon-blurb">Two-week sprint to nail positioning, messaging, and visual direction. Includes brand guide and key assets.</p>
          <div class="addon-price">from $1,499 <small>&nbsp;one-time</small></div>
        </article>
        <article class="addon">
          <h4 class="addon-name">Paid media launch</h4>
          <p class="addon-blurb">Account build, audience research, creative, tracking setup, and 30-day launch optimization on Google or Meta.</p>
          <div class="addon-price">from $999 <small>&nbsp;one-time</small></div>
        </article>
        <article class="addon">
          <h4 class="addon-name">CRO + landing page</h4>
          <p class="addon-blurb">Research, design, and build of a high-converting landing page with a 30-day experimentation plan.</p>
          <div class="addon-price">from $999 <small>&nbsp;one-time</small></div>
        </article>
        <article class="addon">
          <h4 class="addon-name">Shopify build</h4>
          <p class="addon-blurb">Custom Shopify storefront with theme development, app integrations, and conversion-optimized PDP/checkout.</p>
          <div class="addon-price">from $3,500 <small>&nbsp;one-time</small></div>
        </article>
        <article class="addon">
          <h4 class="addon-name">AI agent build</h4>
          <p class="addon-blurb">A custom AI agent for support, sales, or marketing — wired into your stack with logging and guardrails.</p>
          <div class="addon-price">from $1,999 <small>&nbsp;one-time</small></div>
        </article>
        <article class="addon">
          <h4 class="addon-name">Email program setup</h4>
          <p class="addon-blurb">Lifecycle flows (welcome, abandoned, post-purchase, win-back) plus a weekly campaign engine on Klaviyo or HubSpot.</p>
          <div class="addon-price">from $1,499 <small>&nbsp;one-time</small></div>
        </article>
      </div>
    </div>
  </section>

  <section class="faq-section">
    <div class="container">
      <div class="section-head centered" style="max-width: 720px; margin: 0 auto; text-align: center;">
        <span class="eyebrow"><span class="dot"></span><span>FAQ</span></span>
        <h2 style="margin-top:14px;">Pricing <span class="serif-italic">questions</span></h2>
        <p style="font-size:1.05rem; color:var(--soft);">If your question isn't here, send it to <a href="mailto:info@digirisers.com">info@digirisers.com</a> — we usually reply within a business day.</p>
      </div>

      <div class="faq-grid">
        <details class="faq-item">
          <summary>Is ad spend included in retainer pricing?</summary>
          <p>No. Retainers cover strategy, management, creative, optimization, and reporting. Ad spend is paid directly by you to Google, Meta, LinkedIn, etc. — your card, your account, your data. We never mark up ad spend.</p>
        </details>
        <details class="faq-item">
          <summary>Are there long-term contracts?</summary>
          <p>Retainers have a 3-month minimum so we can do real work and earn results, after which they're month-to-month. Cancel anytime with 30 days' written notice. One-time projects are billed by milestone, not subscription.</p>
        </details>
        <details class="faq-item">
          <summary>How does onboarding work?</summary>
          <p>Day 0 — you sign the SOW. Days 1–7 — kickoff call, accounts/access, audit, and 90-day plan. Day 8–14 — first deliverables go live. You'll have a single point of contact and a shared dashboard from day one.</p>
        </details>
        <details class="faq-item">
          <summary>Can I upgrade, downgrade, or pause my plan?</summary>
          <p>Yes. Upgrade anytime with no penalty. Downgrade at the end of a billing cycle. We can pause for up to 60 days for seasonal businesses — let us know and we'll structure it in the SOW.</p>
        </details>
        <details class="faq-item">
          <summary>Do you guarantee specific results?</summary>
          <p>No reputable agency can — outcomes depend on too many factors outside our control. What we do guarantee: the agreed scope of work, weekly visibility into progress, and a senior team that owns the result. See our <a href="{{ url('/terms') }}">Terms</a> for the full detail.</p>
        </details>
        <details class="faq-item">
          <summary>What payment methods do you accept?</summary>
          <p>Credit card (Visa, Mastercard, Amex), ACH for US clients, and wire transfer for international. Invoices are <em>Net 7</em> from issue date. All payments are processed by our PCI-compliant payment provider — we never store card data.</p>
        </details>
        <details class="faq-item">
          <summary>Do you work with my industry?</summary>
          <p>We focus on B2B SaaS, professional services, ecommerce/DTC, healthcare, fintech, and home services. If your industry isn't on that list, ask anyway — we'll tell you straight if we're not the right fit.</p>
        </details>
        <details class="faq-item">
          <summary>What about refunds?</summary>
          <p>Retainer fees are non-refundable once work has begun for the month. Project work follows milestone-based refund rules. Full detail is in our <a href="{{ url('/refund') }}">Refund Policy</a>.</p>
        </details>
      </div>
    </div>
  </section>

  <section class="cta-band">
    <div class="container">
      <div class="cta-card">
        <div>
          <h2>Not sure which plan fits?</h2>
          <p>A free 30-minute call is the fastest way to find out. We'll review your goals, current channels, and budget — and tell you straight if a retainer, project, or "do nothing" is the right move.</p>
        </div>
        <div class="cta-actions">
          <a href="{{ url('/') }}#contact" class="btn btn-light btn-lg">Book a strategy call</a>
          <a href="mailto:info@digirisers.com" class="btn btn-light btn-lg" style="background: rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.3);">Email us</a>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')

@endsection

@push('scripts')
  <script>
    // Billing toggle
    const cycleButtons = document.querySelectorAll('.billing-toggle button');
    const priceEls = document.querySelectorAll('.price-amount');
    const cycleLabels = document.querySelectorAll('.price-cycle');
    cycleButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        cycleButtons.forEach(b => {
          b.classList.remove('active');
          b.setAttribute('aria-selected', 'false');
        });
        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');
        const cycle = btn.dataset.cycle;
        priceEls.forEach(el => {
          el.textContent = el.dataset[cycle];
        });
        cycleLabels.forEach(l => {
          l.textContent = cycle === 'quarterly' ? '/ month, billed quarterly' : '/ month';
        });
      });
    });
  </script>
@endpush
