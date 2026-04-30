<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="robots" content="noindex,nofollow" />
  <title>Payment received · Digirisers</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Instrument+Serif&display=swap" rel="stylesheet">
  <style>
    :root { --green: #4AAE18; --green-700: #3a8c12; --green-50: #effae6; --ink: #0b1020; --soft: #64748b; --line: #e5e7eb; }
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; min-height: 100vh; font-family: 'Inter', system-ui, sans-serif; color: var(--ink); }
    body {
      background: linear-gradient(180deg, var(--green-50) 0%, #fff 240px);
      display: grid; place-items: center;
      padding: 40px 24px;
    }
    .panel {
      width: 100%; max-width: 540px;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 22px;
      padding: 44px 36px 32px;
      text-align: center;
      box-shadow: 0 50px 100px -40px rgba(11, 16, 32, .25);
    }
    .check {
      width: 72px; height: 72px;
      border-radius: 50%;
      background: var(--green);
      color: #fff;
      display: grid; place-items: center;
      margin: 0 auto 20px;
      box-shadow: 0 18px 40px -12px rgba(74, 174, 24, .55);
      animation: pop .5s cubic-bezier(.34, 1.56, .64, 1) both;
    }
    .check.pending {
      background: #fef3c7; color: #d97706; box-shadow: none;
    }
    @keyframes pop { from { transform: scale(.6); opacity: 0; } to { transform: scale(1); opacity: 1; } }

    h1 { font-size: 1.7rem; margin: 0 0 8px; letter-spacing: -0.025em; }
    h1 em { font-family: 'Instrument Serif', serif; font-style: italic; font-weight: 400; color: var(--green); }
    p { color: var(--soft); line-height: 1.6; margin: 0 0 22px; }

    .order-meta {
      background: #fafafa;
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 14px 18px;
      margin: 18px 0;
      font-size: .88rem;
      text-align: left;
      display: grid; grid-template-columns: 130px 1fr; gap: 8px 14px;
    }
    .order-meta strong { color: var(--soft); font-weight: 500; font-size: .8rem; text-transform: uppercase; letter-spacing: .04em; }
    .order-meta span { color: var(--ink); font-weight: 600; word-break: break-all; }

    .btn {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 13px 22px;
      font: inherit; font-size: .95rem; font-weight: 600;
      border-radius: 12px; text-decoration: none;
      transition: transform .2s ease, box-shadow .25s ease, background .25s ease;
    }
    .btn-primary { background: var(--green); color: #fff; box-shadow: 0 14px 30px -12px rgba(74,174,24,.55); }
    .btn-primary:hover { transform: translateY(-1px); background: var(--green-700); }
    .btn-ghost { background: transparent; color: var(--ink); border: 1px solid var(--line); }
    .btn-ghost:hover { border-color: var(--ink); }

    #status-pending { color: #b45309; font-weight: 600; }
    #status-paid { color: var(--green-700); font-weight: 600; }
    .spinner {
      display: inline-block; width: 12px; height: 12px;
      border: 2px solid rgba(180, 83, 9, .25); border-top-color: #b45309;
      border-radius: 50%; animation: spin 1s linear infinite; margin-right: 6px; vertical-align: -2px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
  </style>
</head>
<body>

  <div class="panel">
    @if($order && $order->payment_status === 'paid')
      <div class="check">
        <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <h1>Payment <em>received.</em></h1>
      <p>Thanks {{ $order->first_name }} — we've got your order. A senior strategist will reach out within one business day to kick off.</p>
    @elseif($order)
      <div class="check pending">
        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <h1>Confirming your <em>payment.</em></h1>
      <p id="status-pending"><span class="spinner"></span>Stripe is finalizing the charge. This usually takes under 10 seconds.</p>
    @else
      <div class="check pending">
        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      </div>
      <h1>Looking for your order…</h1>
      <p>If you came here from Stripe, give it a few seconds. Otherwise <a href="{{ url('/shop') }}">browse services</a>.</p>
    @endif

    @if($order)
      <div class="order-meta">
        <strong>Order</strong><span>{{ $order->order_number }}</span>
        <strong>Service</strong><span>{{ $order->service_name }}</span>
        <strong>Amount</strong><span>{{ $order->formatted_amount }} {{ $order->cycle_label }}</span>
        <strong>Status</strong><span id="status-cell">{{ ucfirst($order->payment_status) }}</span>
      </div>
    @endif

    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 8px;">
      @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to dashboard →</a>
      @else
        <a href="{{ route('auth.show') }}" class="btn btn-primary">Sign in to track →</a>
      @endauth
      <a href="{{ url('/shop') }}" class="btn btn-ghost">Browse more services</a>
    </div>
  </div>

  @if($order && $order->payment_status !== 'paid')
    <script>
      // Poll the backend until the webhook flips the order to 'paid'.
      // The DB is the source of truth — never assume success from the
      // client, even though Stripe redirected here.
      (function () {
        const sid = @json($sessionId);
        if (!sid) return;
        let tries = 0;
        const maxTries = 30; // ~60s

        const tick = async () => {
          if (tries++ >= maxTries) return;
          try {
            const r = await fetch('{{ route('checkout.status') }}?session_id=' + encodeURIComponent(sid), { credentials: 'same-origin' });
            if (!r.ok) { setTimeout(tick, 2000); return; }
            const j = await r.json();
            if (j.status === 'paid') {
              const cell = document.getElementById('status-cell');
              if (cell) { cell.id = 'status-paid'; cell.textContent = 'Paid'; }
              if (j.is_authed && j.redirect_to) {
                setTimeout(() => { window.location.href = j.redirect_to; }, 1500);
              } else {
                window.location.reload();
              }
              return;
            }
            setTimeout(tick, 2000);
          } catch (e) {
            setTimeout(tick, 2500);
          }
        };
        setTimeout(tick, 1500);
      })();
    </script>
  @endif

</body>
</html>
