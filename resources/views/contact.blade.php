@extends('layouts.app')

@section('title', 'Contact — Digirisers')
@section('description', 'Talk to a senior strategist at Digirisers. Tell us where you want to grow and we will reach out with next steps.')

@push('styles')
  {{-- legal.css is the shared base layer (CSS variables, .btn, .container,
       footer styles). Every other page links it; the contact page was missing
       it, which is what made the header/footer look misaligned. --}}
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    /* Contact page — scoped (.cp-*). Reuses the same field names + IDs as
       the homepage hero lead form (#leadForm) so both submit the same
       payload shape to /lead/submit (GSHEET_LEAD_URL). */
    .cp-shell {
      background: #f5f8ff;
      padding: 80px 0 100px;
      position: relative; overflow: hidden;
    }
    .cp-shell::before {
      content: ""; position: absolute; inset: 0; pointer-events: none;
      background:
        radial-gradient(ellipse 60% 60% at 20% 10%, rgba(96,165,250,.18), transparent 60%),
        radial-gradient(ellipse 50% 50% at 90% 90%, rgba(30,58,138,.14), transparent 60%);
    }
    .cp-wrap {
      position: relative; z-index: 1;
      max-width: 1240px; margin: 0 auto;
      padding: 0 24px;
      display: grid; grid-template-columns: 1fr 520px;
      gap: 48px;
      align-items: start;
    }

    .cp-pitch h1 {
      font-size: clamp(2.1rem, 3.6vw, 3rem);
      letter-spacing: -0.035em; line-height: 1.05;
      color: #0b1020; margin: 14px 0 16px;
    }
    .cp-pitch h1 .serif-italic {
      font-family: 'Instrument Serif', ui-serif, Georgia, serif;
      font-style: italic; font-weight: 400; color: #1d4ed8;
    }
    .cp-pitch p {
      font-size: 1.05rem; color: #475569; line-height: 1.6;
      max-width: 540px; margin: 0 0 28px;
    }
    .cp-eyebrow {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: .72rem; font-weight: 700; letter-spacing: .14em;
      text-transform: uppercase;
      color: #1d4ed8; background: #eff6ff;
      padding: 6px 12px; border-radius: 999px;
    }
    .cp-eyebrow::before {
      content: ""; width: 7px; height: 7px; border-radius: 50%;
      background: #2563eb; box-shadow: 0 0 0 3px #dbeafe;
    }

    .cp-points {
      list-style: none; margin: 0 0 32px; padding: 0;
      display: grid; gap: 12px;
      max-width: 540px;
    }
    .cp-points li {
      display: flex; align-items: flex-start; gap: 12px;
      font-size: .95rem; color: #334155; line-height: 1.55;
    }
    .cp-points li svg {
      flex-shrink: 0; margin-top: 3px;
      width: 18px; height: 18px;
      color: #16a34a;
    }
    .cp-points strong { color: #0b1020; font-weight: 600; }

    .cp-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 22px;
      padding: 30px 28px 26px;
      box-shadow:
        0 50px 100px -40px rgba(11, 16, 32, .25),
        0 8px 24px -8px rgba(11, 16, 32, .06);
    }
    .cp-card h3 {
      font-size: 1.4rem; font-weight: 700; color: #0b1020;
      margin: 0 0 6px; letter-spacing: -0.025em;
    }
    .cp-card h3 .serif-italic {
      font-family: 'Instrument Serif', ui-serif, Georgia, serif;
      font-style: italic; font-weight: 400; color: #1d4ed8;
    }
    .cp-card > p {
      font-size: .92rem; color: #475569; margin: 0 0 18px; line-height: 1.5;
    }

    .cp-card form { display: grid; gap: 12px; }
    .cp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .cp-card label {
      display: block; margin-bottom: 5px;
      font-size: .74rem; font-weight: 600;
      color: #475569; letter-spacing: .02em;
    }
    .cp-card input,
    .cp-card select,
    .cp-card textarea {
      width: 100%; padding: 11px 13px;
      font: inherit; font-size: .92rem;
      color: #0b1020; background: #fff;
      border: 1.5px solid #e5e7eb; border-radius: 10px;
      transition: border-color .2s ease, box-shadow .2s ease;
    }
    .cp-card textarea { resize: vertical; min-height: 80px; }
    .cp-card input:focus,
    .cp-card select:focus,
    .cp-card textarea:focus {
      outline: none; border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, .18);
    }

    .cp-consents { display: grid; gap: 8px; margin-top: 4px; }
    .cp-consent {
      display: flex; align-items: flex-start; gap: 10px;
      font-size: .78rem; color: #475569; line-height: 1.45;
      cursor: pointer;
    }
    .cp-consent input[type="checkbox"] {
      width: 16px; height: 16px; margin-top: 2px;
      accent-color: #2563eb; flex-shrink: 0;
      padding: 0;
    }
    .cp-consent strong { color: #0b1020; font-weight: 600; }
    .cp-consent .req {
      display: inline-block; margin-left: 6px;
      font-size: .68rem; font-weight: 700; font-style: normal;
      color: #b91c1c; background: #fef2f2;
      padding: 1px 7px; border-radius: 999px;
      letter-spacing: .04em; text-transform: uppercase;
    }

    .cp-submit {
      width: 100%; padding: 14px 18px;
      border: 0; border-radius: 12px;
      font: inherit; font-size: .98rem; font-weight: 600;
      color: #fff;
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      box-shadow: 0 14px 30px -10px rgba(37, 99, 235, .55);
      cursor: pointer;
      transition: transform .2s ease, box-shadow .25s ease;
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      margin-top: 6px;
    }
    .cp-submit:hover { transform: translateY(-1px); box-shadow: 0 20px 38px -10px rgba(37,99,235,.6); }
    .cp-submit:disabled { opacity: .65; cursor: not-allowed; transform: none; }

    .cp-foot {
      margin: 12px 0 0;
      font-size: .76rem; color: #64748b;
      text-align: center; line-height: 1.5;
    }

    .cp-success {
      display: none;
      text-align: center;
      padding: 28px 8px 8px;
    }
    .cp-success.show { display: block; animation: cp-success-in .4s ease both; }
    @keyframes cp-success-in {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .cp-success svg {
      width: 56px; height: 56px;
      color: #16a34a; background: #dcfce7;
      border-radius: 50%; padding: 12px;
      margin-bottom: 14px;
    }
    .cp-success h4 { font-size: 1.15rem; color: #0b1020; margin: 0 0 6px; font-weight: 700; }
    .cp-success p { font-size: .92rem; color: #475569; margin: 0; }

    @media (max-width: 980px) {
      .cp-wrap { grid-template-columns: 1fr; gap: 32px; }
      .cp-shell { padding: 60px 0 80px; }
    }
    @media (max-width: 480px) {
      .cp-card { padding: 24px 20px 22px; }
      .cp-row { grid-template-columns: 1fr; }
    }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <main class="cp-shell">
    <div class="cp-wrap">

      <section class="cp-pitch">
        <span class="cp-eyebrow">Contact</span>
        <h1>Talk to a <span class="serif-italic">senior strategist.</span></h1>
        <p>Tell us where you want to grow. A senior strategist will follow up to scope the engagement, share relevant case studies, and walk you through the next steps. No pitch decks, no spam — just a focused conversation.</p>

        <ul class="cp-points">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>Reply within one business day</strong> — usually faster on weekdays.</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>Senior team owns it.</strong> You'll speak with the person who'd actually run your account.</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>No obligation.</strong> If we're not the right fit we'll tell you and recommend who is.</span>
          </li>
        </ul>
      </section>

      <aside class="cp-card" id="contact">
        <h3>Start your <span class="serif-italic">growth plan.</span></h3>
        <p>Share a few details and we'll be in touch.</p>

        <form id="leadForm" novalidate>
          <div>
            <label for="name">Your name</label>
            <input type="text" id="name" name="name" placeholder="Jane Doe" autocomplete="name" required />
          </div>
          <div class="cp-row">
            <div>
              <label for="email">Work email</label>
              <input type="email" id="email" name="email" placeholder="jane@company.com" autocomplete="email" required />
            </div>
            <div>
              <label for="phone">Phone</label>
              <input type="tel" id="phone" name="phone" placeholder="+1 555 000 0000" autocomplete="tel" required />
            </div>
          </div>
          <div>
            <label for="service">Primary interest</label>
            <select id="service" name="service" required>
              <option value="">Select a service</option>
              <option>Development — Websites &amp; Funnels</option>
              <option>Grow — SEO, Ads &amp; Social</option>
              <option>Automations — AI &amp; CRM</option>
              <option>Security — Hosting &amp; Infrastructure</option>
              <option>Branding — Identity &amp; Creative</option>
              <option>Full-funnel growth</option>
            </select>
          </div>
          <div>
            <label for="message">What are you trying to grow?</label>
            <textarea id="message" name="message" rows="3" placeholder="A few words about your goals…"></textarea>
          </div>

          <div class="cp-consents">
            <label class="cp-consent">
              <input type="checkbox" id="consentTx" name="consentTx" required />
              <span>I agree to receive non-marketing texts from <strong>Digirisers</strong> about my request. Reply STOP to opt out.<em class="req">required</em></span>
            </label>
            <label class="cp-consent">
              <input type="checkbox" id="consentMk" name="consentMk" required />
              <span>I agree to receive marketing messages from <strong>Digirisers</strong> at the number provided. Reply STOP to opt out.<em class="req">required</em></span>
            </label>
          </div>

          <button type="submit" class="cp-submit">
            Send my request
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </button>
          <p class="cp-foot">No spam. We only reply about your request.</p>
        </form>

        <div class="cp-success" id="leadSuccess" role="status" aria-live="polite">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          <h4>Thanks — we got it.</h4>
          <p>A senior strategist will reach out shortly to book your discovery call.</p>
        </div>
      </aside>

    </div>
  </main>

  @include('partials.footer')
@endsection

@push('scripts')
  <script>
    /* Submits to /lead/submit (the same endpoint and Google Sheet, GSHEET_LEAD_URL,
       used by the homepage hero lead form). Mirrors that form's payload shape. */
    (function () {
      const LEAD_URL   = "{{ route('lead.submit') }}";
      const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
      const form    = document.getElementById('leadForm');
      const success = document.getElementById('leadSuccess');
      if (!form) return;

      // If the visitor came from the shop cart, prefill the message with the cart contents.
      try {
        const params = new URLSearchParams(window.location.search);
        if (params.get('cart') === '1') {
          const raw = localStorage.getItem('digi_cart_v2');
          const cart = raw ? JSON.parse(raw) : [];
          if (Array.isArray(cart) && cart.length) {
            const fmt = (n) => '$' + Number(n).toLocaleString('en-US');
            const cycleLabel = { project: 'one-time', mo: '/month', week: '/week' };
            const lines = ['Order request:', ''];
            cart.forEach((item, i) => {
              lines.push(`${i + 1}. ${item.name} — ${fmt(item.price)} ${cycleLabel[item.cycle] || item.cycle || ''}`);
            });
            const msg = document.getElementById('message');
            if (msg) msg.value = lines.join('\n');
            const svc = document.getElementById('service');
            if (svc && !svc.value) svc.value = 'Full-funnel growth';
          }
        }
      } catch (e) { /* ignore */ }

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const data = new FormData(form);
        const name    = (data.get('name')    || '').toString().trim();
        const email   = (data.get('email')   || '').toString().trim();
        const phone   = (data.get('phone')   || '').toString().trim();
        const service = (data.get('service') || '').toString().trim();
        const message = (data.get('message') || '').toString().trim();
        const consentTx = form.querySelector('#consentTx').checked;
        const consentMk = form.querySelector('#consentMk').checked;

        if (!name || !email || !phone || !service) {
          alert('Please fill in your name, email, phone, and primary interest.');
          return;
        }
        if (!consentTx) {
          alert('Please accept the non-marketing text message consent to continue.');
          form.querySelector('#consentTx').focus();
          return;
        }
        if (!consentMk) {
          alert('Please accept the marketing text message consent to continue.');
          form.querySelector('#consentMk').focus();
          return;
        }

        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = 'Submitting…';

        const sheetPayload = new FormData();
        sheetPayload.append('name',       name);
        sheetPayload.append('email',      email);
        sheetPayload.append('phone',      phone);
        sheetPayload.append('service',    service);
        sheetPayload.append('message',    message);
        sheetPayload.append('consent_tx', 'yes');
        sheetPayload.append('consent_mk', 'yes');
        sheetPayload.append('page',       window.location.pathname);
        try {
          await fetch(LEAD_URL, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
              'Accept':           'application/json',
              'X-CSRF-TOKEN':     CSRF_TOKEN,
              'X-Requested-With': 'XMLHttpRequest',
            },
            body: sheetPayload,
          });
        } catch (err) {
          console.warn('Lead sync failed', err);
        }

        // Clear cart after successful checkout so a refresh starts clean.
        try {
          if (new URLSearchParams(window.location.search).get('cart') === '1') {
            localStorage.removeItem('digi_cart_v2');
          }
        } catch (e) {}

        form.hidden = true;
        if (success) success.classList.add('show');
        btn.disabled = false;
        btn.innerHTML = originalHTML;
      });
    })();
  </script>
@endpush
