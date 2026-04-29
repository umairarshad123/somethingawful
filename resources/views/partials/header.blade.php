{{--
  Mega Header Partial — Digirisers
  Used by: home, services, shop, pricing, privacy, terms, refund
  Provides: announcement bar + sticky nav with mega menu, plus mobile drawer
--}}

@push('styles')
  <style>
    /* =========================================
       Digirisers — Mega Header
       ========================================= */
    .announce { background: var(--ink, #0b1020); color: rgba(255,255,255,.9); font-size: .82rem; letter-spacing: .01em; }
    .announce-inner { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 10px 24px; }
    .announce a { color: var(--blue-300, #93c5fd); font-weight: 600; }
    .announce a:hover { color: #fff; }
    .pulse {
      width: 7px; height: 7px; border-radius: 50%;
      background: #22c55e;
      box-shadow: 0 0 0 0 rgba(34,197,94,.6);
      animation: pulse 2s ease-out infinite;
    }
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(34,197,94,.6); }
      70% { box-shadow: 0 0 0 8px rgba(34,197,94,0); }
      100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
    }

    /* Nav core (overrides any page-level .nav rules so the mega header is consistent everywhere) */
    .nav {
      position: sticky; top: 0; z-index: 100;
      background: rgba(255, 255, 255, .82);
      backdrop-filter: saturate(180%) blur(18px);
      -webkit-backdrop-filter: saturate(180%) blur(18px);
      border-bottom: 1px solid transparent;
      transition: border-color .3s ease, box-shadow .3s ease, background .3s ease;
    }
    .nav.scrolled {
      background: rgba(255, 255, 255, .92);
      border-bottom-color: var(--line, #e5e7eb);
      box-shadow: 0 4px 30px -12px rgba(11, 16, 32, .1);
    }
    .nav-inner { display: flex; align-items: center; justify-content: space-between; padding: 16px 0; gap: 24px; }
    .logo { display: inline-flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.28rem; letter-spacing: -0.02em; color: var(--ink, #0b1020); }
    .logo:hover { color: var(--ink, #0b1020); }
    .logo-mark { display: inline-grid; place-items: center; transition: transform .4s ease; }
    .logo:hover .logo-mark { transform: rotate(-6deg) scale(1.05); }
    .logo-dot { color: var(--blue-600, #2563eb); }

    .nav-links { display: flex; gap: 30px; font-weight: 500; font-size: .95rem; align-items: center; list-style: none; margin: 0; padding: 0; }
    .nav-links > li { position: relative; }
    .nav-links a, .nav-links button.nav-trigger {
      color: var(--muted, #475569);
      position: relative; padding: 6px 0;
      transition: color .2s ease;
      background: transparent; border: 0; cursor: pointer; font: inherit;
      display: inline-flex; align-items: center; gap: 4px;
    }
    .nav-links a:hover, .nav-links button.nav-trigger:hover, .nav-links li.has-mega:hover button.nav-trigger { color: var(--ink, #0b1020); }
    .nav-links a::after, .nav-links button.nav-trigger::after {
      content: ""; position: absolute; left: 0; right: 0; bottom: -2px;
      height: 2px; background: var(--blue-600, #2563eb);
      transform: scaleX(0); transform-origin: left; transition: transform .3s ease;
    }
    .nav-links a:hover::after, .nav-links button.nav-trigger:hover::after, .nav-links li.has-mega:hover button.nav-trigger::after { transform: scaleX(1); }
    .nav-trigger .caret { transition: transform .25s ease; }
    .nav-links li.has-mega:hover .caret, .nav-links li.has-mega.open .caret { transform: rotate(180deg); }
    .nav-links a.active { color: var(--ink, #0b1020); }
    .nav-links a.active::after { transform: scaleX(1); }

    .nav-right { display: flex; align-items: center; gap: 14px; }
    .nav-phone { display: inline-flex; align-items: center; gap: 7px; color: var(--muted, #475569); font-size: .92rem; font-weight: 500; padding: 8px 0; transition: color .2s ease; }
    .nav-phone:hover { color: var(--blue-700, #1d4ed8); }
    .nav-phone svg { color: var(--blue-600, #2563eb); }
    .nav-toggle { display: none; background: transparent; border: 0; width: 44px; height: 44px; padding: 0; cursor: pointer; }
    .nav-toggle span { display: block; width: 22px; height: 2px; background: var(--ink, #0b1020); margin: 6px auto; border-radius: 2px; transition: .3s; }

    /* ===== Mega Menu Panel ===== */
    .mega-panel {
      position: absolute; left: 50%; top: calc(100% + 8px);
      transform: translateX(-50%) translateY(8px);
      width: min(1180px, calc(100vw - 32px));
      background: #fff;
      border: 1px solid var(--line, #e5e7eb);
      border-radius: 24px;
      box-shadow: 0 30px 80px -20px rgba(11, 16, 32, .25), 0 8px 24px -8px rgba(11, 16, 32, .08);
      padding: 28px;
      opacity: 0; visibility: hidden;
      transition: opacity .25s ease, transform .25s ease, visibility .25s;
      z-index: 200;
    }
    .nav-links li.has-mega:hover .mega-panel,
    .nav-links li.has-mega:focus-within .mega-panel,
    .nav-links li.has-mega.open .mega-panel {
      opacity: 1; visibility: visible;
      transform: translateX(-50%) translateY(0);
    }
    .mega-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 18px;
    }
    .mega-col {
      display: flex; flex-direction: column;
      padding: 18px 16px;
      border-radius: 16px;
      background: var(--bg-soft, #f8fafc);
      border: 1px solid transparent;
      transition: border-color .25s ease, transform .25s ease, background .25s ease;
    }
    .mega-col:hover { border-color: var(--blue-200, #bfdbfe); background: #fff; transform: translateY(-2px); box-shadow: 0 8px 24px -12px rgba(30, 58, 138, .2); }
    .mega-icon {
      width: 38px; height: 38px; border-radius: 10px;
      background: var(--blue-50, #eff6ff); color: var(--blue-700, #1d4ed8);
      display: grid; place-items: center; flex-shrink: 0;
      margin-bottom: 12px;
      transition: background .25s ease, color .25s ease;
    }
    .mega-col:hover .mega-icon { background: var(--grad, linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%)); color: #fff; }
    .mega-col h6 {
      font-size: .92rem; font-weight: 700; color: var(--ink, #0b1020);
      margin: 0 0 4px; letter-spacing: -0.01em;
    }
    .mega-col p { font-size: .78rem; color: var(--soft, #64748b); margin: 0 0 14px; line-height: 1.4; }
    .mega-col ul { list-style: none; margin: 0 0 12px; padding: 0; display: grid; gap: 6px; }
    .mega-col li a {
      display: block; padding: 5px 8px; margin: 0 -8px;
      font-size: .82rem; color: var(--muted, #475569); line-height: 1.35;
      border-radius: 7px;
      transition: background .2s ease, color .2s ease;
    }
    .mega-col li a:hover { background: var(--blue-50, #eff6ff); color: var(--blue-800, #1e40af); }
    .mega-col li a::after { display: none; }
    .mega-col-foot {
      margin-top: auto; padding-top: 10px;
      border-top: 1px dashed var(--line, #e5e7eb);
      font-size: .78rem; font-weight: 600; color: var(--blue-700, #1d4ed8);
      display: inline-flex; align-items: center; gap: 4px;
    }
    .mega-col-foot:hover { color: var(--blue-900, #1e3a8a); }
    .mega-col-foot::after { display: none; }

    .mega-footer {
      margin-top: 22px; padding-top: 22px;
      border-top: 1px solid var(--line, #e5e7eb);
      display: flex; align-items: center; justify-content: space-between;
      gap: 16px; flex-wrap: wrap;
    }
    .mega-footer .mf-text { font-size: .9rem; color: var(--muted, #475569); margin: 0; }
    .mega-footer .mf-text strong { color: var(--ink, #0b1020); }
    .mega-footer .mf-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .mega-mini-btn {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 9px 16px; border-radius: 999px;
      font-size: .85rem; font-weight: 600;
      border: 1px solid var(--line, #e5e7eb);
      color: var(--ink, #0b1020); background: #fff;
      transition: all .2s ease;
    }
    .mega-mini-btn:hover { border-color: var(--ink, #0b1020); background: var(--ink, #0b1020); color: #fff; }
    .mega-mini-btn.primary { background: var(--grad, linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%)); color: #fff; border-color: transparent; box-shadow: 0 8px 22px -8px rgba(37, 99, 235, .55); }
    .mega-mini-btn.primary:hover { transform: translateY(-1px); box-shadow: 0 14px 30px -8px rgba(37, 99, 235, .55); color: #fff; }
    .mega-mini-btn::after { display: none; }

    /* Backdrop overlay when mega is open (desktop) */
    .mega-backdrop {
      position: fixed; inset: 0; background: rgba(11, 16, 32, .25);
      backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px);
      opacity: 0; pointer-events: none; transition: opacity .25s ease;
      z-index: 90;
    }
    .nav-links li.has-mega.open ~ .mega-backdrop,
    body.mega-open .mega-backdrop { opacity: 1; pointer-events: auto; }

    /* Mobile drawer */
    @media (max-width: 980px) {
      .nav-inner { flex-wrap: wrap; padding: 14px 0; }
      .nav-toggle { order: 2; display: block; }
      .nav-links { order: 3; display: none; width: 100%; flex-direction: column; gap: 4px; padding-top: 14px; margin-top: 14px; border-top: 1px solid var(--line, #e5e7eb); }
      .nav-links > li { width: 100%; }
      .nav-links > li > a, .nav-links > li > button.nav-trigger { width: 100%; padding: 12px 4px; justify-content: space-between; font-size: 1rem; }
      .nav-links > li > a::after, .nav-links > li > button.nav-trigger::after { display: none; }
      .nav-right { order: 4; display: none; width: 100%; padding-top: 6px; flex-direction: column; align-items: stretch; gap: 10px; }
      .nav-right .nav-cta { width: 100%; text-align: center; justify-content: center; }
      .nav-phone { justify-content: center; padding: 10px 0; }

      .nav.open .nav-links { display: flex; }
      .nav.open .nav-right { display: flex; }

      /* Mobile mega menu = accordion */
      .mega-panel {
        position: static; opacity: 1; visibility: visible;
        transform: none; width: 100%;
        max-height: 0; padding: 0 14px; margin: 0;
        border: 0; border-radius: 12px; box-shadow: none;
        background: var(--bg-soft, #f8fafc);
        overflow: hidden;
        transition: max-height .35s ease, padding .25s ease, margin .25s ease;
      }
      .nav-links li.has-mega.open .mega-panel {
        max-height: 2400px;
        padding: 14px;
        margin: 4px 0 8px;
      }
      .mega-grid { grid-template-columns: 1fr; gap: 8px; }
      .mega-col { padding: 12px 14px; }
      .mega-col p { display: none; }
      .mega-col ul { display: none; }
      .mega-col.expanded ul { display: grid; }
      .mega-footer { display: none; }
      .mega-backdrop { display: none; }
    }

    @media (max-width: 540px) {
      .logo-text { font-size: 1.05rem; }
      .nav-inner { padding: 12px 0; }
    }
  </style>
@endpush

@php
  $current = request()->path();
  $isHome = $current === '/' || $current === '';
  $home = url('/');
@endphp

<div class="announce">
  <div class="container announce-inner">
    <span class="pulse"></span>
    <span>Now booking Q3 engagements — <a href="{{ $home }}#contact">claim your strategy call →</a></span>
  </div>
</div>

<header class="nav" id="nav">
  <div class="nav-inner container">
    <a href="{{ $home }}" class="logo" aria-label="Digirisers home">
      <span class="logo-mark" aria-hidden="true">
        <svg viewBox="0 0 40 40" width="32" height="32">
          <defs>
            <linearGradient id="lg-header" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="#60a5fa"/>
              <stop offset="1" stop-color="#1e3a8a"/>
            </linearGradient>
          </defs>
          <rect x="2" y="2" width="36" height="36" rx="10" fill="url(#lg-header)"/>
          <path d="M10 26 L16 18 L22 24 L30 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="30" cy="12" r="2.5" fill="#fff"/>
        </svg>
      </span>
      <span class="logo-text">Digirisers<span class="logo-dot">.</span></span>
    </a>

    <ul class="nav-links" aria-label="Primary">
      <li><a href="{{ $home }}" @class(['active' => $isHome])>Home</a></li>

      <li class="has-mega">
        <button type="button" class="nav-trigger" aria-haspopup="true" aria-expanded="false">
          Services
          <svg class="caret" viewBox="0 0 12 12" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M3 4.5 L6 7.5 L9 4.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>

        <div class="mega-panel" role="menu">
          <div class="mega-grid">
            {{-- 1. Web Development & Engineering --}}
            <div class="mega-col">
              <div class="mega-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
              </div>
              <h6>Web Development</h6>
              <p>Secure full-stack builds, APIs, and infrastructure.</p>
              <ul>
                <li><a href="{{ url('/services') }}#web-dev">Full-Stack Development</a></li>
                <li><a href="{{ url('/services') }}#web-dev">Laravel & Python</a></li>
                <li><a href="{{ url('/services') }}#web-dev">WordPress & Elementor</a></li>
                <li><a href="{{ url('/services') }}#web-dev">API & Microservices</a></li>
                <li><a href="{{ url('/services') }}#web-dev">Web Application Security</a></li>
                <li><a href="{{ url('/services') }}#web-dev">VPS & DNS Management</a></li>
              </ul>
              <a href="{{ url('/services') }}#web-dev" class="mega-col-foot">Browse Web Dev →</a>
            </div>

            {{-- 2. SEO & Marketing --}}
            <div class="mega-col">
              <div class="mega-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
              </div>
              <h6>SEO & Marketing</h6>
              <p>Organic, paid, and AI-search visibility that converts.</p>
              <ul>
                <li><a href="{{ url('/services') }}#seo-marketing">Technical & On-Page SEO</a></li>
                <li><a href="{{ url('/services') }}#seo-marketing">AI Search (ChatGPT/Gemini/Grok)</a></li>
                <li><a href="{{ url('/services') }}#seo-marketing">Google PPC & Meta Ads</a></li>
                <li><a href="{{ url('/services') }}#seo-marketing">TikTok & X Ad Campaigns</a></li>
                <li><a href="{{ url('/services') }}#seo-marketing">Email & SMS Automation</a></li>
                <li><a href="{{ url('/services') }}#seo-marketing">Backlink & Authority Building</a></li>
              </ul>
              <a href="{{ url('/services') }}#seo-marketing" class="mega-col-foot">Browse Marketing →</a>
            </div>

            {{-- 3. Design & CRO --}}
            <div class="mega-col">
              <div class="mega-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="M2 2l7.586 7.586"/><circle cx="11" cy="11" r="2"/></svg>
              </div>
              <h6>Design & CRO</h6>
              <p>Revenue-focused design, funnels, and conversion systems.</p>
              <ul>
                <li><a href="{{ url('/services') }}#design-cro">Web Design & UX</a></li>
                <li><a href="{{ url('/services') }}#design-cro">Ecommerce Web Design</a></li>
                <li><a href="{{ url('/services') }}#design-cro">Landing Pages & Funnels</a></li>
                <li><a href="{{ url('/services') }}#design-cro">Conversion Rate Optimization</a></li>
                <li><a href="{{ url('/services') }}#design-cro">Funnel Architecture</a></li>
                <li><a href="{{ url('/services') }}#design-cro">CRM-Driven Personalization</a></li>
              </ul>
              <a href="{{ url('/services') }}#design-cro" class="mega-col-foot">Browse Design →</a>
            </div>

            {{-- 4. AI, Automation & CRM --}}
            <div class="mega-col">
              <div class="mega-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><circle cx="12" cy="5" r="2"/><path d="M12 7v4"/><line x1="8" y1="16" x2="8" y2="16"/><line x1="16" y1="16" x2="16" y2="16"/></svg>
              </div>
              <h6>AI & Automation</h6>
              <p>AI employees, agentic systems, and CRM automation.</p>
              <ul>
                <li><a href="{{ url('/services') }}#ai-automation">AI Employees & Assistants</a></li>
                <li><a href="{{ url('/services') }}#ai-automation">AI Sales & Support Agents</a></li>
                <li><a href="{{ url('/services') }}#ai-automation">GoHighLevel Automation</a></li>
                <li><a href="{{ url('/services') }}#ai-automation">Zoho & Zapier Workflows</a></li>
                <li><a href="{{ url('/services') }}#ai-automation">Lead Management Systems</a></li>
                <li><a href="{{ url('/services') }}#ai-automation">Prompt Engineering</a></li>
              </ul>
              <a href="{{ url('/services') }}#ai-automation" class="mega-col-foot">Browse AI →</a>
            </div>

            {{-- 5. Brand & Strategy --}}
            <div class="mega-col">
              <div class="mega-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
              </div>
              <h6>Brand & Strategy</h6>
              <p>Brand systems, video, and revenue-focused strategy.</p>
              <ul>
                <li><a href="{{ url('/services') }}#brand-strategy">Brand Strategy & Logo</a></li>
                <li><a href="{{ url('/services') }}#brand-strategy">Custom Video Production</a></li>
                <li><a href="{{ url('/services') }}#brand-strategy">Short-Form Scriptwriting</a></li>
                <li><a href="{{ url('/services') }}#brand-strategy">Canva & CapCut Editing</a></li>
                <li><a href="{{ url('/services') }}#brand-strategy">Digital Strategy</a></li>
                <li><a href="{{ url('/services') }}#brand-strategy">Growth Systems Architecture</a></li>
              </ul>
              <a href="{{ url('/services') }}#brand-strategy" class="mega-col-foot">Browse Brand →</a>
            </div>
          </div>

          <div class="mega-footer">
            <p class="mf-text"><strong>SaaS-style ordering.</strong> Browse the full catalog or shop priced packages.</p>
            <div class="mf-actions">
              <a href="{{ url('/services') }}" class="mega-mini-btn">View all services</a>
              <a href="{{ url('/shop') }}" class="mega-mini-btn primary">Visit Shop →</a>
            </div>
          </div>
        </div>
      </li>

      <li><a href="{{ url('/shop') }}" @class(['active' => $current === 'shop'])>Shop</a></li>
      <li><a href="{{ url('/pricing') }}" @class(['active' => $current === 'pricing'])>Pricing</a></li>
      <li><a href="{{ $home }}#results">Results</a></li>
      <li><a href="{{ $home }}#contact">Contact</a></li>
    </ul>

    <div class="nav-right">
      <a href="tel:+14019987807" class="nav-phone" aria-label="Call Digirisers">
        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" aria-hidden="true"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.3 21 3 13.7 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
        <span>+1 (401) 998-7807</span>
      </a>
      <a href="{{ $home }}#contact" class="btn btn-primary nav-cta">Start a project</a>
    </div>

    <button class="nav-toggle" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
      <span></span><span></span>
    </button>
  </div>
  <div class="mega-backdrop" id="megaBackdrop" aria-hidden="true"></div>
</header>

@push('scripts')
  <script>
    (function () {
      const nav = document.getElementById('nav');
      if (!nav) return;

      // Sticky shadow on scroll
      const onScroll = () => {
        if (window.scrollY > 8) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
      };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();

      // Mobile drawer
      const navToggle = document.getElementById('navToggle');
      navToggle?.addEventListener('click', () => {
        const open = nav.classList.toggle('open');
        navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (!open) {
          // Collapse any open mega sections
          nav.querySelectorAll('.has-mega.open').forEach(li => li.classList.remove('open'));
        }
      });

      // Mega menu — desktop hover handled in CSS, mobile click toggles open
      const megaTriggers = nav.querySelectorAll('.has-mega .nav-trigger');
      megaTriggers.forEach(btn => {
        btn.addEventListener('click', (e) => {
          const li = btn.closest('.has-mega');
          if (!li) return;
          // On desktop, allow click to also toggle (useful for keyboard/touch)
          const isMobile = window.matchMedia('(max-width: 980px)').matches;
          if (isMobile) {
            e.preventDefault();
            const willOpen = !li.classList.contains('open');
            // Close siblings
            nav.querySelectorAll('.has-mega.open').forEach(x => { if (x !== li) x.classList.remove('open'); });
            li.classList.toggle('open', willOpen);
            btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
          } else {
            const willOpen = !li.classList.contains('open');
            nav.querySelectorAll('.has-mega.open').forEach(x => { if (x !== li) x.classList.remove('open'); });
            li.classList.toggle('open', willOpen);
            btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            document.body.classList.toggle('mega-open', willOpen);
          }
        });
      });

      // Close mega on outside click / Escape
      document.addEventListener('click', (e) => {
        if (!e.target.closest('.has-mega')) {
          nav.querySelectorAll('.has-mega.open').forEach(li => {
            li.classList.remove('open');
            li.querySelector('.nav-trigger')?.setAttribute('aria-expanded', 'false');
          });
          document.body.classList.remove('mega-open');
        }
      });
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
          nav.querySelectorAll('.has-mega.open').forEach(li => {
            li.classList.remove('open');
            li.querySelector('.nav-trigger')?.setAttribute('aria-expanded', 'false');
          });
          document.body.classList.remove('mega-open');
        }
      });

      // Close drawer on link click (mobile UX)
      nav.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
          if (window.matchMedia('(max-width: 980px)').matches) {
            nav.classList.remove('open');
            navToggle?.setAttribute('aria-expanded', 'false');
          }
        });
      });
    })();
  </script>
@endpush
