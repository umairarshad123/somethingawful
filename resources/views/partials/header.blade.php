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

    /* Header shell — sticky, full-width, the positioning anchor for the mega panel */
    .dr-nav {
      position: sticky; top: 0; z-index: 100;
      background: rgba(255,255,255,.85);
      backdrop-filter: saturate(180%) blur(16px);
      -webkit-backdrop-filter: saturate(180%) blur(16px);
      border-bottom: 1px solid transparent;
      transition: border-color .25s ease, box-shadow .25s ease, background .25s ease;
    }
    .dr-nav.dr-scrolled {
      background: rgba(255,255,255,.94);
      border-bottom-color: #e5e7eb;
      box-shadow: 0 4px 24px -12px rgba(11,16,32,.12);
    }
    .dr-nav-inner {
      max-width: 1240px; margin: 0 auto;
      padding: 14px 24px;
      display: flex; align-items: center; justify-content: space-between;
      gap: 24px;
    }

    /* Logo */
    .dr-logo {
      display: inline-flex; align-items: center; gap: 10px;
      font-weight: 700; font-size: 1.18rem; letter-spacing: -0.02em;
      color: #0b1020; text-decoration: none; flex-shrink: 0;
    }
    .dr-logo:hover { color: #0b1020; }
    .dr-logo svg { display: block; transition: transform .35s ease; }
    .dr-logo:hover svg { transform: rotate(-6deg) scale(1.05); }
    .dr-logo-dot { color: #2563eb; }

    /* Primary nav list */
    .dr-nav-list {
      list-style: none; margin: 0; padding: 0;
      display: flex; align-items: center; gap: 28px;
    }
    .dr-nav-list > li {
      /* IMPORTANT: must be static so the mega panel can position relative to the header. */
      position: static;
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
      height: 2px; background: #2563eb;
      transform: scaleX(0); transform-origin: left;
      transition: transform .25s ease;
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
      transition: transform .2s ease, box-shadow .25s ease;
      white-space: nowrap;
    }
    .dr-cta:hover { transform: translateY(-1px); box-shadow: 0 14px 28px -10px rgba(37,99,235,.65); color: #fff; }

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
      .dr-nav-inner { padding: 12px 18px; }

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

  // Pull mega-menu structure from the catalog (config/catalog.php) so the header
  // never drifts from the actual catalog. Visual layout: 5 columns grouping the
  // 8 underlying categories.
  $catalog = config('catalog.categories', []);
  $previewLinks = function (string $catId, int $n = 5) use ($catalog) {
    $items = $catalog[$catId]['items'] ?? [];
    return array_slice($items, 0, $n);
  };

  $megaCols = [
    [
      'title'   => 'Build',
      'tagline' => 'Sites & funnels',
      'icon'    => 'monitor',
      'href'    => url('/services/websites'),
      'items'   => $previewLinks('websites'),
      'catId'   => 'websites',
    ],
    [
      'title'   => 'Grow',
      'tagline' => 'SEO + ads + organic',
      'icon'    => 'search',
      'href'    => url('/services/seo'),
      'items'   => array_merge($previewLinks('seo', 2), $previewLinks('paid-ads', 2), $previewLinks('organic', 1)),
      'catId'   => 'seo',
    ],
    [
      'title'   => 'Automate',
      'tagline' => 'AI + CRM',
      'icon'    => 'brain',
      'href'    => url('/services/ai'),
      'items'   => array_merge($previewLinks('ai', 3), $previewLinks('crm-automation', 2)),
      'catId'   => 'ai',
    ],
    [
      'title'   => 'Secure',
      'tagline' => 'Hosting & infrastructure',
      'icon'    => 'shield',
      'href'    => url('/services/hosting'),
      'items'   => $previewLinks('hosting'),
      'catId'   => 'hosting',
    ],
    [
      'title'   => 'Brand',
      'tagline' => 'Identity & creative',
      'icon'    => 'sparkle',
      'href'    => url('/services/branding'),
      'items'   => $previewLinks('branding'),
      'catId'   => 'branding',
    ],
  ];

  // Mobile accordion: one section per real catalog category (8 sections).
  $mobileCats = collect($catalog)->sortBy('order')->all();
@endphp

<div class="dr-announce">
  <div class="dr-announce-inner">
    <span class="dr-pulse" aria-hidden="true"></span>
    <span>Now booking Q3 engagements — <a href="{{ $home }}#contact">claim your strategy call →</a></span>
  </div>
</div>

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

    {{-- Nav (center) --}}
    <ul class="dr-nav-list" aria-label="Primary">
      <li><a href="{{ $home }}" class="dr-nav-link @if($isHome) dr-active @endif">Home</a></li>

      <li class="dr-has-mega" data-mega>
        <button type="button" class="dr-nav-trigger" aria-haspopup="true" aria-expanded="false">
          Services
          <svg class="dr-caret" viewBox="0 0 12 12" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M3 4.5 L6 7.5 L9 4.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>

        <div class="dr-mega-panel" role="menu">
          <div class="dr-mega-grid">
            @foreach ($megaCols as $col)
              <div class="dr-mega-col">
                <div class="dr-mega-icon" aria-hidden="true">
                  @switch($col['icon'])
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
                <h6>{{ $col['title'] }} <span style="color:#64748b; font-weight:500; font-size:.7rem; letter-spacing:0; text-transform:none;">— {{ $col['tagline'] }}</span></h6>
                <ul>
                  @foreach ($col['items'] as $item)
                    <li><a href="{{ url('/shop/'.$item['slug']) }}">{{ Str::limit($item['name'], 36) }}</a></li>
                  @endforeach
                </ul>
                <a href="{{ $col['href'] }}" class="dr-mega-foot-link">Browse all →</a>
              </div>
            @endforeach
          </div>
          <div class="dr-mega-footer">
            <p><strong>SaaS-style ordering.</strong> 57 services, transparent pricing, no payment required to inquire.</p>
            <div class="dr-mega-footer-actions">
              <a href="{{ url('/services') }}" class="dr-mega-pill">All services</a>
              <a href="{{ url('/shop') }}" class="dr-mega-pill dr-primary">Visit Shop →</a>
            </div>
          </div>
        </div>
      </li>

      <li><a href="{{ url('/shop') }}" class="dr-nav-link @if($current === 'shop') dr-active @endif">Shop</a></li>
      <li><a href="{{ url('/pricing') }}" class="dr-nav-link @if($current === 'pricing') dr-active @endif">Pricing</a></li>
      <li><a href="{{ $home }}#results" class="dr-nav-link">Results</a></li>
      <li><a href="{{ $home }}#contact" class="dr-nav-link">Contact</a></li>
    </ul>

    {{-- Right cluster (phone + CTA) --}}
    <div class="dr-nav-right">
      <a href="tel:+14019987807" class="dr-nav-phone" aria-label="Call Digirisers">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.3 21 3 13.7 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
        <span>+1 (401) 998-7807</span>
      </a>
      <a href="{{ $home }}#contact" class="dr-cta">Start a project</a>
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
        <li class="dr-has-mega" data-mega-mobile>
          <button type="button" class="dr-mobile-trigger" aria-expanded="false">
            Services
            <svg class="dr-caret" viewBox="0 0 12 12" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M3 4.5 L6 7.5 L9 4.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <div class="dr-mobile-mega">
            <div class="dr-mobile-mega-inner">
              @foreach ($mobileCats as $mc)
                <div class="dr-mobile-cat">
                  <h6><a href="{{ url('/services/'.$mc['id']) }}" style="color:inherit;">{{ $mc['title'] }} →</a></h6>
                  <ul>
                    @foreach (array_slice($mc['items'], 0, 4) as $it)
                      <li><a href="{{ url('/shop/'.$it['slug']) }}">{{ Str::limit($it['name'], 32) }}</a></li>
                    @endforeach
                  </ul>
                </div>
              @endforeach
              <a href="{{ url('/services') }}" class="dr-mega-pill" style="align-self:flex-start;">View all services →</a>
            </div>
          </div>
        </li>
        <li><a href="{{ url('/shop') }}" class="dr-mobile-link">Shop</a></li>
        <li><a href="{{ url('/pricing') }}" class="dr-mobile-link">Pricing</a></li>
        <li><a href="{{ $home }}#results" class="dr-mobile-link">Results</a></li>
        <li><a href="{{ $home }}#contact" class="dr-mobile-link">Contact</a></li>
      </ul>

      <div class="dr-mobile-actions">
        <a href="tel:+14019987807" class="dr-nav-phone">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.3 21 3 13.7 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
          <span>+1 (401) 998-7807</span>
        </a>
        <a href="{{ $home }}#contact" class="dr-cta">Start a project</a>
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
    })();
  </script>
@endpush
