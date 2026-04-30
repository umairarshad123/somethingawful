{{--
  DigiRisers Mega Header (scoped with `dr-` prefix to avoid global conflicts)
  Used on every page via @include('partials.header').
  Conflict-safe: own announce + nav classes; only relies on shared `.btn` utilities.
--}}

@push('styles')
  <style>
    /* ============================================================
       DigiRisers Header — scoped (.dr-*)
       ============================================================ */

    /* Announcement bar */
    .dr-announce {
      background: #0b1020;
      color: rgba(255,255,255,.92);
      font-size: .82rem;
    }
    .dr-announce-inner {
      max-width: 1240px; margin: 0 auto;
      padding: 9px 24px;
      display: flex; align-items: center; justify-content: center;
      gap: 10px; text-align: center;
    }
    .dr-announce a { color: #93c5fd; font-weight: 600; }
    .dr-announce a:hover { color: #fff; }
    .dr-pulse {
      width: 7px; height: 7px; border-radius: 50%; background: #22c55e;
      box-shadow: 0 0 0 0 rgba(34,197,94,.6);
      animation: dr-pulse 2s ease-out infinite; flex-shrink: 0;
    }
    @keyframes dr-pulse {
      0%   { box-shadow: 0 0 0 0 rgba(34,197,94,.6); }
      70%  { box-shadow: 0 0 0 8px rgba(34,197,94,0); }
      100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
    }

    /* Header shell — sticky, full-width, the positioning anchor for the mega panel.
       Uses a glassy backdrop blur and a thin animated gradient line under the bar
       once the user scrolls. */
    .dr-nav {
      position: sticky; top: 0; z-index: 100;
      width: 100%;
      background: rgba(255,255,255,.78);
      backdrop-filter: saturate(180%) blur(20px);
      -webkit-backdrop-filter: saturate(180%) blur(20px);
      border-bottom: 1px solid transparent;
      transition: border-color .25s ease, box-shadow .25s ease, background .25s ease;
    }
    .dr-nav::after {
      content: ""; position: absolute; left: 0; right: 0; bottom: -1px;
      height: 1px;
      background: linear-gradient(90deg, transparent 0%, rgba(59,130,246,.45) 30%, rgba(30,58,138,.45) 70%, transparent 100%);
      opacity: 0; transition: opacity .35s ease;
      pointer-events: none;
    }
    .dr-nav.dr-scrolled {
      background: rgba(255,255,255,.92);
      box-shadow: 0 6px 28px -14px rgba(11,16,32,.16);
    }
    .dr-nav.dr-scrolled::after { opacity: 1; }
    /* Inner row spans the viewport. Desktop padding is wide so the logo
       hugs the left edge and the right cluster hugs the right edge,
       matching the nexvato.com layout. */
    .dr-nav-inner {
      width: 100%;
      max-width: none;
      margin: 0 auto;
      padding: 14px 56px;
      display: flex; align-items: center; justify-content: space-between;
      gap: 24px;
    }

    /* Logo */
    .dr-logo {
      display: inline-flex; align-items: center; gap: 10px;
      font-weight: 700; font-size: 1.18rem; letter-spacing: -0.02em;
      color: #0b1020; text-decoration: none; flex-shrink: 0;
      position: relative;
    }
    .dr-logo:hover { color: #0b1020; }
    .dr-logo svg {
      display: block;
      transition: transform .4s cubic-bezier(.34,1.56,.64,1), filter .4s ease;
      filter: drop-shadow(0 4px 14px rgba(37,99,235,.22));
    }
    .dr-logo:hover svg {
      transform: rotate(-8deg) scale(1.08);
      filter: drop-shadow(0 8px 22px rgba(37,99,235,.45));
    }
    .dr-logo-dot {
      color: #2563eb;
      animation: dr-logo-pulse 3s ease-in-out infinite;
    }
    @keyframes dr-logo-pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: .55; }
    }

    /* Primary nav list */
    .dr-nav-list {
      list-style: none; margin: 0; padding: 0;
      display: flex; align-items: center; gap: 22px;
      flex-wrap: nowrap;
    }
    .dr-nav-list > li {
      /* Default: items behave as static so the wide mega panel can position
         relative to the .dr-nav element. Narrow per-category dropdowns
         override this with .dr-has-mini below. */
      position: static;
    }
    .dr-nav-list > li.dr-has-mini { position: relative; }
    /* Slightly tighter at <1280px so 8 items don't wrap. */
    @media (min-width: 981px) and (max-width: 1280px) {
      .dr-nav-inner { padding: 14px 32px; gap: 16px; }
      .dr-nav-list { gap: 16px; }
      .dr-nav-link, .dr-nav-trigger { font-size: .88rem; }
    }
    .dr-nav-link,
    .dr-nav-trigger {
      display: inline-flex; align-items: center; gap: 5px;
      position: relative;
      padding: 8px 0;
      font: inherit; font-size: .92rem; font-weight: 500;
      color: #475569;
      background: transparent; border: 0; cursor: pointer;
      text-decoration: none;
      transition: color .2s ease;
    }
    .dr-nav-link:hover,
    .dr-nav-trigger:hover,
    .dr-has-mega:hover .dr-nav-trigger,
    .dr-has-mega.dr-open .dr-nav-trigger {
      color: #0b1020;
    }
    .dr-nav-link::after,
    .dr-nav-trigger::after {
      content: "";
      position: absolute; left: 0; right: 0; bottom: 2px;
      height: 2px;
      background: linear-gradient(90deg, #3b82f6 0%, #1e3a8a 100%);
      border-radius: 2px;
      transform: scaleX(0); transform-origin: left;
      transition: transform .3s cubic-bezier(.65,0,.35,1);
    }
    .dr-nav-link:hover::after,
    .dr-nav-trigger:hover::after,
    .dr-has-mega:hover .dr-nav-trigger::after,
    .dr-has-mega.dr-open .dr-nav-trigger::after,
    .dr-nav-link.dr-active::after { transform: scaleX(1); }

    .dr-caret {
      transition: transform .25s ease; flex-shrink: 0;
      color: currentColor; opacity: .6;
    }
    .dr-has-mega:hover .dr-caret,
    .dr-has-mega.dr-open .dr-caret { transform: rotate(180deg); }

    /* Right cluster */
    .dr-nav-right { display: flex; align-items: center; gap: 14px; flex-shrink: 0; }
    .dr-nav-phone {
      display: inline-flex; align-items: center; gap: 7px;
      color: #475569; font-size: .9rem; font-weight: 500;
      text-decoration: none;
      transition: color .2s ease;
    }
    .dr-nav-phone:hover { color: #1d4ed8; }
    .dr-nav-phone svg { color: #2563eb; flex-shrink: 0; }
    .dr-cta {
      display: inline-flex; align-items: center; justify-content: center;
      padding: 10px 18px; border-radius: 999px;
      font: inherit; font-size: .88rem; font-weight: 600;
      color: #fff; text-decoration: none;
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      box-shadow: 0 8px 22px -10px rgba(37,99,235,.6), inset 0 1px 0 rgba(255,255,255,.2);
      transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease, background-position .4s ease;
      white-space: nowrap;
      position: relative; overflow: hidden;
      background-size: 200% 200%;
      background-position: 0% 0%;
    }
    .dr-cta::before {
      content: ""; position: absolute; inset: 0;
      background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%);
      transform: translateX(-100%);
      transition: transform .9s ease;
      pointer-events: none;
    }
    .dr-cta:hover {
      transform: translateY(-1px);
      box-shadow: 0 16px 32px -10px rgba(37,99,235,.7);
      background-position: 100% 100%;
      color: #fff;
    }
    .dr-cta:hover::before { transform: translateX(100%); }

    /* Sign-in (ghost) button shown to guests */
    .dr-signin {
      display: inline-flex; align-items: center; justify-content: center;
      padding: 9px 14px; border-radius: 999px;
      font: inherit; font-size: .88rem; font-weight: 600;
      color: #0b1020; background: transparent;
      border: 1px solid #e5e7eb;
      text-decoration: none;
      transition: all .2s ease;
      white-space: nowrap;
    }
    .dr-signin:hover { background: #0b1020; color: #fff; border-color: #0b1020; }

    /* Account menu (auth state) */
    .dr-account { position: relative; }
    .dr-account-btn {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 5px 10px 5px 5px;
      border: 1px solid #e5e7eb; border-radius: 999px;
      background: #fff; font: inherit; cursor: pointer;
      transition: border-color .2s ease, background .2s ease;
    }
    .dr-account-btn:hover { border-color: #0b1020; }
    .dr-account-name { font-size: .85rem; font-weight: 600; color: #0b1020; }
    .dr-account .dr-caret { color: #475569; opacity: .7; }
    .dr-avatar {
      width: 28px; height: 28px; border-radius: 50%;
      display: grid; place-items: center;
      background: linear-gradient(135deg, #3b82f6, #1e3a8a);
      color: #fff; font-size: .72rem; font-weight: 700;
      letter-spacing: 0;
    }

    .dr-account-menu {
      position: absolute; top: calc(100% + 8px); right: 0;
      min-width: 220px;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      box-shadow: 0 24px 50px -16px rgba(11, 16, 32, .25);
      padding: 6px;
      opacity: 0; visibility: hidden; pointer-events: none;
      transform: translateY(6px);
      transition: opacity .2s ease, transform .2s ease, visibility .2s;
      z-index: 200;
    }
    .dr-account.dr-open .dr-account-menu {
      opacity: 1; visibility: visible; pointer-events: auto;
      transform: translateY(0);
    }
    .dr-account-head {
      padding: 10px 12px 12px;
      border-bottom: 1px solid #f1f5f9;
      margin-bottom: 4px;
    }
    .dr-account-head strong { display: block; font-size: .92rem; color: #0b1020; font-weight: 700; }
    .dr-account-head small  { display: block; font-size: .76rem; color: #64748b; word-break: break-all; }
    .dr-account-link {
      display: block; width: 100%; text-align: left;
      padding: 9px 12px;
      font: inherit; font-size: .88rem; font-weight: 500;
      color: #0b1020; background: transparent; border: 0;
      border-radius: 8px;
      text-decoration: none; cursor: pointer;
      transition: background .15s ease, color .15s ease;
    }
    .dr-account-link::after { display: none; }
    .dr-account-link:hover { background: #f1f5f9; }
    .dr-account-signout {
      color: #b91c1c; border-top: 1px solid #f1f5f9; margin-top: 4px; padding-top: 10px;
    }
    .dr-account-signout:hover { background: #fef2f2; color: #b91c1c; }
    .dr-account-form { margin: 0; }

    /* Hamburger toggle (mobile only) */
    .dr-toggle {
      display: none;
      background: transparent; border: 0;
      width: 42px; height: 42px; padding: 0; cursor: pointer;
      border-radius: 10px;
      align-items: center; justify-content: center;
      flex-direction: column; gap: 5px;
      flex-shrink: 0;
    }
    .dr-toggle:hover { background: #f1f5f9; }
    .dr-toggle span {
      display: block; width: 22px; height: 2px;
      background: #0b1020; border-radius: 2px;
      transition: transform .25s ease, opacity .25s ease;
    }
    .dr-nav.dr-open .dr-toggle span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .dr-nav.dr-open .dr-toggle span:nth-child(2) { opacity: 0; }
    .dr-nav.dr-open .dr-toggle span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* ============================================================
       Mega Panel — centered to viewport, max 1100px, below header
       ============================================================ */
    .dr-mega-panel {
      position: absolute;
      top: 100%; left: 50%;
      transform: translateX(-50%) translateY(8px);
      width: min(1100px, calc(100vw - 32px));
      margin-top: 8px;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 20px;
      box-shadow: 0 30px 70px -20px rgba(11,16,32,.25),
                  0 8px 20px -10px rgba(11,16,32,.08);
      padding: 24px;
      opacity: 0; visibility: hidden; pointer-events: none;
      transition: opacity .2s ease, transform .25s ease, visibility .2s;
      z-index: 200;
    }
    .dr-has-mega:hover .dr-mega-panel,
    .dr-has-mega:focus-within .dr-mega-panel,
    .dr-has-mega.dr-open .dr-mega-panel {
      opacity: 1; visibility: visible; pointer-events: auto;
      transform: translateX(-50%) translateY(0);
    }

    .dr-mega-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 14px;
    }
    .dr-mega-col {
      display: flex; flex-direction: column;
      padding: 14px 12px;
      border-radius: 12px;
      background: #f8fafc;
      border: 1px solid transparent;
      transition: background .2s ease, border-color .2s ease, transform .25s ease;
    }
    .dr-mega-col:hover {
      background: #fff;
      border-color: #bfdbfe;
      transform: translateY(-2px);
      box-shadow: 0 8px 22px -14px rgba(30,58,138,.25);
    }
    .dr-mega-icon {
      width: 32px; height: 32px; border-radius: 9px;
      background: #eff6ff; color: #1d4ed8;
      display: grid; place-items: center;
      margin-bottom: 10px;
      transition: background .25s ease, color .25s ease;
    }
    .dr-mega-col:hover .dr-mega-icon {
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      color: #fff;
    }
    .dr-mega-col h6 {
      font-size: .82rem; font-weight: 700;
      color: #0b1020; margin: 0 0 8px;
      letter-spacing: -0.01em;
    }
    .dr-mega-col ul {
      list-style: none; margin: 0 0 10px; padding: 0;
      display: flex; flex-direction: column; gap: 1px;
      flex: 1;
    }
    .dr-mega-col li a {
      display: block;
      padding: 6px 8px; margin: 0 -8px;
      font-size: .8rem; line-height: 1.3;
      color: #475569; text-decoration: none;
      border-radius: 6px;
      transition: background .15s ease, color .15s ease;
    }
    .dr-mega-col li a::after { display: none; }
    .dr-mega-col li a:hover {
      background: #eff6ff; color: #1e40af;
    }
    .dr-mega-foot-link {
      margin-top: 8px; padding-top: 8px;
      border-top: 1px dashed #e5e7eb;
      font-size: .75rem; font-weight: 600; color: #1d4ed8;
      text-decoration: none;
      display: inline-flex; align-items: center; gap: 3px;
    }
    .dr-mega-foot-link::after { display: none; }
    .dr-mega-foot-link:hover { color: #1e3a8a; }

    .dr-mega-footer {
      margin-top: 18px; padding-top: 18px;
      border-top: 1px solid #e5e7eb;
      display: flex; align-items: center; justify-content: space-between;
      gap: 14px; flex-wrap: wrap;
    }
    .dr-mega-footer p {
      margin: 0; font-size: .85rem; color: #475569;
    }
    .dr-mega-footer p strong { color: #0b1020; font-weight: 600; }
    .dr-mega-footer-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .dr-mega-pill {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 8px 14px; border-radius: 999px;
      font-size: .82rem; font-weight: 600;
      text-decoration: none;
      border: 1px solid #e5e7eb;
      color: #0b1020; background: #fff;
      transition: all .2s ease;
    }
    .dr-mega-pill::after { display: none; }
    .dr-mega-pill:hover { border-color: #0b1020; background: #0b1020; color: #fff; }
    .dr-mega-pill.dr-primary {
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      color: #fff; border-color: transparent;
      box-shadow: 0 6px 18px -8px rgba(37,99,235,.5);
    }
    .dr-mega-pill.dr-primary:hover { transform: translateY(-1px); color: #fff; }

    /* ============================================================
       Mini Panel — per-category dropdown anchored to its trigger
       ============================================================ */
    .dr-mini-panel {
      position: absolute;
      top: 100%; left: 0;
      width: 320px;
      margin-top: 8px;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      box-shadow: 0 24px 60px -18px rgba(11,16,32,.25),
                  0 6px 18px -10px rgba(11,16,32,.08);
      padding: 10px;
      opacity: 0; visibility: hidden; pointer-events: none;
      transform: translateY(8px);
      transition: opacity .2s ease, transform .25s ease, visibility .2s;
      z-index: 200;
    }
    .dr-has-mini:hover .dr-mini-panel,
    .dr-has-mini:focus-within .dr-mini-panel,
    .dr-has-mini.dr-open .dr-mini-panel {
      opacity: 1; visibility: visible; pointer-events: auto;
      transform: translateY(0);
    }
    .dr-mini-list {
      list-style: none; margin: 0; padding: 0;
      display: grid; gap: 1px;
    }
    .dr-mini-list a {
      display: block;
      padding: 10px 12px;
      font-size: .88rem; line-height: 1.35;
      color: #0b1020; text-decoration: none;
      border-radius: 10px;
      transition: background .15s ease, color .15s ease;
    }
    .dr-mini-list a::after { display: none; }
    .dr-mini-list a:hover { background: #eff6ff; color: #1d4ed8; }
    .dr-mini-foot {
      margin-top: 6px; padding: 10px 12px;
      border-top: 1px dashed #e5e7eb;
      font-size: .78rem; font-weight: 600; color: #1d4ed8;
      text-decoration: none;
      display: inline-flex; align-items: center; gap: 4px;
    }
    .dr-mini-foot::after { display: none; }
    .dr-mini-foot:hover { color: #1e3a8a; }

    /* Backdrop */
    .dr-backdrop {
      position: fixed; inset: 0;
      background: rgba(11,16,32,.18);
      backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px);
      opacity: 0; pointer-events: none;
      transition: opacity .25s ease;
      z-index: 90;
    }
    body.dr-mega-open .dr-backdrop { opacity: 1; pointer-events: auto; }

    /* ============================================================
       Mobile (≤980px) — drawer + services accordion
       ============================================================ */
    @media (max-width: 980px) {
      /* Tablet: tighter side padding so the hamburger sits closer to the edge. */
      .dr-nav-inner { padding: 12px 24px; }

      /* Hide desktop links / right cluster, show hamburger */
      .dr-nav-list { display: none; }
      .dr-nav-right { display: none; }
      .dr-toggle { display: inline-flex; }

      /* Drawer container — slides down from header */
      .dr-drawer {
        position: absolute; top: 100%; left: 0; right: 0;
        background: #fff;
        border-top: 1px solid #e5e7eb;
        box-shadow: 0 20px 40px -16px rgba(11,16,32,.18);
        max-height: 0; overflow: hidden;
        transition: max-height .35s ease;
      }
      .dr-nav.dr-open .dr-drawer { max-height: calc(100vh - 60px); overflow-y: auto; }
      .dr-drawer-inner { padding: 14px 18px 22px; display: flex; flex-direction: column; gap: 4px; }

      /* Mobile links list */
      .dr-mobile-list {
        list-style: none; margin: 0; padding: 0;
        display: flex; flex-direction: column;
      }
      .dr-mobile-list > li { border-bottom: 1px solid #f1f5f9; }
      .dr-mobile-list > li:last-child { border-bottom: 0; }
      .dr-mobile-link,
      .dr-mobile-trigger {
        display: flex; align-items: center; justify-content: space-between;
        width: 100%; padding: 14px 4px;
        font: inherit; font-size: 1rem; font-weight: 500;
        color: #0b1020; text-decoration: none;
        background: transparent; border: 0; cursor: pointer;
        text-align: left;
      }
      .dr-mobile-trigger .dr-caret { transition: transform .25s ease; }
      .dr-has-mega.dr-open .dr-mobile-trigger .dr-caret { transform: rotate(180deg); }

      /* Mobile mega = accordion section under "Services" */
      .dr-mobile-mega {
        max-height: 0; overflow: hidden;
        transition: max-height .35s ease;
      }
      .dr-has-mega.dr-open .dr-mobile-mega { max-height: 1800px; }
      .dr-mobile-mega-inner { padding: 4px 0 14px; display: flex; flex-direction: column; gap: 12px; }
      .dr-mobile-cat { background: #f8fafc; border-radius: 12px; padding: 12px 14px; }
      .dr-mobile-cat h6 { margin: 0 0 8px; font-size: .82rem; font-weight: 700; color: #0b1020; letter-spacing: -0.01em; }
      .dr-mobile-cat ul { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: 4px 12px; }
      .dr-mobile-cat li a {
        display: block; padding: 4px 0;
        font-size: .82rem; color: #475569;
        text-decoration: none;
      }
      .dr-mobile-cat li a:hover { color: #1d4ed8; }

      /* Mobile CTA cluster (always inside drawer) */
      .dr-mobile-actions {
        display: flex; flex-direction: column; gap: 10px;
        padding-top: 14px; margin-top: 4px;
        border-top: 1px solid #e5e7eb;
      }
      .dr-mobile-actions .dr-cta { width: 100%; padding: 13px 18px; font-size: .95rem; }
      .dr-mobile-actions .dr-nav-phone {
        justify-content: center;
        padding: 12px 16px;
        border: 1px solid #e5e7eb; border-radius: 999px;
        font-size: .92rem;
      }

      /* Hide desktop mega when mobile */
      .dr-mega-panel { display: none; }
      .dr-backdrop { display: none; }

      /* Prevent horizontal scroll while drawer is open */
      body.dr-drawer-open { overflow: hidden; }
    }

    @media (max-width: 480px) {
      .dr-nav-inner { padding: 12px 16px; }
      .dr-logo { font-size: 1.05rem; }
      .dr-mobile-cat ul { grid-template-columns: 1fr; }
    }

    @media (min-width: 981px) {
      /* Drawer markup is irrelevant on desktop — never render */
      .dr-drawer { display: none; }
    }
  </style>
@endpush

@php
  $current = trim(request()->path(), '/');
  $isHome  = $current === '' || $current === '/';
  $home    = url('/');

  // Each top-level category is its own dropdown. The 5 visible items match
  // the user-curated catalog list shown in the request brief — slugs map to
  // entries in config/catalog.php so /shop/{slug} resolves cleanly.
  $categories = [
    [
      'key'     => 'development',
      'label'   => 'Development',
      'tagline' => 'Sites & funnels',
      'icon'    => 'monitor',
      'href'    => url('/services/websites'),
      'items'   => [
        ['name' => 'WordPress Portfolio Site',                 'slug' => 'wp-portfolio'],
        ['name' => 'WordPress Business Site',                  'slug' => 'wp-business'],
        ['name' => 'Custom Designed Website / Sales Funnel',   'slug' => 'custom-site'],
        ['name' => 'Custom Site / Funnel + Integrations',      'slug' => 'custom-site-integrations'],
        ['name' => 'E-commerce Store',                         'slug' => 'ecommerce'],
      ],
    ],
    [
      'key'     => 'grow',
      'label'   => 'Grow',
      'tagline' => 'SEO, ads & social',
      'icon'    => 'search',
      'href'    => url('/services/seo'),
      'items'   => [
        ['name' => 'Local SEO Setup',          'slug' => 'local-seo'],
        ['name' => 'Technical SEO Audit',      'slug' => 'technical-seo'],
        ['name' => 'Ads Setup',                'slug' => 'ads-setup'],
        ['name' => 'Ads Management',           'slug' => 'ads-management'],
        ['name' => 'Social Media Management',  'slug' => 'social-management'],
      ],
    ],
    [
      'key'     => 'automations',
      'label'   => 'Automations',
      'tagline' => 'AI & CRM',
      'icon'    => 'brain',
      'href'    => url('/services/ai'),
      'items'   => [
        ['name' => 'AI Web Chatbot / Knowledge Base', 'slug' => 'ai-chatbot'],
        ['name' => 'AI Customer Support Agent',       'slug' => 'ai-support-agent'],
        ['name' => 'AI Sales & Appointment Setter',   'slug' => 'ai-sales-agent'],
        ['name' => 'GoHighLevel Full Setup',          'slug' => 'ghl-full-setup'],
        ['name' => 'GHL Snapshot Customization',      'slug' => 'ghl-snapshot'],
      ],
    ],
    [
      'key'     => 'security',
      'label'   => 'Security',
      'tagline' => 'Hosting & infrastructure',
      'icon'    => 'shield',
      'href'    => url('/services/hosting'),
      'items'   => [
        ['name' => 'VPS Setup & Hardening',        'slug' => 'vps-setup'],
        ['name' => 'DNS & SSL Configuration',      'slug' => 'dns-ssl'],
        ['name' => 'Website Security Implementation', 'slug' => 'security-implementation'],
        ['name' => '2FA + RBAC Setup',             'slug' => '2fa-rbac'],
        ['name' => 'API Security Hardening',       'slug' => 'api-security'],
      ],
    ],
    [
      'key'     => 'branding',
      'label'   => 'Branding',
      'tagline' => 'Identity & creative',
      'icon'    => 'sparkle',
      'href'    => url('/services/branding'),
      'items'   => [
        ['name' => 'Logo Design',                          'slug' => 'logo-design'],
        ['name' => 'Full Brand Identity Kit',              'slug' => 'brand-kit'],
        ['name' => 'Short-Form Video Scriptwriting',       'slug' => 'short-form-script'],
        ['name' => 'Canva Creative Design',                'slug' => 'canva-design'],
        ['name' => 'Digital Marketing Collateral Pack',    'slug' => 'collateral-pack'],
      ],
    ],
  ];
@endphp

<header class="dr-nav" id="drNav">
  <div class="dr-nav-inner">
    {{-- Logo (left) --}}
    <a href="{{ $home }}" class="dr-logo" aria-label="Digirisers home">
      <svg viewBox="0 0 40 40" width="30" height="30" aria-hidden="true">
        <defs>
          <linearGradient id="drLogoG" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#60a5fa"/>
            <stop offset="1" stop-color="#1e3a8a"/>
          </linearGradient>
        </defs>
        <rect x="2" y="2" width="36" height="36" rx="10" fill="url(#drLogoG)"/>
        <path d="M10 26 L16 18 L22 24 L30 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="30" cy="12" r="2.5" fill="#fff"/>
      </svg>
      <span>Digirisers<span class="dr-logo-dot">.</span></span>
    </a>

    {{-- Nav (center) — eight items: Home, Services overview, 5 categories, Contact --}}
    <ul class="dr-nav-list" aria-label="Primary">
      <li><a href="{{ $home }}" class="dr-nav-link @if($isHome) dr-active @endif">Home</a></li>

      {{-- Services overview: wide centered mega panel listing all 5 categories --}}
      <li class="dr-has-mega" data-mega>
        <button type="button" class="dr-nav-trigger" aria-haspopup="true" aria-expanded="false">
          Services
          <svg class="dr-caret" viewBox="0 0 12 12" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M3 4.5 L6 7.5 L9 4.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>

        <div class="dr-mega-panel" role="menu">
          <div class="dr-mega-grid">
            @foreach ($categories as $cat)
              <a href="{{ $cat['href'] }}" class="dr-mega-col" style="text-decoration:none; color:inherit;">
                <div class="dr-mega-icon" aria-hidden="true">
                  @switch($cat['icon'])
                    @case('monitor')
                      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="14" rx="2"/><line x1="8" y1="20" x2="16" y2="20"/><line x1="12" y1="18" x2="12" y2="20"/></svg>
                      @break
                    @case('search')
                      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                      @break
                    @case('brain')
                      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4a3 3 0 0 0-3 3v1a3 3 0 0 0-2 5 3 3 0 0 0 2 5 3 3 0 0 0 3 3 3 3 0 0 0 3-3V7a3 3 0 0 0-3-3z"/><path d="M15 4a3 3 0 0 1 3 3v1a3 3 0 0 1 2 5 3 3 0 0 1-2 5 3 3 0 0 1-3 3 3 3 0 0 1-3-3"/></svg>
                      @break
                    @case('shield')
                      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                      @break
                    @case('sparkle')
                      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l2 5 5 2-5 2-2 5-2-5-5-2 5-2z"/></svg>
                      @break
                  @endswitch
                </div>
                <h6>{{ $cat['label'] }} <span style="color:#64748b; font-weight:500; font-size:.7rem; letter-spacing:0; text-transform:none;">— {{ $cat['tagline'] }}</span></h6>
                <ul>
                  @foreach ($cat['items'] as $item)
                    <li>{{ Str::limit($item['name'], 36) }}</li>
                  @endforeach
                </ul>
                <span class="dr-mega-foot-link">Browse {{ strtolower($cat['label']) }} →</span>
              </a>
            @endforeach
          </div>
          <div class="dr-mega-footer">
            <p><strong>SaaS-style ordering.</strong> Senior team owns the outcome — no payment required to inquire.</p>
            <div class="dr-mega-footer-actions">
              <a href="{{ url('/services') }}" class="dr-mega-pill">All services</a>
              <a href="{{ url('/shop') }}" class="dr-mega-pill dr-primary">Visit Shop →</a>
            </div>
          </div>
        </div>
      </li>

      {{-- One narrow dropdown per category --}}
      @foreach ($categories as $cat)
        <li class="dr-has-mega dr-has-mini" data-mega>
          <button type="button" class="dr-nav-trigger" aria-haspopup="true" aria-expanded="false">
            {{ $cat['label'] }}
            <svg class="dr-caret" viewBox="0 0 12 12" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M3 4.5 L6 7.5 L9 4.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <div class="dr-mini-panel" role="menu">
            <ul class="dr-mini-list">
              @foreach ($cat['items'] as $item)
                <li><a href="{{ url('/shop/'.$item['slug']) }}" role="menuitem">{{ $item['name'] }}</a></li>
              @endforeach
            </ul>
            <a href="{{ $cat['href'] }}" class="dr-mini-foot">View all in {{ $cat['label'] }} →</a>
          </div>
        </li>
      @endforeach

      <li><a href="{{ route('contact') }}" class="dr-nav-link @if($current === 'contact') dr-active @endif">Contact</a></li>
    </ul>

    {{-- Right cluster — context-aware: guest sees Sign in / Sign up, auth sees account menu --}}
    <div class="dr-nav-right">
      @auth
        <div class="dr-account" data-account>
          <button type="button" class="dr-account-btn" aria-haspopup="true" aria-expanded="false" aria-label="Account menu">
            <span class="dr-avatar">{{ auth()->user()->initials }}</span>
            <span class="dr-account-name">{{ auth()->user()->first_name }}</span>
            <svg class="dr-caret" viewBox="0 0 12 12" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 4.5 L6 7.5 L9 4.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <div class="dr-account-menu" role="menu">
            <div class="dr-account-head">
              <strong>{{ auth()->user()->name }}</strong>
              <small>{{ auth()->user()->email }}</small>
            </div>
            <a href="{{ route('dashboard') }}" class="dr-account-link" role="menuitem">Dashboard</a>
            <a href="{{ url('/shop') }}" class="dr-account-link" role="menuitem">Shop</a>
            <a href="{{ url('/services') }}" class="dr-account-link" role="menuitem">Browse services</a>
            <form method="POST" action="{{ route('auth.logout') }}" class="dr-account-form">
              @csrf
              <button type="submit" class="dr-account-link dr-account-signout">Sign out</button>
            </form>
          </div>
        </div>
      @else
        <a href="{{ route('auth.show') }}" class="dr-signin">Sign in</a>
        <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="dr-cta">Create account</a>
      @endauth
    </div>

    {{-- Hamburger (mobile only) --}}
    <button type="button" class="dr-toggle" id="drToggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="drDrawer">
      <span></span><span></span><span></span>
    </button>
  </div>

  {{-- Mobile drawer --}}
  <div class="dr-drawer" id="drDrawer" aria-hidden="true">
    <div class="dr-drawer-inner">
      <ul class="dr-mobile-list">
        <li><a href="{{ $home }}" class="dr-mobile-link">Home</a></li>

        {{-- Services overview accordion: links to each category overview --}}
        <li class="dr-has-mega" data-mega-mobile>
          <button type="button" class="dr-mobile-trigger" aria-expanded="false">
            Services
            <svg class="dr-caret" viewBox="0 0 12 12" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M3 4.5 L6 7.5 L9 4.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <div class="dr-mobile-mega">
            <div class="dr-mobile-mega-inner">
              @foreach ($categories as $cat)
                <div class="dr-mobile-cat">
                  <h6><a href="{{ $cat['href'] }}" style="color:inherit;">{{ $cat['label'] }} →</a></h6>
                </div>
              @endforeach
              <a href="{{ url('/services') }}" class="dr-mega-pill" style="align-self:flex-start;">View all services →</a>
            </div>
          </div>
        </li>

        {{-- One accordion per category, exact items from the desktop dropdown --}}
        @foreach ($categories as $cat)
          <li class="dr-has-mega" data-mega-mobile>
            <button type="button" class="dr-mobile-trigger" aria-expanded="false">
              {{ $cat['label'] }}
              <svg class="dr-caret" viewBox="0 0 12 12" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M3 4.5 L6 7.5 L9 4.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
            <div class="dr-mobile-mega">
              <div class="dr-mobile-mega-inner">
                <div class="dr-mobile-cat">
                  <ul>
                    @foreach ($cat['items'] as $item)
                      <li><a href="{{ url('/shop/'.$item['slug']) }}">{{ $item['name'] }}</a></li>
                    @endforeach
                  </ul>
                </div>
                <a href="{{ $cat['href'] }}" class="dr-mega-pill" style="align-self:flex-start;">View all {{ strtolower($cat['label']) }} →</a>
              </div>
            </div>
          </li>
        @endforeach

        <li><a href="{{ route('contact') }}" class="dr-mobile-link">Contact</a></li>
      </ul>

      <div class="dr-mobile-actions">
        @auth
          <a href="{{ route('dashboard') }}" class="dr-cta">Dashboard ({{ auth()->user()->first_name }})</a>
          <form method="POST" action="{{ route('auth.logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="dr-signin" style="width:100%; cursor:pointer; font:inherit;">Sign out</button>
          </form>
        @else
          <a href="{{ route('auth.show') }}" class="dr-signin">Sign in</a>
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="dr-cta">Create account</a>
        @endauth
      </div>
    </div>
  </div>

  <div class="dr-backdrop" aria-hidden="true"></div>
</header>

@push('scripts')
  <script>
    (function () {
      const nav     = document.getElementById('drNav');
      if (!nav) return;
      const toggle  = document.getElementById('drToggle');
      const drawer  = document.getElementById('drDrawer');
      const mqMobile = window.matchMedia('(max-width: 980px)');

      // 1) Sticky shadow
      const onScroll = () => {
        if (window.scrollY > 6) nav.classList.add('dr-scrolled');
        else nav.classList.remove('dr-scrolled');
      };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();

      // 2) Drawer (mobile)
      const closeDrawer = () => {
        nav.classList.remove('dr-open');
        document.body.classList.remove('dr-drawer-open');
        toggle?.setAttribute('aria-expanded', 'false');
        drawer?.setAttribute('aria-hidden', 'true');
        // Collapse any open accordion sections
        nav.querySelectorAll('[data-mega-mobile].dr-open').forEach(el => {
          el.classList.remove('dr-open');
          el.querySelector('.dr-mobile-trigger')?.setAttribute('aria-expanded', 'false');
        });
      };
      toggle?.addEventListener('click', () => {
        const open = !nav.classList.contains('dr-open');
        nav.classList.toggle('dr-open', open);
        document.body.classList.toggle('dr-drawer-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        drawer?.setAttribute('aria-hidden', open ? 'false' : 'true');
        if (!open) closeDrawer();
      });

      // 3) Desktop mega — click toggles, hover handled in CSS
      nav.querySelectorAll('[data-mega] > .dr-nav-trigger').forEach(btn => {
        btn.addEventListener('click', (e) => {
          if (mqMobile.matches) return; // mobile uses separate trigger
          e.preventDefault();
          const li = btn.closest('[data-mega]');
          const open = !li.classList.contains('dr-open');
          // close siblings
          nav.querySelectorAll('[data-mega].dr-open').forEach(x => x !== li && x.classList.remove('dr-open'));
          li.classList.toggle('dr-open', open);
          btn.setAttribute('aria-expanded', open ? 'true' : 'false');
          document.body.classList.toggle('dr-mega-open', open);
        });
      });

      // 4) Mobile mega accordion
      nav.querySelectorAll('[data-mega-mobile] > .dr-mobile-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
          const li = btn.closest('[data-mega-mobile]');
          const open = !li.classList.contains('dr-open');
          li.classList.toggle('dr-open', open);
          btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
      });

      // 5) Close on outside click / Escape / link click in drawer
      document.addEventListener('click', (e) => {
        if (!e.target.closest('[data-mega]')) {
          nav.querySelectorAll('[data-mega].dr-open').forEach(li => {
            li.classList.remove('dr-open');
            li.querySelector('.dr-nav-trigger')?.setAttribute('aria-expanded', 'false');
          });
          document.body.classList.remove('dr-mega-open');
        }
      });
      document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        nav.querySelectorAll('[data-mega].dr-open, [data-mega-mobile].dr-open').forEach(li => {
          li.classList.remove('dr-open');
          li.querySelector('.dr-nav-trigger, .dr-mobile-trigger')?.setAttribute('aria-expanded', 'false');
        });
        document.body.classList.remove('dr-mega-open');
        if (nav.classList.contains('dr-open')) closeDrawer();
      });

      // Close drawer when a mobile link is clicked (anchors / route changes)
      drawer?.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
          if (mqMobile.matches) closeDrawer();
        });
      });

      // Close mega when switching from mobile->desktop or vice versa
      mqMobile.addEventListener?.('change', closeDrawer);

      // Account dropdown (auth state)
      const account = document.querySelector('[data-account]');
      if (account) {
        const btn  = account.querySelector('.dr-account-btn');
        btn?.addEventListener('click', (e) => {
          e.stopPropagation();
          const open = !account.classList.contains('dr-open');
          account.classList.toggle('dr-open', open);
          btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('click', (e) => {
          if (!e.target.closest('[data-account]')) {
            account.classList.remove('dr-open');
            btn?.setAttribute('aria-expanded', 'false');
          }
        });
        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape') {
            account.classList.remove('dr-open');
            btn?.setAttribute('aria-expanded', 'false');
          }
        });
      }
    })();
  </script>
@endpush
