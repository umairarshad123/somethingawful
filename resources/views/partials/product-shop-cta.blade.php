{{--
  Product detail page → Shop CTA bar.

  Renders only when $item is in scope, which happens for:
    - /shop/{slug} bespoke views (resources/views/services/{slug}.blade.php)
    - /shop/{slug} dynamic fallback (shop-detail.blade.php)

  Two states: guest (sign-in) and authed (browse + buy).
--}}

@isset($item)
@push('styles')
  <style>
    .ps-cta {
      padding: 56px 0 64px;
      background: linear-gradient(180deg, #f5f8ff 0%, #fff 100%);
      border-top: 1px solid var(--line, #e5e7eb);
    }
    .ps-cta-card {
      max-width: 980px; margin: 0 auto; padding: 32px 36px;
      background: #fff;
      border: 1px solid var(--line, #e5e7eb);
      border-radius: 22px;
      box-shadow: 0 30px 70px -40px rgba(11,16,32,.18), 0 4px 14px -8px rgba(11,16,32,.06);
      display: grid; grid-template-columns: auto 1fr auto; gap: 24px;
      align-items: center;
    }
    .ps-cta-icon {
      width: 56px; height: 56px;
      display: grid; place-items: center;
      border-radius: 14px;
      background: #eff6ff; color: #1d4ed8;
      flex-shrink: 0;
    }
    .ps-cta-copy h3 {
      font-size: 1.15rem; font-weight: 700; color: #0b1020;
      margin: 0 0 4px; letter-spacing: -0.02em;
    }
    .ps-cta-copy p {
      font-size: .92rem; color: #475569; margin: 0; line-height: 1.5;
    }
    .ps-cta-actions { display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end; }
    .ps-btn {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 11px 18px; border-radius: 999px;
      font-size: .88rem; font-weight: 600;
      text-decoration: none; white-space: nowrap;
      transition: transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease, border-color .2s ease;
      border: 1px solid transparent;
    }
    .ps-btn-primary {
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      color: #fff;
      box-shadow: 0 10px 24px -10px rgba(37,99,235,.55);
    }
    .ps-btn-primary:hover { transform: translateY(-1px); color: #fff; box-shadow: 0 16px 32px -10px rgba(37,99,235,.7); }
    .ps-btn-buy {
      background: #16a34a;
      color: #fff;
      box-shadow: 0 10px 24px -10px rgba(22,163,74,.55);
    }
    .ps-btn-buy:hover { transform: translateY(-1px); color: #fff; background: #15803d; }
    .ps-btn-ghost {
      background: #fff; color: #0b1020;
      border-color: #cbd5e1;
    }
    .ps-btn-ghost:hover { background: #0b1020; color: #fff; border-color: #0b1020; }

    @media (max-width: 760px) {
      .ps-cta-card { grid-template-columns: 1fr; padding: 24px 22px; gap: 18px; text-align: center; }
      .ps-cta-icon { margin: 0 auto; }
      .ps-cta-actions { justify-content: center; }
      .ps-btn { flex: 1 1 auto; justify-content: center; }
    }

    .ps-fab {
      position: fixed; right: 18px; bottom: 18px;
      z-index: 95;
      display: inline-flex; align-items: center; gap: 8px;
      padding: 12px 18px; border-radius: 999px;
      font-size: .9rem; font-weight: 600;
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      color: #fff; text-decoration: none;
      box-shadow: 0 18px 40px -16px rgba(11,16,32,.45), 0 8px 20px -10px rgba(37,99,235,.55);
      transition: transform .2s ease, box-shadow .25s ease;
    }
    .ps-fab:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 24px 48px -16px rgba(11,16,32,.55), 0 16px 30px -12px rgba(37,99,235,.7); }
    .ps-fab svg { color: #fff; }
    @media (max-width: 480px) {
      .ps-fab { right: 12px; bottom: 12px; padding: 10px 14px; font-size: .85rem; }
    }
  </style>
@endpush

<a href="{{ auth()->check() ? url('/shop') : route('auth.show') }}" class="ps-fab" aria-label="{{ auth()->check() ? 'Browse the Shop' : 'Sign in to browse the Shop' }}">
  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4"/><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/></svg>
  {{ auth()->check() ? 'Shop' : 'Sign in to Shop' }}
</a>

<section class="ps-cta" aria-label="Shop access">
  <div class="container">
    <div class="ps-cta-card">
      <div class="ps-cta-icon" aria-hidden="true">
        @auth
          <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4"/>
            <circle cx="9" cy="20" r="1.5"/>
            <circle cx="18" cy="20" r="1.5"/>
          </svg>
        @else
          <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        @endauth
      </div>

      <div class="ps-cta-copy">
        @auth
          <h3>Browse the full Shop, or buy this package now.</h3>
          <p>You're signed in — full pricing is unlocked. Visit the Shop to see every package side by side, or check out this one in seconds.</p>
        @else
          <h3>Sign in to browse the Shop.</h3>
          <p>Pricing and the full Shop are visible to signed-in members. Create a free account in 30 seconds — no payment info needed.</p>
        @endauth
      </div>

      <div class="ps-cta-actions">
        @auth
          <a href="{{ url('/shop') }}" class="ps-btn ps-btn-primary">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4"/></svg>
            Browse the Shop
          </a>
          <a href="{{ route('checkout.show', $item['slug']) }}" class="ps-btn ps-btn-buy">
            Buy this now
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        @else
          <a href="{{ route('auth.show', ['tab' => 'signup']) }}" class="ps-btn ps-btn-primary">
            Create account
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
          <a href="{{ route('auth.show') }}" class="ps-btn ps-btn-ghost">Sign in</a>
          <a href="{{ url('/shop') }}" class="ps-btn ps-btn-ghost">Browse Shop</a>
        @endauth
      </div>
    </div>
  </div>
</section>
@endisset
