@extends('layouts.app')

@section('title', 'Privacy Policy — Digirisers')
@section('description', 'Privacy Policy for Digirisers — how we collect, use, and protect your information.')
@section('robots', 'index,follow')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
@endpush

@section('content')

  @include('partials.header')

  <section class="legal-hero">
    <div class="container legal-hero-inner">
      <span class="eyebrow"><span class="dot"></span><span>Legal</span></span>
      <h1>Privacy <span class="serif-italic">policy</span></h1>
      <p>This policy explains what information Digirisers collects, why we collect it, and the choices you have. We aim to keep this honest, brief, and free of legalese.</p>
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
          <li><a href="#overview">1. Overview</a></li>
          <li><a href="#information-we-collect">2. Information we collect</a></li>
          <li><a href="#how-we-use">3. How we use information</a></li>
          <li><a href="#legal-bases">4. Legal bases (EU/UK)</a></li>
          <li><a href="#cookies">5. Cookies & tracking</a></li>
          <li><a href="#sharing">6. How we share information</a></li>
          <li><a href="#international">7. International transfers</a></li>
          <li><a href="#retention">8. Data retention</a></li>
          <li><a href="#security">9. Security</a></li>
          <li><a href="#your-rights">10. Your rights</a></li>
          <li><a href="#california">11. California (CCPA/CPRA)</a></li>
          <li><a href="#children">12. Children</a></li>
          <li><a href="#changes">13. Changes to this policy</a></li>
          <li><a href="#contact">14. Contact us</a></li>
        </ul>
      </aside>

      <article class="legal-article">

        <h2 id="overview">1. Overview</h2>
        <p>Digirisers ("Digirisers," "we," "us," or "our") provides digital marketing services including SEO, paid media, web design, content, social, email, and AI-powered growth solutions. This Privacy Policy applies to the personal information we collect through our website, our marketing communications, and our services.</p>
        <p>By using our website or engaging us as a service provider, you agree to the practices described here. If you do not agree, please do not use our site or services.</p>

        <h2 id="information-we-collect">2. Information we collect</h2>
        <p>We collect information in three broad categories:</p>

        <div class="def-grid">
          <div class="def">
            <h4>You provide</h4>
            <p>Name, email, phone, company, role, billing details, and the content of messages or briefs you send us.</p>
          </div>
          <div class="def">
            <h4>Automatically</h4>
            <p>Device, browser, IP address, pages viewed, referrers, time-on-page, and other analytics signals.</p>
          </div>
          <div class="def">
            <h4>From partners</h4>
            <p>Data from advertising platforms, analytics tools, payment processors, and CRMs you authorize us to use.</p>
          </div>
        </div>

        <h3>Information you give us directly</h3>
        <ul>
          <li><strong>Contact details</strong> — name, work email, phone number, and company.</li>
          <li><strong>Project information</strong> — the goals, briefs, assets, and feedback you share with us as part of an engagement.</li>
          <li><strong>Billing details</strong> — billing address and tax/VAT information. Card and bank data is handled directly by our payment processor and never stored on our servers.</li>
          <li><strong>Account data</strong> — credentials and tokens you grant us to access tools (e.g. Google Ads, Meta Business, Search Console, Shopify) for the duration of the work.</li>
        </ul>

        <h3>Information collected automatically</h3>
        <ul>
          <li><strong>Device & browser</strong> — type, operating system, language, screen size.</li>
          <li><strong>Network</strong> — IP address and approximate location derived from it.</li>
          <li><strong>Usage</strong> — pages visited, time on page, links clicked, referring URL, and aggregated session activity.</li>
          <li><strong>Identifiers</strong> — first- and third-party cookies and similar technologies (see Section 5).</li>
        </ul>

        <h3>Information from third parties</h3>
        <p>If you authorize us to manage marketing assets on your behalf, we will receive data from those platforms (analytics, ad performance, audience segments, conversion events). We process this data only to perform the services you engaged us for.</p>

        <h2 id="how-we-use">3. How we use information</h2>
        <p>We use the information we collect to:</p>
        <ul>
          <li>Operate and improve our website and services;</li>
          <li>Respond to inquiries, schedule calls, and send proposals;</li>
          <li>Deliver, manage, and bill for engagements;</li>
          <li>Send transactional messages (account updates, invoices, project communications);</li>
          <li>Send marketing emails about our services to clients and prospects who have opted in (you can unsubscribe at any time);</li>
          <li>Personalize content, troubleshoot issues, prevent fraud, and enforce our Terms of Service;</li>
          <li>Comply with legal obligations and respond to lawful requests.</li>
        </ul>

        <h2 id="legal-bases">4. Legal bases for processing (EEA/UK)</h2>
        <p>If you are in the European Economic Area or the United Kingdom, we rely on the following legal bases under the GDPR/UK GDPR:</p>
        <ul>
          <li><strong>Contract</strong> — to deliver services you have asked us to perform.</li>
          <li><strong>Legitimate interests</strong> — to operate, secure, and improve our business; to communicate with prospects in a B2B context.</li>
          <li><strong>Consent</strong> — for non-essential cookies and certain marketing emails. You can withdraw consent at any time.</li>
          <li><strong>Legal obligation</strong> — to comply with tax, accounting, and other applicable laws.</li>
        </ul>

        <h2 id="cookies">5. Cookies & tracking technologies</h2>
        <p>We use cookies and similar technologies to make the site work, measure traffic, and (with your consent) personalize advertising. Categories include:</p>
        <ul>
          <li><strong>Strictly necessary</strong> — required for core functionality, security, and load balancing.</li>
          <li><strong>Analytics</strong> — measure traffic and content performance (e.g. Google Analytics, Microsoft Clarity).</li>
          <li><strong>Advertising</strong> — measure ad performance and (where permitted) deliver relevant advertising.</li>
        </ul>
        <p>You can control cookies through your browser settings, our cookie banner where shown, and platform opt-outs (e.g. <a href="https://adssettings.google.com" target="_blank" rel="noopener noreferrer">Google Ads Settings</a>). Disabling some cookies may affect site functionality.</p>

        <div class="callout">
          <strong>Do Not Track:</strong> Our site does not respond to DNT browser signals because no consistent industry standard has been adopted. We do honor opt-out preferences submitted through Global Privacy Control where required by law.
        </div>

        <h2 id="sharing">6. How we share information</h2>
        <p>We do not sell personal information. We share information only with:</p>
        <ul>
          <li><strong>Service providers</strong> who help us run our business — hosting, analytics, email, payments, CRM, project tooling — bound by confidentiality and data-processing terms.</li>
          <li><strong>Advertising platforms</strong> when you have asked us to manage campaigns on your behalf, only for the campaigns concerned.</li>
          <li><strong>Professional advisors</strong> such as accountants, auditors, and lawyers, where reasonably needed.</li>
          <li><strong>Authorities</strong> when required by law, subpoena, or to protect rights, safety, and property.</li>
          <li><strong>Acquirers</strong> in the event of a merger, acquisition, financing, or sale of assets — only as part of the transaction and subject to this policy.</li>
        </ul>

        <h2 id="international">7. International data transfers</h2>
        <p>Digirisers is based in the United States. Information you provide may be transferred to, stored, and processed in countries other than your own. Where required, we use Standard Contractual Clauses or other recognized transfer mechanisms to protect personal data leaving the EEA, UK, or Switzerland.</p>

        <h2 id="retention">8. Data retention</h2>
        <p>We keep personal information only as long as needed for the purposes described in this policy:</p>
        <ul>
          <li><strong>Project records</strong> — for the duration of the engagement and up to 7 years after, for tax and accounting purposes.</li>
          <li><strong>Website analytics</strong> — typically 14–26 months in aggregated form.</li>
          <li><strong>Marketing contacts</strong> — until you unsubscribe or 24 months of inactivity.</li>
          <li><strong>Backups</strong> — rolled out of backups within our standard retention cycle (typically 30–90 days).</li>
        </ul>

        <h2 id="security">9. Security</h2>
        <p>We use industry-standard administrative, technical, and physical safeguards to protect personal information — including encryption in transit, access controls, least-privilege permissions, secure credential storage, and regular vendor reviews. No method of transmission or storage is 100% secure; we work hard to protect your information but cannot guarantee absolute security.</p>

        <h2 id="your-rights">10. Your rights</h2>
        <p>Depending on where you live, you may have the right to:</p>
        <ul>
          <li>Access the personal information we hold about you;</li>
          <li>Correct inaccurate or incomplete information;</li>
          <li>Delete personal information, subject to legal exceptions;</li>
          <li>Restrict or object to certain processing;</li>
          <li>Receive a copy of your information in a portable format;</li>
          <li>Withdraw consent at any time, without affecting prior processing;</li>
          <li>Lodge a complaint with your local data protection authority.</li>
        </ul>
        <p>To exercise any of these rights, email <a href="mailto:info@digirisers.com">info@digirisers.com</a>. We will verify your identity and respond within the timeframe required by law (typically 30 days).</p>

        <h2 id="california">11. California (CCPA/CPRA)</h2>
        <p>California residents have the right to know, delete, correct, and opt out of the "sale" or "sharing" of personal information, and to limit use of sensitive personal information. We do not sell personal information for money. To make a request, contact us using the details in Section 14. We will not discriminate against you for exercising your rights.</p>

        <h2 id="children">12. Children</h2>
        <p>Our website and services are intended for businesses and adults. We do not knowingly collect personal information from children under 16. If you believe a child has given us information, please contact us and we will delete it.</p>

        <h2 id="changes">13. Changes to this policy</h2>
        <p>We may update this Privacy Policy from time to time. The "Last updated" date at the top of the page reflects the most recent revision. Material changes will be communicated via the website or, where required, by email. Continued use of our website or services after changes take effect constitutes acceptance of the updated policy.</p>

        <h2 id="contact">14. Contact us</h2>
        <p>For questions about this policy or to exercise any of your rights, please reach out:</p>

        <div class="legal-contact">
          <h3>Privacy questions?</h3>
          <p>We aim to respond to all privacy inquiries within five business days.</p>
          <div class="lc-row">
            <span>Email <a href="mailto:info@digirisers.com">info@digirisers.com</a></span>
            <span>Phone <a href="tel:+14019987807">+1 (401) 998-7807</a></span>
          </div>
        </div>

      </article>
    </div>
  </section>

  @php($hideFooterCta = true)
  @include('partials.footer')

@endsection
