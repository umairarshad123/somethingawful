@extends('layouts.app')

@section('title', 'Terms and Conditions — Digirisers')
@section('description', 'Terms and Conditions for Digirisers — the rules and responsibilities for engaging our digital marketing services.')
@section('robots', 'index,follow')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
@endpush

@section('content')

  @include('partials.header')

  <section class="legal-hero">
    <div class="container legal-hero-inner">
      <span class="eyebrow"><span class="dot"></span><span>Legal</span></span>
      <h1>Terms <span class="serif-italic">and</span> conditions</h1>
      <p>These terms govern your use of the Digirisers website and the digital marketing services we provide. Please read them carefully — by working with us, you agree to be bound by them.</p>
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
          <li><a href="#acceptance">1. Acceptance</a></li>
          <li><a href="#services">2. Services</a></li>
          <li><a href="#engagements">3. Engagements & SOWs</a></li>
          <li><a href="#fees">4. Fees & payment</a></li>
          <li><a href="#client-responsibilities">5. Client responsibilities</a></li>
          <li><a href="#third-party">6. Third-party platforms</a></li>
          <li><a href="#ip">7. Intellectual property</a></li>
          <li><a href="#confidentiality">8. Confidentiality</a></li>
          <li><a href="#publicity">9. Publicity</a></li>
          <li><a href="#warranties">10. Warranties & disclaimers</a></li>
          <li><a href="#liability">11. Limitation of liability</a></li>
          <li><a href="#indemnification">12. Indemnification</a></li>
          <li><a href="#termination">13. Termination</a></li>
          <li><a href="#governing-law">14. Governing law</a></li>
          <li><a href="#changes">15. Changes</a></li>
          <li><a href="#contact">16. Contact</a></li>
        </ul>
      </aside>

      <article class="legal-article">

        <h2 id="acceptance">1. Acceptance of these terms</h2>
        <p>These Terms and Conditions ("Terms") form a legally binding agreement between you ("Client," "you," or "your") and Digirisers ("Digirisers," "we," "us," or "our"). By accessing our website, requesting a proposal, or signing a Statement of Work with us, you confirm that you have read, understood, and agreed to be bound by these Terms and our <a href="{{ url('/privacy') }}">Privacy Policy</a>.</p>
        <p>If you are entering into these Terms on behalf of a company or other entity, you represent that you have authority to bind that entity.</p>

        <h2 id="services">2. Services we provide</h2>
        <p>Digirisers offers digital marketing services including, but not limited to:</p>
        <ul>
          <li>Search engine optimization (SEO) and content strategy;</li>
          <li>Pay-per-click advertising (Google Ads, Microsoft Ads, Meta, LinkedIn, TikTok);</li>
          <li>Web design, development, and conversion-rate optimization;</li>
          <li>Email marketing, marketing automation, and lifecycle programs;</li>
          <li>Social media management and content production;</li>
          <li>Ecommerce growth (Shopify, WooCommerce, Amazon);</li>
          <li>AI-assisted content, agents, and analytics solutions.</li>
        </ul>
        <p>Specific deliverables, timelines, and outcomes for each engagement are defined in the Statement of Work ("SOW") or proposal accepted by both parties.</p>

        <h2 id="engagements">3. Engagements & Statements of Work</h2>
        <p>Each engagement is governed by an SOW that incorporates these Terms by reference. The SOW will describe the scope, deliverables, timeline, fees, and any project-specific terms. In the event of a conflict between these Terms and an SOW, the SOW controls for that engagement.</p>
        <p><strong>Scope changes:</strong> Work outside the agreed scope ("change requests") will be quoted separately and require written approval before we proceed.</p>

        <h2 id="fees">4. Fees, invoicing & payment</h2>
        <ul>
          <li><strong>Retainers</strong> are billed monthly in advance unless stated otherwise.</li>
          <li><strong>Project work</strong> is typically billed 50% on kickoff and 50% on delivery; larger projects may be split into milestone payments.</li>
          <li><strong>Payment terms</strong> are <em>Net 7</em> from the invoice date unless the SOW specifies otherwise.</li>
          <li><strong>Late payments</strong> may incur a service fee of 1.5% per month or the maximum permitted by law, whichever is lower. We may pause work on accounts more than 14 days past due.</li>
          <li><strong>Ad spend</strong> on third-party platforms is paid directly by the Client to those platforms unless we agree in writing to manage spend on your behalf.</li>
          <li><strong>Taxes</strong> are the Client's responsibility, except for taxes on our net income.</li>
          <li><strong>Currency:</strong> Invoices are issued in USD unless otherwise specified.</li>
        </ul>

        <h2 id="client-responsibilities">5. Client responsibilities</h2>
        <p>To deliver our services on time and on quality, we rely on your cooperation. You agree to:</p>
        <ul>
          <li>Provide timely access to assets, brand guidelines, accounts, and stakeholders;</li>
          <li>Respond to questions, drafts, and approvals within reasonable timeframes (typically 3 business days);</li>
          <li>Ensure that any content, trademarks, or data you supply do not infringe third-party rights;</li>
          <li>Comply with the policies of all advertising and analytics platforms used in your engagement;</li>
          <li>Pay invoices on time per Section 4.</li>
        </ul>
        <p>Delays or non-cooperation that materially affect the project timeline may shift delivery dates and, where appropriate, fees.</p>

        <h2 id="third-party">6. Third-party platforms & services</h2>
        <p>Our services rely on third-party platforms (e.g., Google, Meta, LinkedIn, Shopify, hosting providers, email service providers). You acknowledge that:</p>
        <ul>
          <li>We do not control these platforms and are not responsible for their availability, policies, or pricing;</li>
          <li>Algorithm changes, account suspensions, ad-policy reviews, and platform fees may affect outcomes;</li>
          <li>You are responsible for compliance with each platform's terms of service and acceptable use policies.</li>
        </ul>

        <h2 id="ip">7. Intellectual property</h2>
        <h3>Our pre-existing IP</h3>
        <p>Digirisers retains all rights, title, and interest in and to our pre-existing tools, frameworks, methodologies, code libraries, templates, and know-how ("Background IP"). Nothing in these Terms transfers ownership of our Background IP.</p>
        <h3>Deliverables</h3>
        <p>Upon receipt of full payment for an engagement, Digirisers grants Client a worldwide, non-exclusive, perpetual license to use the deliverables created specifically for Client under that engagement for Client's internal business purposes. Custom deliverables (e.g., designs, copy, code) created uniquely for the Client become Client property upon full payment, except for any embedded Background IP, which remains licensed as described above.</p>
        <h3>Client materials</h3>
        <p>Client retains all rights to materials supplied to us (logos, brand assets, content, data) and grants us a limited license to use them solely for delivering the agreed services.</p>

        <h2 id="confidentiality">8. Confidentiality</h2>
        <p>Each party agrees to keep the other's non-public business, financial, and technical information confidential and use it only for the purposes of the engagement. Confidential information does not include information that is public, was already known, or is independently developed without reference to the other party's information. Confidentiality obligations survive termination for three (3) years.</p>

        <h2 id="publicity">9. Publicity & portfolio rights</h2>
        <p>Unless you ask us in writing not to, Digirisers may identify you as a client and display your logo and a high-level description of the work in our marketing materials, portfolio, and case studies. We will not disclose confidential metrics or strategies without your prior consent.</p>

        <h2 id="warranties">10. Warranties & disclaimers</h2>
        <p>Digirisers will perform the services with reasonable skill, care, and professionalism in accordance with industry standards.</p>
        <div class="callout">
          <strong>No guarantees of results:</strong> Digital marketing outcomes depend on many factors outside our control, including market conditions, third-party platform behavior, competitor activity, product-market fit, and your responsiveness. We do not guarantee specific rankings, traffic, leads, revenue, or ROI. Any forecasts are good-faith estimates, not promises.
        </div>
        <p>EXCEPT AS EXPRESSLY STATED, OUR SERVICES AND DELIVERABLES ARE PROVIDED "AS IS" AND WE DISCLAIM ALL OTHER WARRANTIES, EXPRESS OR IMPLIED, INCLUDING WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, NON-INFRINGEMENT, AND ACCURACY OF DATA.</p>

        <h2 id="liability">11. Limitation of liability</h2>
        <p>To the maximum extent permitted by law:</p>
        <ul>
          <li>Neither party is liable for indirect, incidental, special, consequential, or punitive damages, including lost profits, lost revenue, or lost data, even if advised of their possibility.</li>
          <li>Digirisers' total aggregate liability arising from or related to an engagement is limited to the fees paid by Client to Digirisers for the services giving rise to the claim during the three (3) months immediately before the claim arose.</li>
          <li>These limitations do not apply to liability for fraud, gross negligence, willful misconduct, or any liability that cannot be limited by applicable law.</li>
        </ul>

        <h2 id="indemnification">12. Indemnification</h2>
        <p>Client agrees to defend, indemnify, and hold Digirisers harmless from any third-party claim arising out of (a) materials Client provides; (b) Client's products, services, or business operations; (c) Client's violation of any third-party platform terms; or (d) Client's breach of these Terms. Digirisers will defend, indemnify, and hold Client harmless from any third-party claim that our deliverables, as delivered and unmodified, infringe a U.S. intellectual property right.</p>

        <h2 id="termination">13. Termination</h2>
        <ul>
          <li><strong>By Client:</strong> You may terminate a retainer with thirty (30) days' written notice. Project engagements may be terminated as set out in the SOW.</li>
          <li><strong>By Digirisers:</strong> We may terminate immediately if Client breaches these Terms, fails to pay an invoice for more than 14 days after written notice, or engages in unlawful or unethical conduct.</li>
          <li><strong>Effect:</strong> Upon termination, Client pays for all services performed and expenses incurred through the termination date. Sections 4, 7–12, and 14 survive termination.</li>
        </ul>

        <h2 id="governing-law">14. Governing law & dispute resolution</h2>
        <p>These Terms are governed by the laws of the State of Delaware, USA, without regard to its conflict-of-laws principles. The parties will first attempt to resolve any dispute through good-faith negotiation. If unresolved within 30 days, the dispute will be submitted to binding arbitration administered by the American Arbitration Association in Wilmington, Delaware, and conducted in English. Notwithstanding the foregoing, either party may seek injunctive relief in any court of competent jurisdiction to protect its intellectual property or confidential information.</p>

        <h2 id="changes">15. Changes to these Terms</h2>
        <p>We may update these Terms from time to time. The "Last updated" date at the top of the page reflects the most recent version. Material changes will be communicated via the website or by email to active clients. Continued engagement after changes take effect constitutes acceptance of the updated Terms.</p>

        <h2 id="contact">16. Contact</h2>
        <p>Questions about these Terms? Get in touch — we're happy to clarify anything before you sign.</p>

        <div class="legal-contact">
          <h3>Talk to us before you sign</h3>
          <p>Digirisers operates in the United States. We respond to legal and contract inquiries within five business days.</p>
          <div class="lc-row">
            <span>Email <a href="mailto:info@digirisers.com">info@digirisers.com</a></span>
            <span>Web <a href="{{ route('contact') }}">{{ url('/contact') }}</a></span>
          </div>
        </div>

      </article>
    </div>
  </section>

  @php($hideFooterCta = true)
  @include('partials.footer')

@endsection
