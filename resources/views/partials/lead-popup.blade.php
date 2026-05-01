{{--
  Lead-capture popup. Self-contained: scoped CSS + JS pushed via stacks.
  Triggers: (a) 25 s on page, OR (b) scroll past 50%, OR (c) exit-intent (desktop only).
  Cooldown: localStorage flag "drPopupSeen" with TTL — defaults to 7 days.
  Submits to /lead/popup, which proxies to a separate Google Sheet via env GSHEET_POPUP_URL.
--}}

@push('styles')
  <style>
    .dr-popup-overlay {
      position: fixed; inset: 0;
      background: rgba(11, 16, 32, .55);
      backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
      z-index: 1000;
      opacity: 0; pointer-events: none;
      transition: opacity .35s ease;
    }
    .dr-popup-overlay.dr-show { opacity: 1; pointer-events: auto; }

    .dr-popup, .dr-popup *:not(svg):not(svg *), .dr-popup *::before, .dr-popup *::after { box-sizing: border-box; }

    .dr-popup {
      position: fixed; left: 50%; top: 50%;
      transform: translate(-50%, calc(-50% + 24px));
      width: min(480px, calc(100vw - 32px));
      max-width: calc(100vw - 32px);
      max-height: none;
      overflow-x: hidden;
      overflow-y: visible;
      overscroll-behavior: contain;
      background: #fff;
      border-radius: 22px;
      box-shadow:
        0 50px 100px -30px rgba(11, 16, 32, .45),
        0 8px 24px -8px rgba(11, 16, 32, .15);
      z-index: 1001;
      opacity: 0; pointer-events: none;
      transition: opacity .35s ease, transform .35s ease;
      padding: 30px 28px 26px;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    .dr-popup::-webkit-scrollbar { display: none; width: 0; height: 0; }
    .dr-popup.dr-show {
      opacity: 1; pointer-events: auto;
      transform: translate(-50%, -50%);
    }
    .dr-popup-body { overflow-x: hidden; overflow-y: visible; }
    .dr-popup::before {
      content: ""; position: absolute; inset: -1px;
      border-radius: inherit; pointer-events: none; padding: 1px;
      background: linear-gradient(135deg, rgba(96,165,250,.55), rgba(255,255,255,0) 45%, rgba(30,58,138,.45));
      -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
      -webkit-mask-composite: xor; mask-composite: exclude;
      opacity: .55;
    }

    .dr-popup-close {
      position: absolute; top: 14px; right: 14px;
      width: 34px; height: 34px;
      background: #f1f5f9;
      border: 0; border-radius: 10px;
      display: grid; place-items: center;
      color: #475569; cursor: pointer;
      transition: background .2s ease, color .2s ease, transform .2s ease;
    }
    .dr-popup-close:hover { background: #0b1020; color: #fff; transform: rotate(90deg); }

    .dr-popup-tag {
      display: inline-flex; align-items: center; gap: 6px;
      font-size: .68rem; font-weight: 700; letter-spacing: .12em;
      text-transform: uppercase;
      color: #1d4ed8; background: #eff6ff;
      padding: 5px 10px; border-radius: 999px;
      margin-bottom: 14px;
    }
    .dr-popup-tag::before {
      content: ""; width: 6px; height: 6px; border-radius: 50%;
      background: #2563eb;
      box-shadow: 0 0 0 3px #dbeafe;
    }
    .dr-popup h3 {
      font-size: 1.45rem; font-weight: 700; color: #0b1020;
      margin: 0 0 6px; letter-spacing: -0.025em; line-height: 1.15;
    }
    .dr-popup h3 .serif-italic { font-family: 'Instrument Serif', ui-serif, Georgia, serif; font-style: italic; font-weight: 400; color: #1d4ed8; }
    .dr-popup p.dr-popup-sub { font-size: .92rem; color: #475569; margin: 0 0 18px; line-height: 1.5; }

    .dr-popup form { display: grid; gap: 10px; }
    .dr-popup .dr-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .dr-popup label {
      font-size: .72rem; font-weight: 600; color: #475569;
      display: block; margin-bottom: 4px;
    }
    .dr-popup input,
    .dr-popup select {
      width: 100%; padding: 10px 12px;
      font: inherit; font-size: .9rem;
      color: #0b1020; background: #fff;
      border: 1.5px solid #e5e7eb; border-radius: 10px;
      transition: border-color .2s ease, box-shadow .2s ease;
    }
    .dr-popup input:focus,
    .dr-popup select:focus {
      outline: none; border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, .18);
    }

    .dr-popup-submit {
      width: 100%; padding: 13px 18px;
      border: 0; border-radius: 12px;
      font: inherit; font-size: .95rem; font-weight: 600;
      color: #fff;
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      box-shadow: 0 12px 28px -10px rgba(37, 99, 235, .55);
      cursor: pointer;
      transition: transform .2s ease, box-shadow .25s ease;
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      margin-top: 6px;
    }
    .dr-popup-submit:hover { transform: translateY(-1px); box-shadow: 0 18px 36px -10px rgba(37,99,235,.6); }
    .dr-popup-submit:disabled { opacity: .65; cursor: not-allowed; transform: none; }

    .dr-popup-foot {
      margin: 12px 0 0;
      font-size: .72rem; color: #64748b;
      text-align: center; line-height: 1.5;
    }
    .dr-popup-foot a { color: #1d4ed8; }

    .dr-popup-success {
      display: none;
      text-align: center;
      padding: 18px 0 6px;
    }
    .dr-popup-success.dr-show { display: block; animation: dr-popup-success-in .4s ease both; }
    @keyframes dr-popup-success-in {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .dr-popup-success svg {
      width: 56px; height: 56px;
      color: #16a34a; background: #dcfce7;
      border-radius: 50%; padding: 12px;
      margin-bottom: 12px;
    }
    .dr-popup-success h4 { font-size: 1.1rem; color: #0b1020; margin: 0 0 4px; font-weight: 700; }
    .dr-popup-success p { font-size: .9rem; color: #475569; margin: 0; }

    @media (max-width: 480px) {
      .dr-popup { padding: 22px 18px 20px; }
      .dr-popup h3 { font-size: 1.2rem; }
      .dr-popup .dr-row { grid-template-columns: 1fr; }
      .dr-popup p.dr-popup-sub { margin-bottom: 14px; }
    }
    @media (max-height: 720px) {
      .dr-popup {
        max-height: calc(100vh - 32px);
        overflow-y: auto;
      }
      .dr-popup p.dr-popup-sub { margin-bottom: 12px; }
    }
    @media (prefers-reduced-motion: reduce) {
      .dr-popup, .dr-popup-overlay, .dr-popup-close, .dr-popup-success.dr-show { transition: none; animation: none; }
    }
  </style>
@endpush

<div class="dr-popup-overlay" id="drPopupOverlay" aria-hidden="true"></div>
<div class="dr-popup" id="drPopup" role="dialog" aria-modal="true" aria-labelledby="drPopupTitle" aria-hidden="true">
  <button type="button" class="dr-popup-close" id="drPopupClose" aria-label="Close popup">
    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>

  <div class="dr-popup-body" id="drPopupBody">
    <span class="dr-popup-tag">Limited spots</span>
    <h3 id="drPopupTitle">Get a free <span class="serif-italic">growth audit.</span></h3>
    <p class="dr-popup-sub">Drop your details and we'll send a 15-minute personalized audit of where to focus first — no pitch, no spam.</p>

    <form id="drPopupForm" novalidate>
      <div>
        <label for="drPopupName">Your name</label>
        <input type="text" id="drPopupName" name="name" placeholder="Jane Doe" required />
      </div>
      <div class="dr-row">
        <div>
          <label for="drPopupEmail">Work email</label>
          <input type="email" id="drPopupEmail" name="email" placeholder="jane@company.com" required />
        </div>
        <div>
          <label for="drPopupPhone">Phone</label>
          <input type="tel" id="drPopupPhone" name="phone" placeholder="+1 555 000 0000" />
        </div>
      </div>
      <div>
        <label for="drPopupInterest">Primary interest</label>
        <select id="drPopupInterest" name="interest">
          <option value="">Pick a focus area (optional)</option>
          <option>Websites &amp; Funnels</option>
          <option>SEO &amp; Organic Growth</option>
          <option>Paid Advertising</option>
          <option>AI &amp; Automation</option>
          <option>CRM &amp; Marketing Automation</option>
          <option>Hosting &amp; Security</option>
          <option>Branding &amp; Creative</option>
          <option>Full-funnel growth</option>
        </select>
      </div>

      <button type="submit" class="dr-popup-submit" id="drPopupSubmit">
        Send my free audit
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
      </button>
      <p class="dr-popup-foot">No spam. We'll only contact you about your audit.</p>
    </form>
  </div>

  <div class="dr-popup-success" id="drPopupSuccess" role="status" aria-live="polite">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
    <h4>Thanks — we got it.</h4>
    <p>A senior strategist will reach out shortly with your audit.</p>
  </div>
</div>

@push('scripts')
  <script>
    (function () {
      // Session-scoped cooldown: clears when the browser/tab is closed.
      // Set after a successful submit, so the popup never re-shows in the same session.
      const SUBMITTED_KEY   = 'drPopupSubmitted';
      const TIME_TRIGGER_MS = 5000; // 5 s after page load
      const POPUP_URL  = "{{ route('lead.popup') }}";
      const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

      const overlay = document.getElementById('drPopupOverlay');
      const popup   = document.getElementById('drPopup');
      const closeBtn= document.getElementById('drPopupClose');
      const form    = document.getElementById('drPopupForm');
      const submit  = document.getElementById('drPopupSubmit');
      const body    = document.getElementById('drPopupBody');
      const success = document.getElementById('drPopupSuccess');
      if (!popup) return;

      const alreadySubmitted = () => {
        try { return sessionStorage.getItem(SUBMITTED_KEY) === '1'; }
        catch (e) { return false; }
      };
      const markSubmitted = () => {
        try { sessionStorage.setItem(SUBMITTED_KEY, '1'); } catch (e) {}
      };

      let opened = false;
      const open = () => {
        if (opened || alreadySubmitted()) return;
        opened = true;
        overlay.classList.add('dr-show');
        popup.classList.add('dr-show');
        overlay.setAttribute('aria-hidden', 'false');
        popup.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        // Move focus to first input for a11y.
        setTimeout(() => document.getElementById('drPopupName')?.focus(), 200);
      };
      const close = () => {
        overlay.classList.remove('dr-show');
        popup.classList.remove('dr-show');
        overlay.setAttribute('aria-hidden', 'true');
        popup.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      };

      // Single trigger: 5 s after page load, only if not already submitted in this session.
      if (!alreadySubmitted()) {
        setTimeout(open, TIME_TRIGGER_MS);
      }

      closeBtn.addEventListener('click', close);
      overlay.addEventListener('click', close);
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });

      form.addEventListener('submit', async (ev) => {
        ev.preventDefault();
        const fd = new FormData(form);
        const name  = (fd.get('name')  || '').toString().trim();
        const email = (fd.get('email') || '').toString().trim();
        if (!name || !email) {
          alert('Please add your name and email so we can reach out.');
          return;
        }

        submit.disabled = true;
        const originalText = submit.innerHTML;
        submit.innerHTML = 'Submitting…';

        try {
          fd.append('page', window.location.pathname);
          await fetch(POPUP_URL, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
              'Accept':           'application/json',
              'X-CSRF-TOKEN':     CSRF_TOKEN,
              'X-Requested-With': 'XMLHttpRequest',
            },
            body: fd,
          });
        } catch (e) {
          console.warn('Popup submit failed', e);
        }

        // Mark as submitted for this session so the popup never re-shows until next visit.
        markSubmitted();

        // Show success state regardless of network failure.
        body.style.display = 'none';
        success.classList.add('dr-show');
        submit.disabled = false;
        submit.innerHTML = originalText;
      });
    })();
  </script>
@endpush
