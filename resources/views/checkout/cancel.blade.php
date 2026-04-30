<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex,nofollow" />
  <title>Checkout cancelled · Digirisers</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Instrument+Serif&display=swap" rel="stylesheet">
  <style>
    :root { --green: #4AAE18; --green-700: #3a8c12; --ink: #0b1020; --soft: #64748b; --line: #e5e7eb; }
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; min-height: 100vh; font-family: 'Inter', system-ui, sans-serif; color: var(--ink); }
    body { background: #f7f8fb; display: grid; place-items: center; padding: 40px 24px; }
    .panel {
      background: #fff; border: 1px solid var(--line); border-radius: 22px;
      padding: 40px 32px; text-align: center; max-width: 480px; width: 100%;
      box-shadow: 0 50px 100px -50px rgba(11, 16, 32, .25);
    }
    .icon {
      width: 64px; height: 64px; margin: 0 auto 18px;
      background: #fef3c7; color: #d97706; border-radius: 50%;
      display: grid; place-items: center;
    }
    h1 { font-size: 1.6rem; margin: 0 0 8px; letter-spacing: -0.025em; }
    h1 em { font-family: 'Instrument Serif', serif; font-style: italic; font-weight: 400; color: var(--soft); }
    p { color: var(--soft); margin: 0 0 24px; line-height: 1.6; }
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 13px 22px; font: inherit; font-weight: 600; border-radius: 12px; text-decoration: none; }
    .btn-primary { background: var(--green); color: #fff; box-shadow: 0 14px 30px -12px rgba(74,174,24,.55); }
    .btn-primary:hover { background: var(--green-700); }
    .btn-ghost { background: transparent; color: var(--ink); border: 1px solid var(--line); }
  </style>
</head>
<body>
  <div class="panel">
    <span class="icon"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>
    <h1>Payment <em>cancelled.</em></h1>
    <p>No charge was made. Your details aren't lost — go back to checkout to try again, or browse other services.</p>
    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
      @if($order)
        <a href="{{ route('checkout.show', $order->service_slug) }}" class="btn btn-primary">Try checkout again</a>
      @endif
      <a href="{{ url('/shop') }}" class="btn btn-ghost">Browse services</a>
    </div>
  </div>
</body>
</html>
