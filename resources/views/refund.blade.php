@extends('layouts.app')

@section('title', 'Refund Policy — Digirisers')
@section('description', 'Refund Policy for Digirisers — when refunds apply, how to request one, and how cancellations are handled.')
@section('robots', 'index,follow')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
@endpush

@section('content')

  <header class="nav" id="nav">
    <div class="nav-inner container">
      <a href="{{ url('/') }}" class="logo" aria-label="Digirisers home">
        <span class="logo-mark" aria-hidden="true">
          <svg viewBox="0 0 40 40" width="32" height="32">
            <defs>
              <linearGradient id="lg" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#60a5fa"/>
                <stop offset="1" stop-color="#1e3a8a"/>
              </linearGradient>
            </defs>
            <rect x="2" y="2" width="36" height="36" rx="10" fill="url(#lg)"/>
            <path d="M10 26 L16 18 L22 24 L30 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="30" cy="12" r="2.5" fill="#fff"/>
          </svg>
        </span>
        <span class="logo-text">Digirisers<span class="logo-dot">.</span></span>
      </a>

      <nav class="nav-links" aria-label="Primary">
        <a href="{{ url('/') }}#services">Services</a>
        <a href="{{ url('/') }}#industries">Industries</a>
        <a href="{{ url('/') }}#results">Results</a>
        <a href="{{ url('/pricing') }}">Pricing</a>
        <a href="{{ url('/') }}#process">Process</a>
        <a href="{{ url('/') }}#contact">Contact</a>
      </nav>

      <div class="nav-right">
        <a href="{{ url('/') }}#contact" class="btn btn-primary nav-cta">Start a project</a>
      </div>

      <button class="nav-toggle" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span>
      </button>
    </div>
  </header>

  <section class="legal-hero">
    <div class="container legal-hero-inner">
      <span class="eyebrow"><span class="dot"></span><span>Legal</span></span>
      <h1>Refund <span class="serif-italic">policy</span></h1>
      <p>We work hard to do excellent work, but if something isn't right, we want to make it right. This policy explains when refunds apply to engagements with Digirisers, how to request one, and how cancellations are handled.</p>
      <div class="legal-meta">
        <span>Effective: April 28, 2026</span>
        <span>Last updated: April 28, 2026</span>
        <span>Version 1.0</span>
      </div>
    </div>
  </section>

  <section class="legal-body">
    <div class="container legal-body-inner">

      <aside class="toc" aria-label="On this page">
        <h4>On this page</h4>
        <ul>
          <li><a href="#scope">1. Scope of this policy</a></li>
          <li><a href="#guarantee">2. Our service guarantee</a></li>
          <li><a href="#retainers">3. Monthly retainers</a></li>
          <li><a href="#projects">4. One-time projects</a></li>
          <li><a href="#ad-spend">5. Ad spend & third-party fees</a></li>
          <li><a href="#non-refundable">6. Non-refundable items</a></li>
          <li><a href="#how-to-request">7. How to request a refund</a></li>
          <li><a href="#processing">8. Processing & timelines</a></li>
          <li><a href="#chargebacks">9. Disputes & chargebacks</a></li>
          <li><a href="#changes">10. Changes</a></li>
          <li><a href="#contact">11. Contact</a></li>
        </ul>
      </aside>

      <article class="legal-article">

        <h2 id="scope">1. Scope of this policy</h2>
        <p>This Refund Policy applies to fees paid directly to Digirisers ("we," "us," "our") for digital marketing services — including but not limited to SEO, paid media management, web design, content, email marketing, social media, ecommerce, and AI services — engaged via a Statement of Work, proposal, or order on our website.</p>
        <p>This policy is read together with our <a href="{{ url('/terms') }}">Terms and Conditions</a>. Where an SOW or written agreement contains different refund terms, that agreement controls for the engagement it governs.</p>

        <h2 id="guarantee">2. Our service guarantee</h2>
        <p>We stand behind the quality of our work. If you believe a deliverable does not meet the agreed scope or industry standards, contact us within fourteen (14) days of receipt and we will, at our option:</p>
        <ul>
          <li>Revise the deliverable until it meets the agreed scope (no extra charge for in-scope work);</li>
          <li>Provide a credit toward future services; or</li>
          <li>Issue a partial or full refund as set out below.</li>
        </ul>
        <div class="callout">
          <strong>The honest part:</strong> Marketing outcomes (rankings, traffic, leads, ROAS, revenue) depend on many factors outside our control. We refund based on <em>quality and delivery of the agreed work</em>, not on results. We are happy to discuss the work openly before, during, and after the engagement.
        </div>

        <h2 id="retainers">3. Monthly retainers</h2>
        <ul>
          <li><strong>Billing:</strong> Retainers are billed monthly in advance. The first invoice is due before work begins.</li>
          <li><strong>Cancellation:</strong> You may cancel a retainer at any time with thirty (30) days' written notice (email to <a href="mailto:info@digirisers.com">info@digirisers.com</a> is sufficient). The retainer remains active and billable through the notice period, during which we will deliver scoped work and a clean handover.</li>
          <li><strong>Mid-month termination:</strong> Retainer fees for the current month are non-refundable once work has begun for that month, because the team and resources are already allocated.</li>
          <li><strong>Pre-paid months:</strong> If you pre-paid for multiple months and cancel, we will refund unused, unstarted months on a pro-rata basis after deducting any earned fees and discounts.</li>
        </ul>

        <h2 id="projects">4. One-time projects (websites, audits, sprints)</h2>
        <p>Project work is typically billed in milestones (e.g., 50% on kickoff, 50% on delivery). Our refund approach for projects:</p>
        <ul>
          <li><strong>Before kickoff:</strong> If you cancel after deposit but before we have begun work, we will refund your deposit minus a 10% administrative fee covering scoping and contracting time.</li>
          <li><strong>After kickoff, before delivery:</strong> If you cancel mid-project, we will invoice (or retain) the pro-rata value of work completed up to the cancellation date and refund the balance, if any.</li>
          <li><strong>After delivery:</strong> Once final deliverables have been accepted, project fees are non-refundable. If a deliverable does not match the agreed scope, the guarantee in Section 2 applies.</li>
        </ul>

        <h2 id="ad-spend">5. Ad spend & third-party fees</h2>
        <p>Ad spend on platforms such as Google, Meta, LinkedIn, TikTok, and Microsoft is paid <strong>directly by the Client to those platforms</strong> using the Client's payment method. Refunds for ad spend (including credits, billing errors, or platform-issued refunds) are governed by each platform's policies and are processed by the platform, not by Digirisers.</p>
        <p>Where Digirisers has agreed in writing to manage ad spend on a Client's behalf, unspent funds will be refunded within fifteen (15) business days of campaign close, less any platform-imposed fees.</p>
        <p>Third-party software, hosting, domain, stock-asset, and licensing fees are non-refundable once purchased on your behalf.</p>

        <h2 id="non-refundable">6. Non-refundable items</h2>
        <p>The following are non-refundable except where required by applicable law:</p>
        <ul>
          <li>Setup, onboarding, and discovery fees once work has begun;</li>
          <li>Strategy documents, audits, and roadmaps once delivered;</li>
          <li>Custom creative (designs, copy, video) that has been approved or used publicly;</li>
          <li>Time-based services (consulting hours, workshops) once scheduled and held;</li>
          <li>Any third-party costs or licenses purchased on your behalf.</li>
        </ul>

        <h2 id="how-to-request">7. How to request a refund</h2>
        <p>To request a refund, email <a href="mailto:info@digirisers.com">info@digirisers.com</a> with the subject line "Refund Request" and include:</p>
        <ul>
          <li>The name on the engagement and your invoice or order number;</li>
          <li>The deliverable or service in question;</li>
          <li>A description of the issue and what outcome you are looking for;</li>
          <li>Any supporting context (screenshots, dates, communications) that helps us evaluate quickly.</li>
        </ul>
        <p>We will acknowledge your request within two (2) business days and aim to resolve it within ten (10) business days.</p>

        <h2 id="processing">8. Processing & timelines</h2>
        <ul>
          <li><strong>Approved refunds</strong> are issued to the original payment method.</li>
          <li><strong>Credit cards:</strong> typically appear within 5–10 business days, depending on your bank.</li>
          <li><strong>ACH / wire / bank transfer:</strong> typically settle within 7–14 business days.</li>
          <li><strong>Currency conversion:</strong> Refunds are returned in the original currency of payment. We are not responsible for exchange-rate differences between the original payment and the refund.</li>
        </ul>

        <h2 id="chargebacks">9. Disputes & chargebacks</h2>
        <p>If you have any concerns about a charge, please contact us first — most issues can be resolved within a few days. Filing a chargeback or payment dispute without first contacting us may delay resolution and, where the dispute is unfounded, may be considered a breach of these Terms. Digirisers reserves the right to suspend or terminate services and recover dispute-related fees in such cases.</p>

        <h2 id="changes">10. Changes to this policy</h2>
        <p>We may update this Refund Policy from time to time. The "Last updated" date at the top of the page reflects the most recent version. Material changes will be communicated via the website or by email. The policy in effect at the time you place an order or sign an SOW governs that engagement.</p>

        <h2 id="contact">11. Contact</h2>
        <p>Questions about a refund or a current invoice? We'd rather hear from you than have you wonder.</p>

        <div class="legal-contact">
          <h3>Need help with a refund?</h3>
          <p>Drop us a note and we will get back to you within two business days.</p>
          <div class="lc-row">
            <span>Email <a href="mailto:info@digirisers.com">info@digirisers.com</a></span>
            <span>Phone <a href="tel:+14019987807">+1 (401) 998-7807</a></span>
          </div>
        </div>

      </article>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-inner">
        <div class="footer-brand">
          <a href="{{ url('/') }}" class="logo">
            <span class="logo-mark" aria-hidden="true">
              <svg viewBox="0 0 40 40" width="28" height="28">
                <rect x="2" y="2" width="36" height="36" rx="10" fill="#3b82f6"/>
                <path d="M10 26 L16 18 L22 24 L30 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="30" cy="12" r="2.5" fill="#fff"/>
              </svg>
            </span>
            <span class="logo-text">Digirisers<span class="logo-dot">.</span></span>
          </a>
          <p>Digital marketing that rises above. Strategy, creative, and engineering under one roof.</p>
          <a href="tel:+14019987807" class="footer-phone">+1 (401) 998-7807</a>
        </div>

        <div class="footer-cols">
          <div>
            <h5>Grow</h5>
            <ul>
              <li><a href="{{ url('/') }}#services">SEO</a></li>
              <li><a href="{{ url('/') }}#services">PPC</a></li>
              <li><a href="{{ url('/') }}#services">Social</a></li>
              <li><a href="{{ url('/') }}#services">Content</a></li>
              <li><a href="{{ url('/') }}#services">Email</a></li>
            </ul>
          </div>
          <div>
            <h5>Build</h5>
            <ul>
              <li><a href="{{ url('/') }}#services">Web Design</a></li>
              <li><a href="{{ url('/') }}#services">Ecommerce</a></li>
              <li><a href="{{ url('/') }}#services">WordPress</a></li>
              <li><a href="{{ url('/') }}#services">Shopify</a></li>
              <li><a href="{{ url('/') }}#services">AI Agents</a></li>
            </ul>
          </div>
          <div>
            <h5>Convert</h5>
            <ul>
              <li><a href="{{ url('/') }}#services">CRO</a></li>
              <li><a href="{{ url('/') }}#services">Landing Pages</a></li>
              <li><a href="{{ url('/') }}#services">Personalization</a></li>
              <li><a href="{{ url('/') }}#services">ABM</a></li>
              <li><a href="{{ url('/') }}#services">Attribution</a></li>
            </ul>
          </div>
          <div>
            <h5>Legal</h5>
            <ul>
              <li><a href="{{ url('/pricing') }}">Pricing</a></li>
              <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
              <li><a href="{{ url('/terms') }}">Terms of Service</a></li>
              <li><a href="{{ url('/refund') }}">Refund Policy</a></li>
              <li><a href="{{ url('/') }}#contact">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <small>&copy; <span id="year"></span> Digirisers. All rights reserved.</small>
        <small class="footer-links">
          <a href="{{ url('/pricing') }}">Pricing</a> <span>&bull;</span>
          <a href="{{ url('/privacy') }}">Privacy</a> <span>&bull;</span>
          <a href="{{ url('/terms') }}">Terms</a> <span>&bull;</span>
          <a href="{{ url('/refund') }}">Refund</a>
        </small>
      </div>
    </div>
  </footer>

@endsection

@push('scripts')
  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
    const navEl = document.getElementById('nav');
    const toggle = document.getElementById('navToggle');
    toggle.addEventListener('click', () => {
      const open = navEl.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  </script>
@endpush
