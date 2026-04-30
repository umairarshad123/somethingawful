<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="robots" content="noindex,nofollow" />
  <title>Checkout · {{ $item['name'] }} — Digirisers</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Instrument+Serif&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

  <style>
    :root {
      --green:      #4AAE18;
      --green-700:  #3a8c12;
      --green-50:   #effae6;
      --ink:        #0b1020;
      --soft:       #64748b;
      --soft-2:     #94a3b8;
      --line:       #e5e7eb;
      --bg:         #f7f8fb;
    }
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; min-height: 100vh; }
    body {
      background: var(--bg);
      color: var(--ink);
      font-family: 'Inter', system-ui, sans-serif;
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }

    .ck-top {
      background: #fff;
      border-bottom: 1px solid var(--line);
      padding: 16px 32px;
      display: flex; align-items: center; justify-content: space-between; gap: 18px;
      position: sticky; top: 0; z-index: 30;
    }
    .ck-logo {
      display: inline-flex; align-items: center; gap: 10px;
      font-weight: 700; font-size: 1.05rem; color: var(--ink); text-decoration: none;
      letter-spacing: -0.02em;
    }
    .ck-logo .mark {
      width: 28px; height: 28px; border-radius: 8px;
      background: linear-gradient(135deg, #60a5fa, #1e3a8a);
      color: #fff; display: grid; place-items: center; font-weight: 800; font-size: .82rem;
    }
    .ck-logo .dot { color: #2563eb; }
    .ck-step { display: inline-flex; align-items: center; gap: 8px; font-size: .82rem; color: var(--soft); font-family: 'JetBrains Mono', monospace; }
    .ck-step .pip { width: 10px; height: 10px; border-radius: 50%; background: var(--green); box-shadow: 0 0 0 3px var(--green-50); }
    .ck-secure {
      display: inline-flex; align-items: center; gap: 7px;
      font-size: .82rem; color: var(--soft);
    }
    .ck-secure svg { color: var(--green); }

    .ck-main { padding: 40px 24px 80px; }
    .ck-grid {
      display: grid;
      grid-template-columns: 1fr 380px;
      gap: 36px;
      max-width: 1100px;
      margin: 0 auto;
    }

    /* Left column: form */
    .ck-form-wrap h1 {
      font-size: clamp(1.6rem, 3vw, 2.1rem);
      letter-spacing: -0.025em;
      margin: 0 0 8px;
    }
    .ck-form-wrap h1 em {
      font-family: 'Instrument Serif', serif; font-style: italic; font-weight: 400;
      color: var(--green);
    }
    .ck-form-wrap > p.lede { color: var(--soft); margin: 0 0 26px; font-size: .98rem; }

    .ck-card {
      background: #fff; border: 1px solid var(--line); border-radius: 16px;
      padding: 24px; margin-bottom: 18px;
    }
    .ck-card h2 { font-size: 1rem; margin: 0 0 16px; display: flex; align-items: center; gap: 10px; }
    .ck-card h2 .badge {
      width: 22px; height: 22px; border-radius: 50%;
      background: var(--green); color: #fff; font-size: .76rem; font-weight: 700;
      display: grid; place-items: center;
    }

    .ck-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px; }
    .ck-field { display: flex; flex-direction: column; }
    .ck-field label {
      font-size: .72rem; font-weight: 600; color: var(--soft);
      letter-spacing: .04em; text-transform: uppercase;
      margin-bottom: 6px;
    }
    .ck-field input, .ck-field textarea {
      padding: 11px 14px;
      font: inherit; font-size: .94rem;
      color: var(--ink); background: #fff;
      border: 1.5px solid var(--line); border-radius: 10px;
      transition: border-color .2s ease, box-shadow .2s ease;
    }
    .ck-field input:focus, .ck-field textarea:focus {
      outline: none;
      border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(74, 174, 24, .18);
    }
    .ck-field textarea { resize: vertical; min-height: 90px; }
    .ck-field .req { color: var(--green); }

    .ck-error {
      padding: 10px 14px; margin-bottom: 14px;
      background: #fef2f2; border: 1px solid #fecaca;
      color: #b91c1c; border-radius: 10px;
      font-size: .9rem;
    }

    /* Right column: order summary */
    .ck-summary {
      position: sticky; top: 86px; align-self: start;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 16px;
      overflow: hidden;
    }
    .ck-summary-head {
      padding: 18px 22px;
      background: linear-gradient(135deg, var(--ink) 0%, #1e3a8a 100%);
      color: #fff;
    }
    .ck-summary-head h3 { color: #fff; margin: 0; font-size: 1rem; }
    .ck-summary-head small { color: rgba(255,255,255,.7); font-size: .8rem; }

    .ck-summary-body { padding: 22px; }
    .ck-item-name { font-size: 1.02rem; font-weight: 700; margin: 0 0 6px; line-height: 1.3; }
    .ck-item-blurb { font-size: .85rem; color: var(--soft); line-height: 1.55; margin: 0 0 18px; }

    .ck-cycle-pill {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 5px 11px; border-radius: 999px;
      background: var(--green-50); color: var(--green-700);
      font-size: .74rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
      margin-bottom: 14px;
    }
    .ck-cycle-pill::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: var(--green); }

    .ck-prices { border-top: 1px dashed var(--line); padding-top: 14px; }
    .ck-price-row { display: flex; justify-content: space-between; align-items: baseline; padding: 6px 0; font-size: .9rem; color: var(--soft); }
    .ck-price-row strong { color: var(--ink); font-weight: 600; }
    .ck-price-total {
      display: flex; justify-content: space-between; align-items: baseline;
      padding: 14px 0 0;
      border-top: 1px solid var(--line); margin-top: 10px;
      font-size: 1.08rem; font-weight: 700; color: var(--ink);
    }
    .ck-price-total .amt { color: var(--green); font-size: 1.5rem; letter-spacing: -0.02em; }

    .ck-trust {
      padding: 14px 22px;
      border-top: 1px solid var(--line);
      background: #fafbff;
      font-size: .82rem; color: var(--soft);
    }
    .ck-trust ul { list-style: none; padding: 0; margin: 0; display: grid; gap: 8px; }
    .ck-trust li { display: flex; align-items: flex-start; gap: 8px; line-height: 1.5; }
    .ck-trust svg { color: var(--green); flex-shrink: 0; margin-top: 3px; }

    .ck-pay {
      display: inline-flex; align-items: center; justify-content: center; gap: 10px;
      width: 100%;
      padding: 16px 22px;
      background: var(--green); color: #fff;
      border: 0; border-radius: 12px;
      font: inherit; font-size: 1rem; font-weight: 700;
      cursor: pointer; letter-spacing: -0.005em;
      box-shadow: 0 14px 30px -12px rgba(74, 174, 24, .55);
      transition: transform .2s ease, box-shadow .25s ease, background .25s ease;
    }
    .ck-pay:hover { transform: translateY(-1px); background: var(--green-700); box-shadow: 0 18px 38px -12px rgba(74, 174, 24, .65); }
    .ck-pay:disabled { opacity: .65; cursor: not-allowed; transform: none; }
    .ck-tip { font-size: .78rem; color: var(--soft); margin-top: 10px; text-align: center; line-height: 1.5; }

    @media (max-width: 940px) {
      .ck-grid { grid-template-columns: 1fr; }
      .ck-summary { position: static; }
      .ck-row { grid-template-columns: 1fr; }
      .ck-top { padding: 14px 18px; }
      .ck-main { padding: 28px 18px 60px; }
    }
  </style>
</head>
<body>

  <header class="ck-top">
    <a href="{{ url('/') }}" class="ck-logo">
      <span class="mark">D</span>
      <span>Digirisers<span class="dot">.</span></span>
    </a>
    <span class="ck-step"><span class="pip"></span>SECURE CHECKOUT · STEP 1 OF 2</span>
    <span class="ck-secure">
      <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      SSL · 256-bit
    </span>
  </header>

  <main class="ck-main">
    <div class="ck-grid">

      {{-- LEFT: form --}}
      <section class="ck-form-wrap">
        <h1>Almost <em>there.</em></h1>
        <p class="lede">A few details and you're checked out via Stripe — secure, encrypted, your card never touches our servers.</p>

        @if ($errors->any())
          <div class="ck-error"><strong>Heads up:</strong> {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('checkout.store', $item['slug']) }}" id="checkoutForm">
          @csrf

          <div class="ck-card">
            <h2><span class="badge">1</span> Your details</h2>
            <div class="ck-row">
              <div class="ck-field">
                <label>First name <span class="req">*</span></label>
                <input type="text" name="first_name" value="{{ old('first_name', auth()->user()?->first_name) }}" required autocomplete="given-name" />
              </div>
              <div class="ck-field">
                <label>Last name <span class="req">*</span></label>
                <input type="text" name="last_name" value="{{ old('last_name', auth()->user()?->last_name) }}" required autocomplete="family-name" />
              </div>
            </div>
            <div class="ck-row">
              <div class="ck-field">
                <label>Email <span class="req">*</span></label>
                <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required autocomplete="email" />
              </div>
              <div class="ck-field">
                <label>Phone <span class="req">*</span></label>
                <input type="tel" name="phone" value="{{ old('phone', auth()->user()?->phone) }}" required autocomplete="tel" />
              </div>
            </div>
          </div>

          <div class="ck-card">
            <h2><span class="badge">2</span> Business</h2>
            <div class="ck-row">
              <div class="ck-field">
                <label>Company / business name</label>
                <input type="text" name="company" value="{{ old('company', auth()->user()?->company) }}" autocomplete="organization" />
              </div>
              <div class="ck-field">
                <label>Website URL</label>
                <input type="url" name="website" value="{{ old('website') }}" placeholder="https://" autocomplete="url" />
              </div>
            </div>
            <div class="ck-field" style="margin-top: 6px;">
              <label>Project notes / details</label>
              <textarea name="notes" placeholder="Anything specific about scope, timing, integrations…">{{ old('notes') }}</textarea>
            </div>
          </div>

          <button type="submit" class="ck-pay" id="ckPay">
            Pay {{ '$' . number_format((float) $item['price'], 2) }} {{ $isRecurring ? '— start subscription' : 'securely' }}
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </button>
          <p class="ck-tip">You'll be redirected to Stripe to enter card details. Powered by Stripe · PCI DSS Level 1.</p>
        </form>
      </section>

      {{-- RIGHT: summary --}}
      <aside class="ck-summary">
        <div class="ck-summary-head">
          <h3>Order summary</h3>
          <small>{{ $cat['title'] ?? 'Service' }}</small>
        </div>
        <div class="ck-summary-body">
          <span class="ck-cycle-pill">{{ $cycleLabel }}</span>
          <h4 class="ck-item-name">{{ $item['name'] }}</h4>
          <p class="ck-item-blurb">{{ $item['blurb'] ?? $item['detail'] ?? '' }}</p>

          <div class="ck-prices">
            <div class="ck-price-row"><span>Service</span><strong>{{ '$' . number_format((float) $item['price'], 2) }}</strong></div>
            <div class="ck-price-row"><span>Quantity</span><strong>1</strong></div>
            <div class="ck-price-row"><span>Currency</span><strong>{{ $currencyCode }}</strong></div>
            <div class="ck-price-total">
              <span>{{ $isRecurring ? 'Charged today' : 'Total' }}</span>
              <span class="amt">{{ '$' . number_format((float) $item['price'], 2) }}</span>
            </div>
          </div>
        </div>

        <div class="ck-trust">
          <ul>
            <li><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Encrypted payment via Stripe</li>
            <li><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Card details never touch our servers</li>
            <li><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> 14-day satisfaction window on every project</li>
            @if($isRecurring)
              <li><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Cancel anytime from your dashboard</li>
            @endif
          </ul>
        </div>
      </aside>

    </div>
  </main>

  <script>
    document.getElementById('checkoutForm')?.addEventListener('submit', function() {
      const btn = document.getElementById('ckPay');
      btn.disabled = true;
      btn.innerHTML = 'Redirecting to Stripe…';
    });
  </script>
</body>
</html>
