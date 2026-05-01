{{--
  Footer Partial — Digirisers
  Used across all pages to ensure consistent navigation and links.
--}}

@push('styles')
  <style>
    .footer {
      background: var(--ink, #0b1020); color: rgba(255,255,255,.72);
      padding: 80px 0 28px; position: relative; overflow: hidden;
    }
    .footer::before {
      content: ""; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
      width: 1200px; height: 600px;
      background: radial-gradient(ellipse at center top, rgba(59,130,246,.18), transparent 60%);
      pointer-events: none;
    }
    .footer .container { position: relative; }
    .footer-cta {
      display: flex; flex-direction: column; align-items: center; gap: 24px;
      padding-bottom: 64px; margin-bottom: 56px;
      border-bottom: 1px solid rgba(255,255,255,.08); text-align: center;
    }
    .footer-cta h2 { color: #fff; max-width: 800px; }
    .footer-cta h2 .serif-italic { color: var(--blue-300, #93c5fd); }
    .footer-inner {
      display: grid; grid-template-columns: 1.2fr 2.2fr; gap: 64px;
      padding-bottom: 56px;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .footer .logo-text { color: #fff; }
    .footer .logo-dot { color: var(--blue-400, #60a5fa); }
    .footer .logo:hover { color: #fff; }
    .footer-brand p { max-width: 320px; font-size: .95rem; color: rgba(255,255,255,.6); margin: 16px 0 20px; }
    .footer-phone {
      display: inline-block; color: #fff; font-weight: 600; font-size: 1.05rem;
      padding: 10px 16px; border: 1px solid rgba(255,255,255,.15); border-radius: 10px;
      transition: all .2s ease;
    }
    .footer-phone:hover { background: rgba(255,255,255,.08); border-color: var(--blue-400, #60a5fa); color: #fff; }
    .footer-cols { display: grid; grid-template-columns: repeat(5, 1fr); gap: 24px; }
    .footer-cols h5 {
      color: #fff; margin: 0 0 18px; font-size: .8rem;
      font-weight: 600; letter-spacing: .12em; text-transform: uppercase;
    }
    .footer-cols ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 10px; }
    .footer-cols a { font-size: .9rem; color: rgba(255,255,255,.6); transition: color .2s ease; }
    .footer-cols a:hover { color: #fff; }
    .footer-bottom {
      display: flex; justify-content: space-between; align-items: center;
      padding-top: 28px; color: rgba(255,255,255,.5); font-size: .85rem;
      flex-wrap: wrap; gap: 10px;
    }
    .footer-links a { color: rgba(255,255,255,.65); }
    .footer-links a:hover { color: #fff; }
    .footer-links span { opacity: .4; margin: 0 8px; }

    @media (max-width: 980px) {
      .footer-inner { grid-template-columns: 1fr; gap: 40px; }
      .footer-cols { grid-template-columns: repeat(3, 1fr); gap: 28px; }
    }
    @media (max-width: 640px) {
      .footer-cols { grid-template-columns: repeat(2, 1fr); }
      .footer-bottom { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 420px) {
      .footer-cols { grid-template-columns: 1fr; }
    }
  </style>
@endpush

<footer class="footer">
  <div class="container">
    @unless(($hideFooterCta ?? false))
      <div class="footer-cta">
        <h2>Let's build something <span class="serif-italic">that grows.</span></h2>
        <a href="{{ url('/') }}#contact" class="btn btn-light btn-lg">Start your project →</a>
      </div>
    @endunless

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
        <a href="{{ route('contact') }}" class="footer-phone">Contact us →</a>
      </div>

      <div class="footer-cols">
        <div>
          <h5>Build</h5>
          <ul>
            <li><a href="{{ url('/shop/custom-site') }}">Full-Stack Dev</a></li>
            <li><a href="{{ url('/shop/wp-business') }}">WordPress</a></li>
            <li><a href="{{ url('/shop/custom-site-integrations') }}">Laravel &amp; APIs</a></li>
            <li><a href="{{ url('/shop/ecommerce') }}">E-commerce</a></li>
            <li><a href="{{ url('/shop/security-implementation') }}">Security</a></li>
          </ul>
        </div>
        <div>
          <h5>Grow</h5>
          <ul>
            <li><a href="{{ url('/services/seo') }}">SEO</a></li>
            <li><a href="{{ url('/shop/aeo-optimization') }}">AI Search</a></li>
            <li><a href="{{ url('/shop/ads-management') }}">PPC</a></li>
            <li><a href="{{ url('/shop/social-management') }}">Social</a></li>
            <li><a href="{{ url('/shop/email-automation') }}">Email/SMS</a></li>
          </ul>
        </div>
        <div>
          <h5>Convert</h5>
          <ul>
            <li><a href="{{ url('/shop/custom-site') }}">Web Design</a></li>
            <li><a href="{{ url('/shop/ecommerce') }}">Ecommerce</a></li>
            <li><a href="{{ url('/shop/funnel-build') }}">Funnels</a></li>
            <li><a href="{{ url('/shop/cro-audit') }}">CRO</a></li>
            <li><a href="{{ url('/shop/conversion-tracking') }}">Tracking</a></li>
          </ul>
        </div>
        <div>
          <h5>Automate</h5>
          <ul>
            <li><a href="{{ url('/shop/ai-sales-agent') }}">AI Agents</a></li>
            <li><a href="{{ url('/shop/ghl-full-setup') }}">GoHighLevel</a></li>
            <li><a href="{{ url('/shop/zapier-zap') }}">Zapier</a></li>
            <li><a href="{{ url('/shop/lead-management') }}">Lead Mgmt</a></li>
            <li><a href="{{ url('/shop/workflow-orchestration') }}">Workflows</a></li>
          </ul>
        </div>
        <div>
          <h5>Company</h5>
          <ul>
            <li><a href="{{ url('/services') }}">All Services</a></li>
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="{{ url('/privacy') }}">Privacy</a></li>
            <li><a href="{{ url('/terms') }}">Terms</a></li>
            <li><a href="{{ url('/refund') }}">Refund</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <small>&copy; <span id="year"></span> Digirisers. All rights reserved.</small>
      <small class="footer-links">
        <a href="{{ url('/services') }}">Services</a> <span>&bull;</span>
        <a href="{{ url('/shop') }}">Shop</a> <span>&bull;</span>
        <a href="{{ route('contact') }}">Contact</a> <span>&bull;</span>
        <a href="{{ url('/privacy') }}">Privacy</a> <span>&bull;</span>
        <a href="{{ url('/terms') }}">Terms</a> <span>&bull;</span>
        <a href="{{ url('/refund') }}">Refund</a>
      </small>
    </div>
  </div>
</footer>

@push('scripts')
  <script>
    (function () {
      const yearEl = document.getElementById('year');
      if (yearEl) yearEl.textContent = new Date().getFullYear();
    })();
  </script>
@endpush
