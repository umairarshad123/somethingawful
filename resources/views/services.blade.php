@extends('layouts.app')

@section('title', 'Services — Digirisers')
@section('description', 'Explore Digirisers services — full-stack web development, SEO & marketing, design & CRO, AI & automation, and brand strategy. Everything you need to scale.')
@section('robots', 'index,follow')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    /* Services-specific (extends legal.css) */
    section { padding: 100px 0; position: relative; }
    .container { max-width: 1240px; }

    /* Hero */
    .svc-hero {
      position: relative; overflow: hidden;
      background: var(--grad-soft);
      padding: 90px 0 70px;
      border-bottom: 1px solid var(--line);
    }
    .svc-hero::before {
      content: ""; position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(148,163,184,.15) 1px, transparent 1px),
        linear-gradient(90deg, rgba(148,163,184,.15) 1px, transparent 1px);
      background-size: 56px 56px;
      mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 60% 60% at 50% 30%, #000 30%, transparent 80%);
      pointer-events: none;
    }
    .svc-hero::after {
      content: ""; position: absolute; top: -160px; left: 50%; transform: translateX(-50%);
      width: 1100px; height: 600px;
      background: radial-gradient(ellipse at center, rgba(59,130,246,.22) 0%, transparent 55%);
      pointer-events: none;
    }
    .svc-hero-inner { position: relative; z-index: 1; max-width: 820px; text-align: center; margin: 0 auto; }
    .svc-hero h1 { margin-bottom: 18px; }
    .svc-hero h1 .gradient-text { display: inline-block; }
    .svc-hero p {
      font-size: 1.15rem; color: var(--muted);
      max-width: 660px; margin: 0 auto 32px;
    }
    .svc-hero-actions {
      display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;
    }

    /* 5 main boxes grid */
    .pillars { background: #fff; padding: 90px 0; }
    .pillar-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 18px;
    }
    .pillar {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: var(--r-lg);
      padding: 30px 26px 28px;
      display: flex; flex-direction: column;
      position: relative; overflow: hidden;
      transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
    }
    .pillar::before {
      content: ""; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: var(--grad);
      transform: scaleX(0); transform-origin: left;
      transition: transform .5s ease;
    }
    .pillar:hover { transform: translateY(-6px); border-color: var(--blue-300); box-shadow: var(--shadow-lg); }
    .pillar:hover::before { transform: scaleX(1); }
    .pillar-num {
      position: absolute; top: 22px; right: 26px;
      font-family: var(--font-mono); font-size: .72rem;
      color: var(--soft-2); letter-spacing: .1em; font-weight: 500;
    }
    .pillar-icon {
      width: 52px; height: 52px; border-radius: 14px;
      background: var(--blue-50); color: var(--blue-700);
      display: grid; place-items: center;
      margin-bottom: 18px;
      transition: background .35s ease, color .35s ease, transform .4s ease;
    }
    .pillar:hover .pillar-icon { background: var(--ink); color: #fff; transform: rotate(-6deg) scale(1.05); }
    .pillar h3 {
      font-size: 1.1rem; font-weight: 700; color: var(--ink);
      margin: 0 0 10px; letter-spacing: -0.015em;
    }
    .pillar p { font-size: .9rem; color: var(--soft); margin: 0 0 18px; line-height: 1.5; }
    .pillar ul {
      list-style: none; margin: 0 0 20px; padding: 0; display: grid; gap: 7px; flex: 1;
    }
    .pillar ul li {
      position: relative; padding-left: 18px;
      font-size: .82rem; color: var(--muted); line-height: 1.4;
    }
    .pillar ul li::before {
      content: ""; position: absolute; left: 0; top: 7px;
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--blue-100); border: 2px solid var(--blue-500);
    }
    .pillar-cta {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 10px 16px;
      background: var(--bg-soft);
      border: 1px solid var(--line);
      border-radius: 999px;
      font-size: .82rem; font-weight: 600;
      color: var(--ink);
      transition: all .25s ease;
      margin-top: auto;
    }
    .pillar-cta:hover { background: var(--ink); color: #fff; border-color: var(--ink); }

    /* Detailed sections */
    .svc-section { background: var(--bg-soft); border-top: 1px solid var(--line); }
    .svc-section:nth-of-type(odd) { background: #fff; }
    .svc-head {
      display: grid; grid-template-columns: 1fr 1.4fr; gap: 60px;
      align-items: end; margin-bottom: 48px;
    }
    .svc-head .svc-tag {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: .72rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .14em;
      color: var(--blue-700);
      background: var(--blue-50);
      border: 1px solid var(--blue-100);
      padding: 6px 12px;
      border-radius: 999px;
      margin-bottom: 18px;
    }
    .svc-head h2 {
      font-size: clamp(1.8rem, 3.5vw, 2.6rem);
      margin: 0 0 4px; letter-spacing: -0.03em;
    }
    .svc-head p { margin: 0; font-size: 1rem; color: var(--muted); line-height: 1.65; }

    .svc-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 12px;
    }
    .svc-item {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 14px;
      padding: 16px 18px;
      display: flex; align-items: flex-start; gap: 12px;
      transition: border-color .25s ease, transform .25s ease, box-shadow .25s ease;
    }
    .svc-section:nth-of-type(odd) .svc-item { background: var(--bg-soft); }
    .svc-item:hover {
      border-color: var(--blue-300);
      transform: translateY(-2px);
      box-shadow: var(--shadow-sm);
    }
    .svc-item-dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--blue-500); margin-top: 7px;
      flex-shrink: 0;
      box-shadow: 0 0 0 3px var(--blue-100);
    }
    .svc-item span { font-size: .9rem; color: var(--ink); font-weight: 500; line-height: 1.4; }

    .svc-foot {
      margin-top: 36px;
      display: flex; gap: 12px; flex-wrap: wrap;
    }
    .svc-foot .btn { font-size: .9rem; }

    /* Bottom CTA */
    .svc-bottom {
      background: var(--ink);
      color: #fff;
      padding: 90px 0;
      position: relative;
      overflow: hidden;
    }
    .svc-bottom::before {
      content: ""; position: absolute; top: -200px; left: 50%; transform: translateX(-50%);
      width: 1100px; height: 600px;
      background: radial-gradient(ellipse at center, rgba(59,130,246,.28) 0%, transparent 55%);
      pointer-events: none;
    }
    .svc-bottom-inner {
      position: relative; z-index: 1;
      max-width: 720px; margin: 0 auto; text-align: center;
    }
    .svc-bottom h2 { color: #fff; margin: 0 0 16px; }
    .svc-bottom h2 .serif-italic { color: var(--blue-300); }
    .svc-bottom p { color: rgba(255,255,255,.7); font-size: 1.1rem; margin: 0 0 28px; }
    .svc-bottom .btn-primary { background: #fff; color: var(--ink); }
    .svc-bottom .btn-primary:hover { background: var(--blue-100); color: var(--ink); }
    .svc-bottom .btn-ghost {
      background: transparent; color: #fff;
      border: 1px solid rgba(255,255,255,.2);
    }
    .svc-bottom .btn-ghost:hover {
      background: rgba(255,255,255,.08); border-color: #fff; color: #fff;
    }

    @media (max-width: 980px) {
      .pillar-grid { grid-template-columns: repeat(2, 1fr); }
      .svc-head { grid-template-columns: 1fr; gap: 16px; align-items: start; }
    }
    @media (max-width: 640px) {
      section { padding: 70px 0; }
      .pillar-grid { grid-template-columns: 1fr; }
      .svc-list { grid-template-columns: 1fr; }
      .svc-hero { padding: 70px 0 50px; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <section class="svc-hero">
    <div class="container svc-hero-inner">
      <span class="eyebrow"><span class="dot"></span><span>Services Catalog</span></span>
      <h1>Everything you need to <span class="gradient-text">grow online.</span></h1>
      <p>From full-stack engineering and security to SEO, AI agents, and revenue-focused design — Digirisers is a SaaS-style growth platform with one team for the entire stack.</p>
      <div class="svc-hero-actions">
        <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Visit the Shop →</a>
        <a href="#pillars" class="btn btn-ghost btn-lg">Browse 5 Pillars</a>
      </div>
    </div>
  </section>

  {{-- 5 Main Boxes --}}
  <section class="pillars" id="pillars">
    <div class="container">
      <div class="section-head centered" style="text-align:center; max-width:680px; margin:0 auto 56px;">
        <span class="eyebrow"><span class="dot"></span><span>5 Service Pillars</span></span>
        <h2>One platform. <span class="serif-italic">Five superpowers.</span></h2>
        <p class="section-sub" style="font-size:1.08rem; color:var(--soft); margin-top:8px;">Each pillar is a complete discipline — choose what you need, or hire the whole stack.</p>
      </div>

      <div class="pillar-grid">

        <article class="pillar">
          <span class="pillar-num">01 / 05</span>
          <div class="pillar-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
          </div>
          <h3>Web Development & Engineering</h3>
          <p>Secure, scalable, full-stack builds — from WordPress to custom Laravel SaaS.</p>
          <ul>
            <li>Full-Stack Web Development</li>
            <li>Laravel, Python, JavaScript</li>
            <li>WordPress & Elementor</li>
            <li>API & Microservices Architecture</li>
            <li>Web Application Security</li>
          </ul>
          <a href="#web-dev" class="pillar-cta">Explore →</a>
        </article>

        <article class="pillar">
          <span class="pillar-num">02 / 05</span>
          <div class="pillar-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
          </div>
          <h3>SEO & Digital Marketing</h3>
          <p>Organic, paid, and AI-search visibility that drives qualified traffic.</p>
          <ul>
            <li>Technical, On-Page, Local SEO</li>
            <li>AI Search Optimization (AEO)</li>
            <li>Google PPC, Meta, TikTok, X Ads</li>
            <li>Email & SMS Automation</li>
            <li>Backlinks & Authority Building</li>
          </ul>
          <a href="#seo-marketing" class="pillar-cta">Explore →</a>
        </article>

        <article class="pillar">
          <span class="pillar-num">03 / 05</span>
          <div class="pillar-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><circle cx="11" cy="11" r="2"/></svg>
          </div>
          <h3>Web Design & CRO</h3>
          <p>Revenue-focused design, funnel architecture, and conversion systems.</p>
          <ul>
            <li>Web Design & UX Engineering</li>
            <li>Ecommerce & Landing Pages</li>
            <li>Funnel Architecture</li>
            <li>Conversion Rate Optimization</li>
            <li>CRM-Driven Personalization</li>
          </ul>
          <a href="#design-cro" class="pillar-cta">Explore →</a>
        </article>

        <article class="pillar">
          <span class="pillar-num">04 / 05</span>
          <div class="pillar-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><circle cx="12" cy="5" r="2"/><path d="M12 7v4"/></svg>
          </div>
          <h3>AI, Automation & CRM</h3>
          <p>AI employees, agentic systems, and end-to-end CRM automation.</p>
          <ul>
            <li>AI Employees & Assistants</li>
            <li>AI Sales, Support & Admin Agents</li>
            <li>GoHighLevel, Zoho, Zapier</li>
            <li>Lead Management & Webhooks</li>
            <li>Prompt Engineering</li>
          </ul>
          <a href="#ai-automation" class="pillar-cta">Explore →</a>
        </article>

        <article class="pillar">
          <span class="pillar-num">05 / 05</span>
          <div class="pillar-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
          </div>
          <h3>Brand & Business Strategy</h3>
          <p>Brand systems, video, and growth strategy built around revenue.</p>
          <ul>
            <li>Brand Strategy & Logo Design</li>
            <li>Custom Video & Short-Form</li>
            <li>Canva & CapCut Editing</li>
            <li>Digital & Growth Strategy</li>
            <li>Scalable Automation Design</li>
          </ul>
          <a href="#brand-strategy" class="pillar-cta">Explore →</a>
        </article>

      </div>
    </div>
  </section>

  {{-- 1. Web Development --}}
  <section class="svc-section" id="web-dev">
    <div class="container">
      <div class="svc-head">
        <div>
          <span class="svc-tag">Pillar 01 — Build</span>
          <h2>Web Development & Engineering</h2>
        </div>
        <p>Full-stack builds, secure architecture, and scalable APIs. Every site we ship follows OWASP best practices, hardened authentication, and modern infrastructure standards.</p>
      </div>

      <div class="svc-list">
        @foreach ([
          'Full-Stack Web Development',
          'Secure Web Architecture',
          'WordPress Development',
          'Elementor Custom Development',
          'Laravel Development',
          'Python Development',
          'JavaScript Development',
          'Custom HTML/CSS/JavaScript',
          'API Development & Integration',
          'Microservices Architecture',
          'Payment Gateway Integration',
          'Subscription & Billing Systems',
          'Hosting & VPS Management',
          'DNS & SSL Configuration',
          'Infrastructure Security',
          'Website Security Implementation',
          'Role-Based Access Control (RBAC)',
          'Two-Factor Authentication (2FA)',
          'Secure Authentication Systems',
          'Data Encryption Practices',
          'Web Application Security',
          'API Security',
          'OWASP Best Practices',
          'Malware Prevention & Threat Mitigation',
        ] as $svc)
          <div class="svc-item">
            <span class="svc-item-dot" aria-hidden="true"></span>
            <span>{{ $svc }}</span>
          </div>
        @endforeach
      </div>

      <div class="svc-foot">
        <a href="{{ url('/shop') }}#cat-web-dev" class="btn btn-primary">See pricing →</a>
        <a href="{{ url('/') }}#contact" class="btn btn-ghost">Custom quote</a>
      </div>
    </div>
  </section>

  {{-- 2. SEO & Marketing --}}
  <section class="svc-section" id="seo-marketing">
    <div class="container">
      <div class="svc-head">
        <div>
          <span class="svc-tag">Pillar 02 — Grow</span>
          <h2>SEO & Digital Marketing</h2>
        </div>
        <p>Organic, paid, and AI-search visibility working together. We build search systems that rank in Google, ChatGPT, Gemini, and Grok — plus the paid and lifecycle channels that compound your pipeline.</p>
      </div>

      <div class="svc-list">
        @foreach ([
          'Search Engine Optimization (SEO)',
          'Technical SEO',
          'On-Page SEO',
          'Local SEO (Google Maps Optimization)',
          'Programmatic SEO',
          'AI Search Optimization (AI-SEO / AEO)',
          'ChatGPT Optimization',
          'Gemini Optimization',
          'Grok Optimization',
          'Search Intent Mapping',
          'Keyword Research & Strategy',
          'SEO Content Creation',
          'Backlink Strategy & Authority Building',
          'Core Web Vitals Optimization',
          'Website Performance Optimization',
          'Competitor & SERP Analysis',
          'Paid Advertising Strategy',
          'Google PPC Campaigns',
          'Meta Ads (Facebook & Instagram)',
          'X (Twitter) Ad Campaigns',
          'TikTok Ad Campaigns',
          'Streaming & Display Advertising',
          'Conversion Tracking & Attribution',
          'Organic Marketing Strategy',
          'Social Media Marketing',
          'AI Influencer Systems',
          'Email Marketing Automation',
          'SMS Marketing Automation',
          'LinkedIn DM Outreach',
        ] as $svc)
          <div class="svc-item">
            <span class="svc-item-dot" aria-hidden="true"></span>
            <span>{{ $svc }}</span>
          </div>
        @endforeach
      </div>

      <div class="svc-foot">
        <a href="{{ url('/shop') }}#cat-seo-marketing" class="btn btn-primary">See pricing →</a>
        <a href="{{ url('/') }}#contact" class="btn btn-ghost">Custom quote</a>
      </div>
    </div>
  </section>

  {{-- 3. Design & CRO --}}
  <section class="svc-section" id="design-cro">
    <div class="container">
      <div class="svc-head">
        <div>
          <span class="svc-tag">Pillar 03 — Convert</span>
          <h2>Web Design & Conversion (CRO)</h2>
        </div>
        <p>Beautiful sites are nice — converting sites are the goal. We design every page around revenue: clear hierarchy, persuasive copy, conversion-tested patterns, and CRM-driven personalization.</p>
      </div>

      <div class="svc-list">
        @foreach ([
          'Web Design & UX Engineering',
          'Revenue-Focused Web Design',
          'Ecommerce Web Design',
          'Landing Pages & Funnels',
          'Conversion Rate Optimization (CRO)',
          'Funnel Architecture & Optimization',
          'CRM-Driven Personalization',
        ] as $svc)
          <div class="svc-item">
            <span class="svc-item-dot" aria-hidden="true"></span>
            <span>{{ $svc }}</span>
          </div>
        @endforeach
      </div>

      <div class="svc-foot">
        <a href="{{ url('/shop') }}#cat-design-cro" class="btn btn-primary">See pricing →</a>
        <a href="{{ url('/') }}#contact" class="btn btn-ghost">Custom quote</a>
      </div>
    </div>
  </section>

  {{-- 4. AI & Automation --}}
  <section class="svc-section" id="ai-automation">
    <div class="container">
      <div class="svc-head">
        <div>
          <span class="svc-tag">Pillar 04 — Automate</span>
          <h2>AI, Automation & CRM Systems</h2>
        </div>
        <p>Hire an AI workforce that handles support, sales, admin, and data — wired into your CRM, calendar, and inbox. We build agents and workflows that compound your team's output without compounding payroll.</p>
      </div>

      <div class="svc-list">
        @foreach ([
          'Marketing Automation & CRM Systems',
          'GoHighLevel Automation',
          'Credit Repair Cloud Automation',
          'Dispute Fox Automation',
          'Zoho CRM Automation',
          'Zapier Automation',
          'Webhook Architecture',
          'Lead Management Systems',
          'Appointment & Calendar Automation',
          'Referral & Affiliate System Setup',
          'AI Infrastructure & Agentic AI Systems',
          'AI Employees & Assistants',
          'AI Customer Support Agents',
          'AI Sales & Appointment Setters',
          'AI Admin & Task Assistants',
          'AI Data Processing Bots',
          'AI Web Chat & Knowledge Bases',
          'Predictive Automation & Personalization',
          'Prompt Engineering',
          'AI Workflow Orchestration',
        ] as $svc)
          <div class="svc-item">
            <span class="svc-item-dot" aria-hidden="true"></span>
            <span>{{ $svc }}</span>
          </div>
        @endforeach
      </div>

      <div class="svc-foot">
        <a href="{{ url('/shop') }}#cat-ai-automation" class="btn btn-primary">See pricing →</a>
        <a href="{{ url('/') }}#contact" class="btn btn-ghost">Custom quote</a>
      </div>
    </div>
  </section>

  {{-- 5. Brand & Strategy --}}
  <section class="svc-section" id="brand-strategy">
    <div class="container">
      <div class="svc-head">
        <div>
          <span class="svc-tag">Pillar 05 — Brand</span>
          <h2>Branding & Business Strategy</h2>
        </div>
        <p>From a sharper logo to a full growth blueprint — we build brands and systems that scale revenue, not just impressions. Strategy, video, and creative under one roof.</p>
      </div>

      <div class="svc-list">
        @foreach ([
          'Branding & Creative Systems',
          'Brand Strategy & Consultation',
          'Logo Design',
          'Video Editing',
          'Custom Video Production',
          'Short-Form Video Scriptwriting',
          'Canva Creative Design',
          'CapCut Video Editing',
          'Digital Marketing Collateral',
          'Business Systems Engineering',
          'Digital Strategy',
          'Growth Systems Architecture',
          'Revenue-Focused Digital Strategy',
          'Scalable Automation Design',
        ] as $svc)
          <div class="svc-item">
            <span class="svc-item-dot" aria-hidden="true"></span>
            <span>{{ $svc }}</span>
          </div>
        @endforeach
      </div>

      <div class="svc-foot">
        <a href="{{ url('/shop') }}#cat-brand-strategy" class="btn btn-primary">See pricing →</a>
        <a href="{{ url('/') }}#contact" class="btn btn-ghost">Custom quote</a>
      </div>
    </div>
  </section>

  <section class="svc-bottom">
    <div class="container svc-bottom-inner">
      <h2>Ready to <span class="serif-italic">scale?</span></h2>
      <p>Pick services off the shelf in our Shop, or talk to us about a custom growth engagement.</p>
      <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
        <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Shop services →</a>
        <a href="{{ url('/') }}#contact" class="btn btn-ghost btn-lg">Book a strategy call</a>
      </div>
    </div>
  </section>

  @include('partials.footer')

@endsection
