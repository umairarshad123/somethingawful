<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="robots" content="noindex,nofollow" />
  <title>Admin sign-in · Digirisers</title>

  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Instrument+Serif&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; padding: 0; min-height: 100vh; font-family: 'Inter', system-ui, sans-serif; color: #0b1020; }
    body {
      background: #060816;
      display: grid; place-items: center;
      padding: 24px;
      position: relative; overflow: hidden;
    }
    body::before {
      content: ""; position: absolute; inset: 0;
      background-image:
        radial-gradient(ellipse 50% 50% at 18% 10%, rgba(59,130,246,.32) 0%, transparent 60%),
        radial-gradient(ellipse 50% 50% at 88% 90%, rgba(168,85,247,.22) 0%, transparent 60%),
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
      background-size: auto, auto, 56px 56px, 56px 56px;
      pointer-events: none;
    }
    body::after {
      content: ""; position: absolute; inset: 0;
      background: radial-gradient(ellipse 80% 70% at 50% 50%, transparent 30%, rgba(6,8,22,.85) 100%);
      pointer-events: none;
    }

    .shell {
      position: relative; z-index: 1;
      width: 100%; max-width: 440px;
    }

    .lead {
      color: rgba(255,255,255,.65);
      font-size: .76rem; font-weight: 600; letter-spacing: .22em; text-transform: uppercase;
      display: inline-flex; align-items: center; gap: 10px;
      margin-bottom: 20px;
    }
    .lead .dot {
      width: 8px; height: 8px; border-radius: 50%; background: #34d399;
      box-shadow: 0 0 0 4px rgba(52,211,153,.18), 0 0 18px rgba(52,211,153,.55);
      animation: pulse 2.5s infinite;
    }
    @keyframes pulse { 50% { opacity: .55; } }

    h1 {
      color: #fff;
      font-size: clamp(2rem, 5vw, 2.6rem);
      letter-spacing: -0.035em; margin: 0 0 10px;
      line-height: 1.05;
    }
    h1 em {
      font-family: 'Instrument Serif', ui-serif, Georgia, serif;
      font-style: italic; font-weight: 400;
      background: linear-gradient(135deg, #93c5fd, #c4b5fd);
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    p.sub {
      color: rgba(255,255,255,.55);
      font-size: .95rem; line-height: 1.55;
      margin: 0 0 32px;
    }

    .panel {
      background: rgba(15, 23, 42, .68);
      backdrop-filter: blur(28px) saturate(160%);
      -webkit-backdrop-filter: blur(28px) saturate(160%);
      border: 1px solid rgba(255,255,255,.08);
      border-radius: 22px;
      padding: 30px 28px 26px;
      box-shadow:
        0 60px 120px -40px rgba(0,0,0,.7),
        inset 0 1px 0 rgba(255,255,255,.06);
    }
    .panel-title {
      display: flex; align-items: center; gap: 10px;
      color: #fff; font-size: 1rem; font-weight: 600;
      margin: 0 0 22px;
    }
    .panel-title .badge {
      font-size: .68rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase;
      padding: 3px 9px; border-radius: 999px;
      background: rgba(59,130,246,.18); color: #93c5fd;
      border: 1px solid rgba(59,130,246,.3);
    }

    label {
      display: block;
      font-size: .72rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
      color: rgba(255,255,255,.55);
      margin-bottom: 6px;
    }
    .field { margin-bottom: 16px; }
    input[type=email], input[type=password] {
      width: 100%;
      padding: 13px 16px;
      font: inherit; font-size: .95rem;
      color: #fff;
      background: rgba(255,255,255,.04);
      border: 1.5px solid rgba(255,255,255,.08);
      border-radius: 12px;
      transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
    }
    input[type=email]::placeholder, input[type=password]::placeholder { color: rgba(255,255,255,.3); }
    input[type=email]:focus, input[type=password]:focus {
      outline: none;
      border-color: #60a5fa;
      background: rgba(255,255,255,.07);
      box-shadow: 0 0 0 4px rgba(59,130,246,.18);
    }

    .row {
      display: flex; align-items: center; justify-content: space-between;
      gap: 12px; margin-bottom: 22px;
    }
    .check {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: .85rem; color: rgba(255,255,255,.65); cursor: pointer;
    }
    .check input { accent-color: #3b82f6; width: 14px; height: 14px; }

    button.submit {
      width: 100%; padding: 14px 18px;
      font: inherit; font-size: .96rem; font-weight: 600;
      color: #0b1020;
      background: linear-gradient(135deg, #93c5fd 0%, #fff 50%, #c4b5fd 100%);
      background-size: 200% 200%;
      border: 0; border-radius: 12px;
      cursor: pointer;
      box-shadow: 0 18px 40px -16px rgba(147,197,253,.5);
      transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease, background-position .4s ease;
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    }
    button.submit:hover { transform: translateY(-1px); box-shadow: 0 24px 48px -16px rgba(147,197,253,.6); background-position: 100% 100%; }
    button.submit:active { transform: translateY(0); }

    .error {
      background: rgba(239,68,68,.1);
      border: 1px solid rgba(239,68,68,.35);
      color: #fca5a5;
      padding: 11px 14px; border-radius: 10px;
      font-size: .88rem;
      margin-bottom: 18px;
    }

    .foot {
      margin-top: 22px;
      padding-top: 18px;
      border-top: 1px solid rgba(255,255,255,.06);
      font-size: .76rem; color: rgba(255,255,255,.4);
      text-align: center;
      line-height: 1.6;
    }
    .foot a { color: rgba(255,255,255,.6); }

    @media (max-width: 480px) {
      .panel { padding: 24px 20px 22px; }
    }
  </style>
</head>
<body>

  <div class="shell">
    <span class="lead"><span class="dot"></span>Restricted area</span>

    <h1>Sign in to <em>operations.</em></h1>
    <p class="sub">This panel is for Digirisers admins only. All access is logged.</p>

    <div class="panel">
      <h2 class="panel-title">
        Admin console
        <span class="badge">/thebestadmin</span>
      </h2>

      @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('admin.login.attempt') }}" novalidate>
        @csrf

        <div class="field">
          <label for="email">Admin email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@digirisers.com" autocomplete="username" required />
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required />
        </div>

        <div class="row">
          <label class="check">
            <input type="checkbox" name="remember" value="1"> Stay signed in
          </label>
          <span style="font-size:.78rem; color:rgba(255,255,255,.4);">Sessions expire on logout</span>
        </div>

        <button type="submit" class="submit">
          Enter console
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>
      </form>

      <div class="foot">
        Not an admin? <a href="{{ url('/auth') }}">Customer sign-in</a><br>
        <small>Unauthorized access attempts are recorded.</small>
      </div>
    </div>
  </div>

</body>
</html>
