@extends('layouts.app')

@section('title', 'Digirisers — Digital Marketing That Rises Above')
@section('description', 'Digirisers — full-service digital marketing agency. SEO, PPC, web design, content, social, AI, ecommerce and more.')

@push('styles')
  <style>
    /* =========================================
       Digirisers — Premium Design System
       Blue · White · Black
       ========================================= */

    :root {
      --blue-50:  #eff6ff;
      --blue-100: #dbeafe;
      --blue-200: #bfdbfe;
      --blue-300: #93c5fd;
      --blue-400: #60a5fa;
      --blue-500: #3b82f6;
      --blue-600: #2563eb;
      --blue-700: #1d4ed8;
      --blue-800: #1e40af;
      --blue-900: #1e3a8a;
      --blue-ink: #0b1020;

      --black:    #050505;
      --ink:      #0b1020;
      --ink-2:    #111827;
      --muted:    #475569;
      --soft:     #64748b;
      --soft-2:   #94a3b8;
      --line:     #e5e7eb;
      --line-2:   #eef1f5;
      --bg:       #ffffff;
      --bg-soft:  #f8fafc;
      --bg-tint:  #fafbff;

      --r-sm: 10px;
      --r:    14px;
      --r-md: 20px;
      --r-lg: 28px;

      --shadow-xs: 0 1px 2px rgba(11, 16, 32, .04);
      --shadow-sm: 0 2px 6px rgba(11, 16, 32, .06), 0 1px 2px rgba(11, 16, 32, .04);
      --shadow:    0 14px 40px -18px rgba(30, 58, 138, .25);
      --shadow-lg: 0 40px 80px -30px rgba(30, 58, 138, .35);
      --ring-blue: 0 0 0 4px rgba(59, 130, 246, .18);

      --grad:      linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      --grad-alt:  linear-gradient(135deg, #60a5fa 0%, #2563eb 50%, #1e3a8a 100%);
      --grad-soft: linear-gradient(180deg, #f5f8ff 0%, #ffffff 60%);
      --grad-ink:  linear-gradient(135deg, #0b1020 0%, #1e293b 100%);

      --font: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
      --font-serif: 'Instrument Serif', ui-serif, Georgia, serif;
      --font-mono: 'JetBrains Mono', ui-monospace, monospace;
    }

    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; -webkit-text-size-adjust: 100%; scroll-padding-top: 100px; }
    body {
      margin: 0;
      font-family: var(--font);
      color: var(--ink);
      background: var(--bg);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-feature-settings: "ss01", "cv11";
    }
    img { max-width: 100%; display: block; }
    a { color: inherit; text-decoration: none; transition: color .2s ease; }

    h1, h2, h3, h4, h5 {
      color: var(--ink);
      margin: 0 0 .4em;
      line-height: 1.08;
      letter-spacing: -0.025em;
      font-weight: 700;
    }
    h1 { font-size: clamp(2.6rem, 6vw, 5rem); font-weight: 700; letter-spacing: -0.04em; }
    h2 { font-size: clamp(2rem, 4vw, 3.4rem); letter-spacing: -0.035em; }
    h3 { font-size: 1.2rem; font-weight: 600; }
    h4 { font-size: 1.1rem; font-weight: 600; letter-spacing: -0.015em; }
    h5 { font-size: .85rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; }
    p { margin: 0 0 1em; color: var(--muted); }

    .serif-italic {
      font-family: var(--font-serif);
      font-weight: 400;
      font-style: italic;
      letter-spacing: -0.01em;
    }
    .gradient-text {
      background: var(--grad-alt);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      padding-right: 2px;
    }
    .container { width: 100%; max-width: 1240px; margin: 0 auto; padding: 0 24px; }
    section { padding: 120px 0; position: relative; }
    .hide-sm { display: inline; }
    ::selection { background: var(--blue-600); color: #fff; }

    /* Eyebrow */
    .eyebrow {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: .78rem; font-weight: 600;
      text-transform: uppercase; letter-spacing: .14em;
      color: var(--blue-700);
      background: #fff;
      border: 1px solid var(--blue-100);
      padding: 7px 14px;
      border-radius: 999px;
      margin-bottom: 20px;
      box-shadow: var(--shadow-xs);
    }
    .eyebrow .dot {
      width: 6px; height: 6px; border-radius: 50%;
      background: var(--blue-600);
      box-shadow: 0 0 0 3px var(--blue-100);
      animation: dot-pulse 2s ease-in-out infinite;
    }
    @keyframes dot-pulse {
      0%, 100% { box-shadow: 0 0 0 3px var(--blue-100); }
      50% { box-shadow: 0 0 0 6px var(--blue-100); }
    }
    .eyebrow.light { background: rgba(255,255,255,.08); color: #fff; border-color: rgba(255,255,255,.15); }
    .eyebrow.light .dot { background: #fff; box-shadow: 0 0 0 3px rgba(255,255,255,.2); }

    .section-head { max-width: 720px; margin-bottom: 64px; }
    .section-head.centered { margin-left: auto; margin-right: auto; text-align: center; }
    .section-head.narrow { max-width: 620px; }
    .section-sub { font-size: 1.15rem; color: var(--soft); line-height: 1.6; }

    /* Buttons */
    .btn {
      display: inline-flex; align-items: center; justify-content: center;
      gap: 8px; padding: 12px 22px; border-radius: 999px;
      font-weight: 600; font-size: .95rem; font-family: inherit;
      border: 1px solid transparent; cursor: pointer;
      transition: transform .2s ease, box-shadow .25s ease, background .25s ease, color .25s ease, border-color .25s ease;
      white-space: nowrap; position: relative;
    }
    .btn-lg { padding: 15px 28px; font-size: 1rem; }
    .btn-block { width: 100%; }
    .btn-primary {
      background: var(--grad); color: #fff;
      box-shadow: 0 10px 30px -10px rgba(37, 99, 235, .7), inset 0 1px 0 rgba(255,255,255,.2);
    }
    .btn-primary::after {
      content: ""; position: absolute; inset: 0; border-radius: inherit;
      background: linear-gradient(135deg, rgba(255,255,255,.35), transparent 40%);
      opacity: 0; transition: opacity .3s ease; pointer-events: none;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px -10px rgba(37,99,235,.65); }
    .btn-primary:hover::after { opacity: 1; }
    .btn-primary:active { transform: translateY(0); }
    .btn-ghost { background: #fff; color: var(--ink); border-color: var(--line); box-shadow: var(--shadow-xs); }
    .btn-ghost:hover { border-color: var(--ink); background: var(--ink); color: #fff; }
    .btn-light { background: #fff; color: var(--ink); }
    .btn-light:hover { transform: translateY(-2px); box-shadow: 0 12px 30px -10px rgba(0,0,0,.4); }

    /* Announcement */
    .announce { background: var(--ink); color: rgba(255,255,255,.9); font-size: .82rem; letter-spacing: .01em; }
    .announce-inner { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 10px 24px; }
    .announce a { color: var(--blue-300); font-weight: 600; }
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

    /* Navigation */
    .nav {
      position: sticky; top: 0; z-index: 100;
      background: rgba(255, 255, 255, .72);
      backdrop-filter: saturate(180%) blur(18px);
      -webkit-backdrop-filter: saturate(180%) blur(18px);
      border-bottom: 1px solid transparent;
      transition: border-color .3s ease, box-shadow .3s ease, background .3s ease;
    }
    .nav.scrolled {
      background: rgba(255, 255, 255, .88);
      border-bottom-color: var(--line);
      box-shadow: 0 4px 30px -12px rgba(11, 16, 32, .1);
    }
    .nav-inner { display: flex; align-items: center; justify-content: space-between; padding-top: 18px; padding-bottom: 18px; gap: 24px; }
    .logo { display: inline-flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.28rem; letter-spacing: -0.02em; color: var(--ink); }
    .logo-mark { display: inline-grid; place-items: center; transition: transform .4s ease; }
    .logo:hover .logo-mark { transform: rotate(-6deg) scale(1.05); }
    .logo-dot { color: var(--blue-600); }
    .nav-links { display: flex; gap: 32px; font-weight: 500; font-size: .95rem; }
    .nav-links a { color: var(--muted); position: relative; padding: 6px 0; transition: color .2s ease; }
    .nav-links a:hover { color: var(--ink); }
    .nav-links a::after {
      content: ""; position: absolute; left: 0; right: 0; bottom: -2px;
      height: 2px; background: var(--blue-600);
      transform: scaleX(0); transform-origin: left; transition: transform .3s ease;
    }
    .nav-links a:hover::after { transform: scaleX(1); }
    .nav-right { display: flex; align-items: center; gap: 14px; }
    .nav-phone { display: inline-flex; align-items: center; gap: 7px; color: var(--muted); font-size: .92rem; font-weight: 500; padding: 8px 0; transition: color .2s ease; }
    .nav-phone:hover { color: var(--blue-700); }
    .nav-phone svg { color: var(--blue-600); }
    .nav-toggle { display: none; background: transparent; border: 0; width: 44px; height: 44px; padding: 0; cursor: pointer; }
    .nav-toggle span { display: block; width: 22px; height: 2px; background: var(--ink); margin: 6px auto; border-radius: 2px; transition: .3s; }

    /* Hero */
    /* =========================================
       Hero — above-the-fold 2-column with form
       ========================================= */
    .hero {
      position: relative; overflow: hidden;
      background: var(--grad-soft);
      min-height: calc(100svh - 70px);
      display: flex; align-items: center;
      padding: 32px 0 40px;
    }
    .hero-bg { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
    .grid-overlay {
      position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(148,163,184,.13) 1px, transparent 1px),
        linear-gradient(90deg, rgba(148,163,184,.13) 1px, transparent 1px);
      background-size: 56px 56px;
      mask-image: radial-gradient(ellipse 70% 70% at 50% 40%, #000 20%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 70% 70% at 50% 40%, #000 20%, transparent 80%);
      animation: grid-drift 60s linear infinite;
    }
    @keyframes grid-drift {
      from { background-position: 0 0; }
      to   { background-position: 56px 56px; }
    }
    .spotlight {
      position: absolute; top: -200px; left: 50%; transform: translateX(-50%);
      width: 1200px; height: 800px;
      background: radial-gradient(ellipse at center, rgba(59,130,246,.22) 0%, transparent 55%);
      pointer-events: none;
    }
    .blob { position: absolute; border-radius: 50%; filter: blur(90px); opacity: .5; will-change: transform; }
    .blob-1 {
      width: 460px; height: 460px; background: var(--blue-300);
      top: -160px; right: -100px;
      animation: blob-float-a 14s ease-in-out infinite;
    }
    .blob-2 {
      width: 400px; height: 400px; background: var(--blue-200);
      bottom: -200px; left: -140px; opacity: .4;
      animation: blob-float-b 18s ease-in-out infinite;
    }
    @keyframes blob-float-a {
      0%, 100% { transform: translate(0, 0); }
      50%      { transform: translate(-30px, 30px); }
    }
    @keyframes blob-float-b {
      0%, 100% { transform: translate(0, 0); }
      50%      { transform: translate(40px, -20px); }
    }

    .hero-inner {
      position: relative; z-index: 1;
      display: grid; grid-template-columns: 1.22fr .98fr;
      gap: 56px; align-items: center;
      width: 100%;
    }

    /* Hero copy (left column) */
    .hero-copy { animation: hc-rise .7s ease both; }
    @keyframes hc-rise {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .hero-copy h1 {
      font-size: clamp(2rem, 4.4vw, 3.4rem);
      line-height: 1.04;
      letter-spacing: -0.035em;
      margin-bottom: 18px;
    }
    .hero-copy .lede {
      font-size: 1.05rem; color: var(--muted);
      max-width: 480px; margin: 0 0 26px;
      line-height: 1.55;
    }
    .hero-ctas { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 30px; }

    /* Stat tiles replacing avatars/stars */
    .hero-stats {
      display: grid; grid-template-columns: repeat(4, 1fr);
      gap: 12px; padding-top: 22px;
      border-top: 1px solid var(--line);
      max-width: 480px;
    }
    .hero-stat {
      display: flex; flex-direction: column; gap: 2px;
      transition: transform .25s ease;
    }
    .hero-stat:hover { transform: translateY(-2px); }
    .hero-stat strong {
      font-size: 1.4rem; font-weight: 800; color: var(--ink);
      letter-spacing: -0.025em; line-height: 1;
    }
    .hero-stat small {
      font-size: .72rem; color: var(--soft);
      text-transform: uppercase; letter-spacing: .08em;
      font-weight: 600;
    }

    /* =========================================
       Hero form card (right column)
       ========================================= */
    .hero-form {
      position: relative;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 22px;
      padding: 26px 26px 24px;
      box-shadow:
        0 30px 70px -28px rgba(11, 16, 32, .25),
        0 6px 18px -10px rgba(11, 16, 32, .08);
      display: grid; gap: 12px;
      animation: hf-rise .8s ease both .1s;
    }
    @keyframes hf-rise {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .hero-form::before {
      content: ""; position: absolute; inset: -1px;
      border-radius: inherit; pointer-events: none;
      padding: 1px;
      background: linear-gradient(135deg, rgba(96,165,250,.6), rgba(255,255,255,0) 40%, rgba(30,58,138,.5));
      -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
      -webkit-mask-composite: xor; mask-composite: exclude;
      opacity: .6;
    }
    .hf-glow {
      position: absolute; inset: -40px; z-index: -1;
      background: radial-gradient(ellipse at 30% 0%, rgba(96,165,250,.25), transparent 60%),
                  radial-gradient(ellipse at 100% 100%, rgba(30,58,138,.18), transparent 65%);
      filter: blur(20px);
      pointer-events: none;
    }

    .hf-head { display: flex; flex-direction: column; gap: 6px; margin-bottom: 4px; }
    .hf-head .wa-pill { align-self: flex-start; }
    .hf-head h3 {
      font-size: 1.3rem; font-weight: 700; margin: 0;
      letter-spacing: -0.02em; color: var(--ink);
    }
    .hf-head p { margin: 0; font-size: .85rem; color: var(--soft); }

    /* Compact field overrides scoped to .hero-form */
    .hero-form .field { gap: 4px; }
    .hero-form .field label { font-size: .74rem; font-weight: 600; color: var(--muted); letter-spacing: .005em; }
    .hero-form .field input,
    .hero-form .field select,
    .hero-form .field textarea {
      padding: 10px 12px; font-size: .9rem; border-radius: 9px; border-width: 1.5px;
    }
    .hero-form .field-row { gap: 10px; }
    .hero-form .field textarea { min-height: 64px; }
    .hero-form .consents { padding: 12px 14px; gap: 10px; border-radius: 10px; }
    .hero-form .consent { font-size: .72rem; line-height: 1.45; }
    .hero-form .consent .cbox { width: 16px; height: 16px; margin-top: 1px; }
    .hero-form .consent .cbox::after { width: 8px; height: 5px; }
    .hero-form .consent .req, .hero-form .consent .opt { font-size: .62rem; padding: 1px 6px; }
    .hero-form .btn-wa { padding: 12px 18px; font-size: .92rem; }
    .hero-form .form-note { font-size: .82rem; padding-top: 4px; }

    /* Floating trust badges around form */
    .hf-badge {
      position: absolute;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 9px 13px;
      box-shadow: 0 14px 32px -16px rgba(11, 16, 32, .25);
      display: flex; align-items: center; gap: 9px;
      font-size: .78rem;
      z-index: 3;
      animation: hf-badge-float 6s ease-in-out infinite;
    }
    .hf-badge-1 { top: -18px; left: -22px; animation-delay: 0s; }
    .hf-badge-2 { bottom: 24px; right: -22px; animation-delay: 1.5s; }
    @keyframes hf-badge-float {
      0%, 100% { transform: translateY(0); }
      50%      { transform: translateY(-6px); }
    }
    .hf-badge-icon {
      width: 28px; height: 28px; border-radius: 8px;
      display: grid; place-items: center; flex-shrink: 0;
      background: #dcfce7; color: #15803d;
    }
    .hf-badge-icon.alt { background: var(--blue-50); color: var(--blue-700); }
    .hf-badge small { display: block; font-size: .68rem; color: var(--soft); }
    .hf-badge strong { font-size: .82rem; color: var(--ink); font-weight: 700; }

    /* Dashboard mockup */
    .hero-visual { position: relative; display: grid; place-items: center; perspective: 1400px; }
    .dash {
      width: 100%; max-width: 520px;
      background: #fff; border: 1px solid var(--line); border-radius: 16px;
      box-shadow: var(--shadow-lg); overflow: hidden;
      transform: rotateY(-6deg) rotateX(4deg) rotateZ(-1deg);
      transition: transform .6s ease;
      animation: dash-float 7s ease-in-out infinite;
    }
    @keyframes dash-float {
      0%, 100% { transform: rotateY(-6deg) rotateX(4deg) rotateZ(-1deg) translateY(0); }
      50%      { transform: rotateY(-6deg) rotateX(4deg) rotateZ(-1deg) translateY(-8px); }
    }
    .hero-visual:hover .dash { transform: rotateY(-2deg) rotateX(2deg) rotateZ(0); }
    .dash-top { display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-bottom: 1px solid var(--line-2); background: var(--bg-soft); }
    .dash-dots { display: flex; gap: 6px; }
    .dash-dots i { width: 10px; height: 10px; border-radius: 50%; background: var(--line); display: block; }
    .dash-dots i:nth-child(1) { background: #ef4444; }
    .dash-dots i:nth-child(2) { background: #f59e0b; }
    .dash-dots i:nth-child(3) { background: #22c55e; }
    .dash-url { font-family: var(--font-mono); font-size: .74rem; color: var(--soft); margin-left: auto; }
    .dash-body { padding: 22px 22px 20px; }
    .dash-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
    .dash-head small { font-size: .75rem; color: var(--soft); text-transform: uppercase; letter-spacing: .1em; display: block; margin-bottom: 4px; }
    .dash-head strong { font-size: 1.6rem; color: var(--ink); letter-spacing: -0.02em; display: block; }
    .trend { font-size: .82rem; color: #10b981; font-weight: 600; }
    .pill {
      background: #fef2f2; color: #ef4444;
      font-size: .72rem; padding: 4px 10px; border-radius: 999px;
      font-weight: 600; display: inline-flex; align-items: center; gap: 6px;
    }
    .pill::before {
      content:""; width: 6px; height: 6px; background: #ef4444;
      border-radius: 50%; animation: pulse-red 2s infinite;
    }
    @keyframes pulse-red { 0%, 100% { opacity: 1; } 50% { opacity: .4; } }

    .dash-chart { height: 130px; margin: 0 -6px 18px; }
    .dash-chart svg { width: 100%; height: 100%; display: block; }
    .chart-line { stroke-dasharray: 1000; stroke-dashoffset: 1000; animation: draw 2.4s ease-out .4s forwards; }
    .chart-area { opacity: 0; animation: fade 1s ease-out 1.6s forwards; }
    @keyframes draw { to { stroke-dashoffset: 0; } }
    @keyframes fade { to { opacity: 1; } }

    .dash-kpis { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; padding-top: 16px; border-top: 1px dashed var(--line); }
    .kpi small { display: block; font-size: .7rem; color: var(--soft); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 4px; }
    .kpi strong { font-size: 1.1rem; color: var(--ink); display: block; margin-bottom: 6px; letter-spacing: -0.01em; }
    .kpi .bar { height: 5px; background: var(--bg-soft); border-radius: 5px; overflow: hidden; }
    .kpi .bar span { display: block; height: 100%; background: var(--grad); border-radius: 5px; animation: grow-w 1.8s ease-out 1s forwards; }
    .kpi:nth-child(2) .bar span { animation-delay: 1.2s; }
    .kpi:nth-child(3) .bar span { animation-delay: 1.4s; }
    @keyframes grow-w { from { width: 0; } }

    .badge-card {
      position: absolute; background: #fff;
      border: 1px solid var(--line); border-radius: 14px;
      padding: 12px 16px; box-shadow: var(--shadow);
      display: flex; align-items: center; gap: 12px;
      animation: float 6s ease-in-out infinite; z-index: 2;
    }
    .badge-card small { display: block; color: var(--soft); font-size: .72rem; }
    .badge-card strong { font-size: .92rem; color: var(--ink); }
    .badge-card-1 { top: 8%; left: -6%; }
    .badge-card-2 { bottom: 10%; right: -4%; animation-delay: 1.5s; }
    .bc-icon { width: 36px; height: 36px; border-radius: 10px; background: #dcfce7; color: #16a34a; display: grid; place-items: center; flex-shrink: 0; }
    .bc-icon.alt { background: var(--blue-50); color: var(--blue-700); }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    /* Marquee — slim strip outside the hero */
    .marquee {
      overflow: hidden;
      border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
      background: rgba(255,255,255,.6); padding: 18px 0;
      position: relative; z-index: 1;
      mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
      -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
    }
    .marquee-track {
      display: flex; gap: 40px; white-space: nowrap;
      animation: scroll 40s linear infinite;
      color: var(--ink); font-weight: 600; font-size: 1.05rem; letter-spacing: -0.01em;
      width: max-content;
    }
    .marquee-track span { flex-shrink: 0; }
    .dotsep { color: var(--blue-500); }
    @keyframes scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }

    /* Results */
    .results { background: #fff; padding-top: 100px; }
    .stat-grid {
      display: grid; grid-template-columns: repeat(4, 1fr); gap: 0;
      border: 1px solid var(--line); border-radius: var(--r-lg);
      overflow: hidden; background: #fff; box-shadow: var(--shadow-sm);
    }
    .stat-card { padding: 40px 32px; border-right: 1px solid var(--line); position: relative; overflow: hidden; transition: background .3s ease; }
    .stat-card:last-child { border-right: 0; }
    .stat-card::before { content: ""; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--grad); transform: scaleX(0); transform-origin: left; transition: transform .5s ease; }
    .stat-card:hover { background: var(--bg-tint); }
    .stat-card:hover::before { transform: scaleX(1); }
    .stat-num {
      display: inline-block; font-size: clamp(3rem, 6vw, 5rem); font-weight: 700;
      letter-spacing: -0.05em; line-height: 1;
      background: var(--grad-alt); -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .stat-unit { display: inline-block; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; color: var(--blue-700); letter-spacing: -0.03em; }
    .stat-card h4 { margin-top: 16px; font-size: 1.05rem; font-weight: 600; }
    .stat-card p { margin: 0; font-size: .92rem; color: var(--soft); }

    /* Services */
    .services { background: var(--bg-soft); border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
    /* Platform grid — always tiles evenly: 4×2 desktop, 2×4 tablet, 1×8 mobile */
    .service-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; }
    .service-card {
      background: #fff; border: 1px solid var(--line); border-radius: var(--r-lg);
      padding: 34px 30px 28px; position: relative; overflow: hidden;
      transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
      display: flex; flex-direction: column;
    }
    .service-card::before {
      content: ""; position: absolute; inset: 0;
      background: radial-gradient(600px circle at var(--mx, 50%) var(--my, 0%), rgba(59,130,246,.12), transparent 40%);
      opacity: 0; transition: opacity .4s ease; pointer-events: none;
    }
    .service-card:hover::before { opacity: 1; }
    .service-card:hover { transform: translateY(-6px); border-color: var(--blue-300); box-shadow: var(--shadow-lg); }
    .service-card.highlight { background: linear-gradient(180deg, #eff6ff 0%, #fff 60%); border-color: var(--blue-200); }
    .card-num { position: absolute; top: 26px; right: 30px; font-family: var(--font-mono); font-size: .75rem; color: var(--soft-2); letter-spacing: .1em; font-weight: 500; }
    .card-head { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
    .icon-wrap {
      width: 48px; height: 48px; border-radius: 12px;
      background: var(--blue-50); color: var(--blue-700);
      display: grid; place-items: center; flex-shrink: 0;
      transition: background .35s ease, color .35s ease, transform .4s ease;
    }
    .service-card:hover .icon-wrap { background: var(--ink); color: #fff; transform: rotate(-6deg) scale(1.05); }
    .service-card.highlight .icon-wrap { background: var(--grad); color: #fff; }
    .card-blurb { color: var(--soft); font-size: .95rem; margin-bottom: 20px; }
    .badge {
      display: inline-flex; font-size: .62rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .1em;
      padding: 3px 8px; background: var(--ink); color: #fff; border-radius: 999px;
      vertical-align: middle; margin-left: 8px;
    }
    .service-list { list-style: none; margin: 0 0 22px; padding: 0; display: grid; gap: 9px; flex: 1; }
    .service-list li { position: relative; padding-left: 22px; font-size: .92rem; color: var(--muted); transition: color .2s ease, transform .2s ease; }
    .service-list li::before {
      content: ""; position: absolute; left: 0; top: 9px;
      width: 12px; height: 2px; background: var(--blue-500); border-radius: 2px;
      transition: width .3s ease, background .3s ease;
    }
    .service-card:hover .service-list li::before { width: 16px; background: var(--blue-700); }
    .card-link {
      display: inline-flex; align-items: center; gap: 8px;
      font-weight: 600; font-size: .9rem; color: var(--blue-700);
      margin-top: auto; padding-top: 18px; border-top: 1px dashed var(--line);
      transition: color .2s ease, gap .25s ease;
    }
    .card-link:hover { color: var(--blue-900); gap: 12px; }

    /* Industries */
    .industries { background: #fff; padding-top: 120px; }
    /* Industry chips — 12 items always tile cleanly: 4×3 desktop, 3×4 tablet, 2×6 mobile */
    .industry-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; }
    .industry {
      background: #fff; border: 1px solid var(--line); border-radius: 14px;
      padding: 20px 22px; font-weight: 600; color: var(--ink);
      font-size: .98rem; transition: all .3s ease;
      position: relative; overflow: hidden;
    }
    .industry::before {
      content: "→"; position: absolute; right: 22px; top: 50%;
      transform: translateY(-50%) translateX(10px); opacity: 0;
      color: var(--blue-600); font-weight: 700; transition: all .3s ease;
    }
    .industry:hover { border-color: var(--blue-300); background: var(--blue-50); color: var(--blue-800); transform: translateY(-2px); }
    .industry:hover::before { opacity: 1; transform: translateY(-50%) translateX(0); }

    /* Process */
    .process { background: var(--bg-soft); border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
    .process-wrap { display: grid; grid-template-columns: 1fr 1.4fr; gap: 80px; align-items: start; }
    .process-intro { position: sticky; top: 120px; }
    .steps { list-style: none; margin: 0; padding: 0; display: grid; gap: 18px; counter-reset: step; }
    .step {
      display: flex; gap: 24px; padding: 28px 28px;
      background: #fff; border: 1px solid var(--line); border-radius: var(--r-md);
      transition: all .3s ease;
    }
    .step:hover { border-color: var(--blue-300); transform: translateX(6px); box-shadow: var(--shadow); }
    .step-num {
      font-family: var(--font-mono); font-size: 1rem; font-weight: 600;
      color: var(--blue-700); background: var(--blue-50); border: 1px solid var(--blue-100);
      padding: 6px 10px; border-radius: 8px; height: fit-content;
      letter-spacing: .05em; flex-shrink: 0;
    }
    .step h4 { margin-bottom: 6px; font-size: 1.2rem; }
    .step p { margin: 0; font-size: .95rem; }

    /* Testimonials */
    .testimonials { background: #fff; }
    .tgrid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
    .tcard {
      margin: 0; background: #fff; border: 1px solid var(--line); border-radius: var(--r-md);
      padding: 32px 28px; transition: all .3s ease; position: relative;
    }
    .tcard:hover { border-color: var(--blue-200); box-shadow: var(--shadow); transform: translateY(-4px); }
    .tcard .stars { color: #f59e0b; letter-spacing: 3px; margin-bottom: 16px; font-size: .95rem; }
    .tcard blockquote { margin: 0 0 22px; font-size: 1.02rem; color: var(--ink); line-height: 1.6; font-weight: 500; letter-spacing: -0.005em; }
    .tcard figcaption { display: flex; align-items: center; gap: 12px; padding-top: 18px; border-top: 1px solid var(--line); }
    .tcard .avatar { width: 40px; height: 40px; border-radius: 50%; color: #fff; display: grid; place-items: center; font-weight: 600; flex-shrink: 0; }
    .tcard strong { display: block; font-size: .92rem; color: var(--ink); font-weight: 600; }
    .tcard small { color: var(--soft); font-size: .82rem; }

    /* Contact */
    .contact { background: var(--bg-soft); padding: 120px 0; }
    .contact-card {
      background: var(--ink); color: #fff; border-radius: var(--r-lg);
      padding: 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 60px;
      box-shadow: var(--shadow-lg); position: relative; overflow: hidden;
    }
    .contact-bg { position: absolute; inset: 0; pointer-events: none; }
    .cb-blob {
      position: absolute; width: 600px; height: 600px; border-radius: 50%;
      background: radial-gradient(circle, rgba(59,130,246,.35) 0%, transparent 60%);
      top: -200px; right: -200px;
      animation: blob-drift 14s ease-in-out infinite;
    }
    @keyframes blob-drift { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-40px, 30px); } }
    .contact-left { position: relative; z-index: 1; }
    .contact-left h2 { color: #fff; font-size: clamp(2.2rem, 3.5vw, 3rem); margin-bottom: 18px; }
    .contact-left > p { color: rgba(255,255,255,.72); font-size: 1.05rem; max-width: 460px; line-height: 1.6; }
    .contact-details { margin-top: 36px; display: grid; gap: 12px; }
    .contact-line {
      display: flex; align-items: center; gap: 14px;
      padding: 16px 20px; border-radius: 14px;
      background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1);
      transition: all .3s ease;
    }
    .contact-line:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.25); transform: translateX(4px); }
    .contact-line .ic { width: 42px; height: 42px; border-radius: 11px; background: var(--grad); color: #fff; display: grid; place-items: center; flex-shrink: 0; }
    .contact-line small { display: block; font-size: .78rem; color: rgba(255,255,255,.6); margin-bottom: 2px; }
    .contact-line strong { font-size: 1rem; color: #fff; font-weight: 600; }
    .contact-line .arr { margin-left: auto; color: rgba(255,255,255,.4); font-size: 1.2rem; transition: transform .3s ease, color .3s ease; }
    .contact-line:hover .arr { color: #fff; transform: translateX(4px); }

    /* Form */
    .contact-form {
      background: #fff; color: var(--ink);
      padding: 36px; border-radius: var(--r-md);
      display: grid; gap: 14px; position: relative; z-index: 1;
      box-shadow: var(--shadow-lg);
    }
    .form-title { font-size: 1.4rem; font-weight: 700; margin-bottom: 4px; color: var(--ink); }
    .form-sub { margin: 0 0 10px; color: var(--soft); font-size: .92rem; }
    .field { display: grid; gap: 6px; }
    .field label { font-size: .82rem; font-weight: 600; color: var(--muted); }
    .field input, .field select, .field textarea {
      width: 100%; padding: 12px 14px;
      border: 1.5px solid var(--line); border-radius: 10px;
      font-family: inherit; font-size: .95rem; color: var(--ink); background: #fff;
      transition: border-color .2s ease, box-shadow .2s ease;
    }
    .field input:focus, .field select:focus, .field textarea:focus {
      outline: none; border-color: var(--blue-500); box-shadow: var(--ring-blue);
    }
    .field textarea { resize: vertical; min-height: 80px; }
    .form-note { margin: 0; color: var(--blue-700); font-weight: 600; font-size: .92rem; text-align: center; padding-top: 8px; }

    .wa-pill {
      display: inline-flex; align-items: center; gap: 7px;
      background: #dcfce7; color: #15803d;
      padding: 5px 12px; border-radius: 999px;
      font-size: .8rem; font-weight: 600;
    }

    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    @media (max-width: 480px) { .field-row { grid-template-columns: 1fr; } }

    .consents {
      display: grid; gap: 14px; margin-top: 4px;
      padding: 16px; background: var(--bg-soft);
      border: 1px solid var(--line); border-radius: 12px;
    }
    .consent { display: flex; gap: 10px; align-items: flex-start; cursor: pointer; font-size: .78rem; line-height: 1.5; color: var(--muted); }
    .consent input[type="checkbox"] { position: absolute; opacity: 0; pointer-events: none; width: 0; height: 0; }
    .consent .cbox {
      width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px;
      border: 1.5px solid var(--soft-2); border-radius: 5px;
      background: #fff; display: grid; place-items: center;
      position: relative; transition: all .2s ease;
    }
    .consent .cbox::after {
      content: ""; width: 10px; height: 6px;
      border-left: 2px solid #fff; border-bottom: 2px solid #fff;
      transform: rotate(-45deg) scale(0); margin-top: -2px;
      transition: transform .18s ease;
    }
    .consent input:checked + .cbox { background: var(--blue-600); border-color: var(--blue-600); }
    .consent input:checked + .cbox::after { transform: rotate(-45deg) scale(1); }
    .consent input:focus-visible + .cbox { box-shadow: var(--ring-blue); }
    .consent:hover .cbox { border-color: var(--blue-500); }
    .consent .cText strong { color: var(--ink); font-weight: 600; }
    .consent .req, .consent .opt {
      display: inline-block; font-style: normal;
      font-size: .7rem; font-weight: 700; letter-spacing: .04em;
      margin-left: 6px; padding: 2px 7px; border-radius: 999px; vertical-align: middle;
    }
    .consent .req { background: #fef2f2; color: #b91c1c; }
    .consent .opt { background: var(--blue-50); color: var(--blue-700); }

    .btn-wa {
      background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
      color: #fff;
      box-shadow: 0 10px 30px -10px rgba(18, 140, 126, .7), inset 0 1px 0 rgba(255,255,255,.2);
    }
    .btn-wa:hover { transform: translateY(-2px); box-shadow: 0 18px 40px -10px rgba(18, 140, 126, .65); }
    .btn-wa:disabled { opacity: .6; cursor: not-allowed; }

    /* Footer */
    .footer {
      background: var(--ink); color: rgba(255,255,255,.72);
      padding: 100px 0 28px; position: relative; overflow: hidden;
    }
    .footer::before {
      content: ""; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
      width: 1200px; height: 600px;
      background: radial-gradient(ellipse at center top, rgba(59,130,246,.2), transparent 60%);
      pointer-events: none;
    }
    .footer-cta { text-align: center; padding-bottom: 80px; position: relative; }
    .footer-cta h2 { color: #fff; font-size: clamp(2.4rem, 5vw, 4rem); margin-bottom: 28px; letter-spacing: -0.035em; }
    .footer .logo-text { color: #fff; }
    .footer .logo-dot { color: var(--blue-400); }
    .footer-inner {
      display: grid; grid-template-columns: 1.2fr 2fr; gap: 80px;
      padding: 56px 0;
      border-top: 1px solid rgba(255,255,255,.08); border-bottom: 1px solid rgba(255,255,255,.08);
      position: relative;
    }
    .footer-brand p { max-width: 320px; font-size: .95rem; color: rgba(255,255,255,.6); margin: 16px 0 20px; }
    .footer-phone {
      display: inline-block; color: #fff; font-weight: 600; font-size: 1.05rem;
      padding: 10px 16px; border: 1px solid rgba(255,255,255,.15); border-radius: 10px;
      transition: all .2s ease;
    }
    .footer-phone:hover { background: rgba(255,255,255,.08); border-color: var(--blue-400); }
    .footer-cols { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; }
    .footer-cols h5 { color: #fff; margin-bottom: 18px; }
    .footer-cols ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 10px; }
    .footer-cols a { font-size: .92rem; color: rgba(255,255,255,.6); transition: color .2s ease; }
    .footer-cols a:hover { color: #fff; }
    .footer-bottom {
      display: flex; justify-content: space-between; align-items: center;
      padding-top: 28px; color: rgba(255,255,255,.5); font-size: .85rem;
      flex-wrap: wrap; gap: 10px; position: relative;
    }
    .footer-links a { color: rgba(255,255,255,.65); }
    .footer-links a:hover { color: #fff; }
    .footer-links span { opacity: .4; margin: 0 8px; }

    /* Reveal */
    .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.in { opacity: 1; transform: translateY(0); }

    /* Global overflow guards */
    html, body { overflow-x: hidden; max-width: 100vw; }
    img, svg, video { max-width: 100%; height: auto; }

    /* =========================================
       Responsive — Mobile First Refinements
       ========================================= */

    /* Tablet landscape & down — 1080px */
    @media (max-width: 1080px) {
      section { padding: 100px 0; }
      .hero { min-height: 0; padding: 56px 0 64px; }
      .hero-inner { grid-template-columns: 1fr; gap: 40px; padding-top: 0; }
      .hero-form { order: 2; max-width: 540px; margin: 0 auto; width: 100%; }
      .hero-stats { max-width: 100%; }
      .hero-visual { order: -1; max-width: 520px; margin: 0 auto; width: 100%; }
      .badge-card-1 { left: -2%; }
      .badge-card-2 { right: -2%; }
      .process-wrap { grid-template-columns: 1fr; gap: 48px; }
      .process-intro { position: static; }
      .stat-grid { grid-template-columns: repeat(2, 1fr); }
      .stat-card:nth-child(2) { border-right: 0; }
      .stat-card:nth-child(1), .stat-card:nth-child(2) { border-bottom: 1px solid var(--line); }
      /* 8 cards → 2×4 instead of 3×3-2 */
      .service-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
      /* 12 chips → 3×4 */
      .industry-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
      .footer-inner { gap: 56px; }
      .contact-card { padding: 50px 44px; gap: 50px; }
    }

    /* Tablet portrait / large phone — 860px */
    @media (max-width: 860px) {
      section { padding: 80px 0; }
      .results { padding-top: 96px; }
      .industries { padding-top: 96px; }

      /* Announcement */
      .announce { font-size: .76rem; }
      .announce-inner { padding: 9px 14px; gap: 8px; }

      /* Nav — clean wrap-based mobile menu */
      .nav-inner { flex-wrap: wrap; padding: 14px 0; }
      .logo { order: 1; }
      .nav-toggle { order: 2; display: block; }
      .nav-links { order: 3; display: none; width: 100%; }
      .nav-right { order: 4; display: none; width: 100%; }

      .nav.open .nav-links {
        display: flex;
        flex-direction: column;
        gap: 14px;
        width: 100%;
        padding: 18px 0 6px;
        margin-top: 14px;
        border-top: 1px solid var(--line);
      }
      .nav.open .nav-links a { padding: 6px 0; font-size: 1rem; }
      .nav.open .nav-right {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
        width: 100%;
        padding: 6px 0 14px;
      }
      .nav.open .nav-phone {
        justify-content: center;
        padding: 12px 14px;
        border: 1px solid var(--line);
        border-radius: 10px;
      }
      .nav.open .nav-cta { width: 100%; text-align: center; justify-content: center; }

      /* Contact */
      .contact { padding: 80px 0; }
      .contact-card { grid-template-columns: 1fr; padding: 40px 32px; gap: 36px; border-radius: 22px; }
      .contact-left > p { max-width: none; }
      .contact-form { padding: 30px; }

      /* Footer */
      .footer { padding: 80px 0 24px; }
      .footer-cta { padding-bottom: 60px; }
      .footer-inner { grid-template-columns: 1fr; gap: 40px; padding: 44px 0; }
      .footer-cols { grid-template-columns: repeat(4, 1fr); gap: 24px; }

      .hide-sm { display: none; }
    }

    /* Phone — 640px */
    @media (max-width: 640px) {
      h1 { font-size: clamp(2rem, 8.2vw, 2.8rem); letter-spacing: -0.03em; }
      h2 { font-size: clamp(1.65rem, 6.5vw, 2.3rem); letter-spacing: -0.025em; }
      h3 { font-size: 1.1rem; }

      section { padding: 64px 0; }
      .results { padding-top: 80px; }
      .industries { padding-top: 72px; }

      .container { padding: 0 18px; }

      /* Hero */
      .hero { padding: 36px 0 36px; min-height: 0; }
      .hero-inner { gap: 28px; padding-top: 0; }
      .hero-copy .lede { font-size: 1rem; margin-bottom: 22px; max-width: none; }
      .hero-ctas { gap: 10px; margin-bottom: 24px; }
      .hero-ctas .btn { flex: 1 1 auto; min-width: 0; padding: 13px 18px; font-size: .92rem; }
      .hero-stats { grid-template-columns: repeat(4, 1fr); gap: 10px; padding-top: 18px; }
      .hero-stat strong { font-size: 1.15rem; }
      .hero-stat small { font-size: .65rem; }
      .hero-form { padding: 22px 20px 20px; border-radius: 18px; }
      .hf-head h3 { font-size: 1.15rem; }
      .hf-badge { display: none; }

      /* Dashboard — flatten on mobile */
      .dash {
        transform: none;
        animation: none;
        border-radius: 14px;
      }
      .hero-visual:hover .dash { transform: none; }
      .dash-top { padding: 12px 14px; }
      .dash-url { font-size: .68rem; }
      .dash-body { padding: 18px 16px; }
      .dash-head { margin-bottom: 16px; }
      .dash-head strong { font-size: 1.3rem; }
      .dash-head small { font-size: .68rem; }
      .trend { font-size: .76rem; }
      .dash-chart { height: 90px; margin-bottom: 14px; }
      .dash-kpis { gap: 10px; padding-top: 14px; }
      .kpi small { font-size: .62rem; }
      .kpi strong { font-size: .95rem; }

      .badge-card { padding: 9px 12px; gap: 9px; border-radius: 11px; }
      .badge-card small { font-size: .65rem; }
      .badge-card strong { font-size: .78rem; }
      .badge-card-1 { top: 2%; left: 2%; }
      .badge-card-2 { bottom: 2%; right: 2%; }
      .bc-icon { width: 28px; height: 28px; border-radius: 8px; }
      .bc-icon svg { width: 14px; height: 14px; }

      /* Marquee */
      .marquee { padding: 14px 0; }
      .marquee-track { font-size: .9rem; gap: 28px; }

      /* Headings */
      .section-head { margin-bottom: 40px; }
      .section-sub { font-size: .98rem; }
      .eyebrow { font-size: .72rem; padding: 6px 12px; }

      /* Stats */
      .stat-grid { grid-template-columns: 1fr; }
      .stat-card { padding: 32px 26px; border-right: 0; border-bottom: 1px solid var(--line); }
      .stat-card:last-child { border-bottom: 0; }
      .stat-num { font-size: clamp(2.8rem, 14vw, 3.8rem); }
      .stat-unit { font-size: clamp(1.8rem, 9vw, 2.4rem); }

      /* Services */
      .service-grid { grid-template-columns: 1fr; gap: 16px; }
      .service-card { padding: 28px 24px 24px; border-radius: 22px; }
      .card-num { top: 22px; right: 24px; }

      /* Industries */
      .industry-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
      .industry { padding: 16px 18px; font-size: .9rem; }
      .industry::before { right: 16px; }

      /* Process */
      .step { padding: 22px 20px; gap: 16px; }
      .step-num { font-size: .85rem; padding: 5px 9px; }
      .step h4 { font-size: 1.05rem; }
      .step p { font-size: .9rem; }

      /* Testimonials */
      .tgrid { gap: 16px; }
      .tcard { padding: 26px 22px; }
      .tcard blockquote { font-size: .96rem; }

      /* Contact */
      .contact { padding: 64px 0; }
      .contact-card { padding: 32px 22px; border-radius: 20px; }
      .contact-left h2 { font-size: 1.8rem; margin-bottom: 14px; }
      .contact-left > p { font-size: .96rem; }
      .contact-details { margin-top: 28px; }
      .contact-line { padding: 14px 16px; border-radius: 12px; }
      .contact-line .ic { width: 38px; height: 38px; border-radius: 9px; }
      .contact-line small { font-size: .72rem; }
      .contact-line strong { font-size: .94rem; }

      /* Form — font-size 16px prevents iOS zoom on focus */
      .contact-form { padding: 24px 20px; border-radius: 16px; }
      .form-title { font-size: 1.2rem; }
      .field input, .field select, .field textarea {
        padding: 12px;
        font-size: 16px;
        border-radius: 9px;
      }
      .field-row { grid-template-columns: 1fr; gap: 14px; }
      .consents { padding: 13px; gap: 12px; }
      .consent { font-size: .74rem; gap: 9px; }
      .consent .cbox { width: 17px; height: 17px; }
      .consent .req, .consent .opt { font-size: .62rem; padding: 2px 6px; }

      /* Footer */
      .footer { padding: 64px 0 24px; }
      .footer-cta { padding-bottom: 48px; }
      .footer-cta h2 { font-size: clamp(1.8rem, 7vw, 2.6rem); }
      .footer-inner { gap: 36px; padding: 36px 0; }
      .footer-cols { grid-template-columns: 1fr 1fr; gap: 24px; }
      .footer-bottom {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        text-align: left;
      }
      .footer-links { flex-wrap: wrap; }
    }

    /* Small phone — 420px */
    @media (max-width: 420px) {
      h1 { font-size: 1.9rem; }
      h2 { font-size: 1.5rem; }
      .container { padding: 0 16px; }

      /* Stack CTAs */
      .hero-ctas { flex-direction: column; align-items: stretch; }
      .hero-ctas .btn { width: 100%; }

      /* Single-column industries & footer */
      .industry-grid { grid-template-columns: 1fr; }
      .footer-cols { grid-template-columns: 1fr; gap: 28px; }

      /* Trim nav phone label to save space */
      .nav-phone span { font-size: .86rem; }
      .logo-text { font-size: 1.1rem; }

      /* Announcement — drop pulse on very narrow */
      .announce-inner { padding: 8px 12px; }

      /* Contact card even tighter */
      .contact-card { padding: 26px 18px; }
      .contact-left h2 { font-size: 1.6rem; }
      .contact-form { padding: 22px 16px; }

      /* Step wraps on ultra narrow */
      .step { flex-direction: column; gap: 12px; }
      .step-num { align-self: flex-start; }

      /* Dash head wrap */
      .dash-head { flex-direction: column; align-items: flex-start; gap: 8px; }
    }

    /* Extra tiny — 340px */
    @media (max-width: 340px) {
      h1 { font-size: 1.7rem; }
      .container { padding: 0 14px; }
      .nav-phone span { display: none; }
      .dash-kpis { grid-template-columns: 1fr; }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
      }
      .dash { transform: none; animation: none; }
    }
  </style>
@endpush

@section('content')

  @include('partials.header')

  <section class="hero" id="top">
    <div class="hero-bg" aria-hidden="true">
      <div class="grid-overlay"></div>
      <div class="spotlight"></div>
      <div class="blob blob-1"></div>
      <div class="blob blob-2"></div>
    </div>

    <div class="container hero-inner">
      <div class="hero-copy">
        <span class="eyebrow">
          <span class="dot"></span>
          <span>The growth operating system for ambitious businesses</span>
        </span>
        <h1>
          Run every system <br class="hide-sm"/>
          your business needs <span class="serif-italic">from</span> <span class="gradient-text">one platform.</span>
        </h1>
        <p class="lede">
          Websites, funnels, ads, SEO, automation, AI agents, and brand — built, deployed, and managed by Digirisers. One senior team, one operating system.
        </p>
        <div class="hero-ctas">
          <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">
            Explore the platform
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
          <a href="{{ url('/services') }}" class="btn btn-ghost btn-lg">View 57 services</a>
        </div>

        <div class="hero-stats" aria-label="Platform highlights">
          <div class="hero-stat"><strong>57</strong><small>services</small></div>
          <div class="hero-stat"><strong>4.9★</strong><small>rated</small></div>
          <div class="hero-stat"><strong>48 h</strong><small>kickoff</small></div>
          <div class="hero-stat"><strong>14 d</strong><small>guarantee</small></div>
        </div>
      </div>

      <aside class="hero-form" id="contact" aria-label="Start your growth plan">
        <span class="hf-glow" aria-hidden="true"></span>

        <div class="hf-head">
          <span class="wa-pill">
            <svg viewBox="0 0 32 32" width="13" height="13" fill="currentColor" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.4 1.7 6.3L3 29l6.9-1.8c1.8 1 3.9 1.5 6.1 1.5 7.2 0 13-5.8 13-13S23.2 3 16 3z"/></svg>
            WhatsApp · instant reply
          </span>
          <h3>Start your <span class="serif-italic">growth plan.</span></h3>
          <p>Tell us where you want to grow. A senior strategist replies — usually within 30 minutes.</p>
        </div>

        <form id="leadForm" novalidate>
          <div class="field">
            <label for="name">Your name</label>
            <input type="text" id="name" name="name" placeholder="Jane Doe" required />
          </div>
          <div class="field-row">
            <div class="field">
              <label for="email">Work email</label>
              <input type="email" id="email" name="email" placeholder="jane@company.com" required />
            </div>
            <div class="field">
              <label for="phone">Phone</label>
              <input type="tel" id="phone" name="phone" placeholder="+1 555 000 0000" required />
            </div>
          </div>
          <div class="field">
            <label for="service">Primary interest</label>
            <select id="service" name="service" required>
              <option value="">Select a service</option>
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
          <div class="field">
            <label for="message">What are you trying to grow?</label>
            <textarea id="message" name="message" rows="2" placeholder="A few words about your goals…"></textarea>
          </div>

          <div class="consents">
            <label class="consent">
              <input type="checkbox" id="consentTx" name="consentTx" required />
              <span class="cbox" aria-hidden="true"></span>
              <span class="cText">
                I agree to receive non-marketing texts from <strong>Digirisers</strong> about my request. Reply STOP to opt out.
                <em class="req">required</em>
              </span>
            </label>
            <label class="consent">
              <input type="checkbox" id="consentMk" name="consentMk" required />
              <span class="cbox" aria-hidden="true"></span>
              <span class="cText">
                I agree to receive marketing messages from <strong>Digirisers</strong> at the number provided. Reply STOP to opt out.
                <em class="req">required</em>
              </span>
            </label>
          </div>

          <button type="submit" class="btn btn-wa btn-lg btn-block">
            <svg viewBox="0 0 32 32" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.4 1.7 6.3L3 29l6.9-1.8c1.8 1 3.9 1.5 6.1 1.5 7.2 0 13-5.8 13-13S23.2 3 16 3z"/></svg>
            Send to WhatsApp
          </button>
          <p class="form-note" id="formNote" hidden>Opening WhatsApp — your message is ready to send.</p>
        </form>
      </aside>
    </div>
  </section>

  {{-- Marquee strip — moved out of hero so the hero stays compact above the fold --}}
  <div class="marquee" aria-hidden="true">
    <div class="marquee-track">
      <span>Websites</span><span class="dotsep">●</span>
      <span>Funnels</span><span class="dotsep">●</span>
      <span>SEO</span><span class="dotsep">●</span>
      <span>Google Ads</span><span class="dotsep">●</span>
      <span>Meta Ads</span><span class="dotsep">●</span>
      <span>TikTok Ads</span><span class="dotsep">●</span>
      <span>AI Agents</span><span class="dotsep">●</span>
      <span>GoHighLevel</span><span class="dotsep">●</span>
      <span>Zapier</span><span class="dotsep">●</span>
      <span>Email &amp; SMS</span><span class="dotsep">●</span>
      <span>Brand &amp; Video</span><span class="dotsep">●</span>
      <span>Hosting &amp; Security</span><span class="dotsep">●</span>
      <span>Websites</span><span class="dotsep">●</span>
      <span>Funnels</span><span class="dotsep">●</span>
      <span>SEO</span><span class="dotsep">●</span>
      <span>Google Ads</span><span class="dotsep">●</span>
      <span>Meta Ads</span><span class="dotsep">●</span>
      <span>TikTok Ads</span><span class="dotsep">●</span>
      <span>AI Agents</span><span class="dotsep">●</span>
      <span>GoHighLevel</span><span class="dotsep">●</span>
      <span>Zapier</span><span class="dotsep">●</span>
      <span>Email &amp; SMS</span><span class="dotsep">●</span>
      <span>Brand &amp; Video</span><span class="dotsep">●</span>
      <span>Hosting &amp; Security</span><span class="dotsep">●</span>
    </div>
  </div>

  <section class="results" id="results">
    <div class="container">
      <div class="section-head narrow">
        <span class="eyebrow"><span class="dot"></span> The Numbers</span>
        <h2>Momentum you can measure.</h2>
        <p class="section-sub">We don't sell reports — we sell outcomes. Here's what our model delivers across accounts.</p>
      </div>

      <div class="stat-grid">
        <div class="stat-card">
          <div class="stat-num" data-count="284">0</div>
          <div class="stat-unit">%</div>
          <h4>Average organic growth</h4>
          <p>Across SEO engagements in the first 12 months.</p>
        </div>
        <div class="stat-card">
          <div class="stat-num" data-count="6">0</div>
          <div class="stat-unit">.4×</div>
          <h4>Blended paid ROAS</h4>
          <p>Across Google, Meta, LinkedIn, and programmatic.</p>
        </div>
        <div class="stat-card">
          <div class="stat-num" data-count="41">0</div>
          <div class="stat-unit">%</div>
          <h4>Conversion lift</h4>
          <p>From CRO and landing-page rebuilds, on average.</p>
        </div>
        <div class="stat-card">
          <div class="stat-num" data-count="98">0</div>
          <div class="stat-unit">%</div>
          <h4>Client retention</h4>
          <p>Year-over-year. Partnership, not vendor churn.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="services" id="services">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow"><span class="dot"></span> The Platform</span>
        <h2>Every system. <span class="serif-italic">One platform.</span></h2>
        <p class="section-sub">Eight modules of the Digirisers platform. Use one. Use all eight. Each ships with transparent pricing and a senior team that owns the outcome.</p>
      </div>

      <div class="service-grid">

        @php
          $platformCats = collect(config('catalog.categories', []))->sortBy('order')->values();
          $platformIconMap = [
            'monitor'  => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="14" rx="2"/><line x1="8" y1="20" x2="16" y2="20"/><line x1="12" y1="18" x2="12" y2="20"/></svg>',
            'brain'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4a3 3 0 0 0-3 3v1a3 3 0 0 0-2 5 3 3 0 0 0 2 5 3 3 0 0 0 3 3 3 3 0 0 0 3-3V7a3 3 0 0 0-3-3z"/><path d="M15 4a3 3 0 0 1 3 3v1a3 3 0 0 1 2 5 3 3 0 0 1-2 5 3 3 0 0 1-3 3 3 3 0 0 1-3-3"/></svg>',
            'search'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>',
            'target'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
            'workflow' => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><path d="M6.5 10v4a3 3 0 0 0 3 3H14"/></svg>',
            'megaphone'=> '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-8v18l-18-8v-2z"/><path d="M11 13v6a2 2 0 0 0 4 0v-3"/></svg>',
            'shield'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'sparkle'  => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l2 5 5 2-5 2-2 5-2-5-5-2 5-2z"/></svg>',
          ];
          $cycleShort = ['project' => '', 'mo' => '/mo', 'week' => '/wk', 'per Zap' => '/zap', 'per script' => '/script', 'per asset' => '/asset'];
        @endphp

        @foreach ($platformCats as $i => $pc)
          @php
            $idx = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
            $minPrice = collect($pc['items'])->min('price');
            $featured = $i === 0 || $i === 1; // highlight first two visually
          @endphp
          <article class="service-card @if($featured) highlight @endif">
            <div class="card-num">{{ $idx }}</div>
            <div class="card-head">
              <div class="icon-wrap">{!! $platformIconMap[$pc['icon']] ?? $platformIconMap['sparkle'] !!}</div>
              <h3>{{ $pc['title'] }}</h3>
            </div>
            <p class="card-blurb">{{ $pc['blurb'] }}</p>
            <ul class="service-list">
              @foreach (array_slice($pc['items'], 0, 5) as $it)
                <li>{{ Str::limit($it['name'], 38) }}</li>
              @endforeach
            </ul>
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:6px;">
              <span style="font-size:.78rem; color:var(--soft); font-family:var(--font-mono);">From <strong style="color:var(--ink); font-weight:700;">${{ number_format($minPrice) }}</strong></span>
              <a class="card-link" href="{{ url('/services/'.$pc['id']) }}">Explore <span aria-hidden="true">→</span></a>
            </div>
          </article>
        @endforeach

      </div>
    </div>
  </section>

  <section class="industries" id="industries">
    <div class="container">
      <div class="section-head centered">
        <span class="eyebrow"><span class="dot"></span> Industries</span>
        <h2>Deep expertise across <span class="serif-italic">every vertical</span> we touch.</h2>
        <p class="section-sub">Generalist strategy, specialist playbooks. We've run programs in all of these.</p>
      </div>

      <div class="industry-grid">
        <div class="industry">SaaS &amp; Tech</div>
        <div class="industry">Ecommerce &amp; DTC</div>
        <div class="industry">Healthcare</div>
        <div class="industry">Finance &amp; Fintech</div>
        <div class="industry">Legal Services</div>
        <div class="industry">Real Estate</div>
        <div class="industry">Manufacturing</div>
        <div class="industry">Home Services</div>
        <div class="industry">Education</div>
        <div class="industry">Hospitality &amp; Travel</div>
        <div class="industry">Automotive</div>
        <div class="industry">B2B Services</div>
      </div>
    </div>
  </section>

  <section class="process" id="process">
    <div class="container">
      <div class="process-wrap">
        <div class="process-intro">
          <span class="eyebrow"><span class="dot"></span> How We Work</span>
          <h2>A process built for <span class="serif-italic">momentum.</span></h2>
          <p class="section-sub">Four steps, zero fluff — from first conversation to compounding growth.</p>
          <a href="#contact" class="btn btn-primary">Book a discovery call</a>
        </div>

        <ol class="steps">
          <li class="step">
            <div class="step-num">01</div>
            <div><h4>Discover</h4><p>We audit your channels, competitors, and funnel to surface the highest-leverage wins — before we quote a number.</p></div>
          </li>
          <li class="step">
            <div class="step-num">02</div>
            <div><h4>Strategize</h4><p>A custom roadmap tied to real revenue targets — quarterly priorities, not a 40-page deck that sits in Drive.</p></div>
          </li>
          <li class="step">
            <div class="step-num">03</div>
            <div><h4>Execute</h4><p>Senior specialists launch, iterate, and optimize across every channel in scope. No juniors running your account.</p></div>
          </li>
          <li class="step">
            <div class="step-num">04</div>
            <div><h4>Scale</h4><p>Double down on what's working, cut what isn't, and compound the results quarter over quarter.</p></div>
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="testimonials">
    <div class="container">
      <div class="section-head centered">
        <span class="eyebrow"><span class="dot"></span> What Clients Say</span>
        <h2>Partnerships that pay for themselves.</h2>
      </div>

      <div class="tgrid">
        <figure class="tcard">
          <div class="stars">★ ★ ★ ★ ★</div>
          <blockquote>"Digirisers rebuilt our entire funnel in 90 days. We 3×'d qualified demos and our CAC dropped by half. They operate like an in-house team — just better."</blockquote>
          <figcaption>
            <div class="avatar" style="background:linear-gradient(135deg,#3b82f6,#1e3a8a)">M</div>
            <div><strong>Maya Patel</strong><small>VP Marketing, SaaS platform</small></div>
          </figcaption>
        </figure>
        <figure class="tcard">
          <div class="stars">★ ★ ★ ★ ★</div>
          <blockquote>"We went from page 3 to ranking #1 on every keyword that matters. Organic now drives 62% of pipeline. Best marketing investment we've ever made."</blockquote>
          <figcaption>
            <div class="avatar" style="background:linear-gradient(135deg,#0f172a,#334155)">D</div>
            <div><strong>Daniel Ortiz</strong><small>Founder, B2B Services</small></div>
          </figcaption>
        </figure>
        <figure class="tcard">
          <div class="stars">★ ★ ★ ★ ★</div>
          <blockquote>"The attribution work alone was worth the retainer. For the first time we actually know which dollars are producing revenue — and we've scaled spend 4× with confidence."</blockquote>
          <figcaption>
            <div class="avatar" style="background:linear-gradient(135deg,#60a5fa,#2563eb)">J</div>
            <div><strong>Jordan Lee</strong><small>CMO, DTC Brand</small></div>
          </figcaption>
        </figure>
      </div>
    </div>
  </section>

  {{-- The lead form moved into the hero (above the fold). Anchors to "#contact" still resolve — the form aside in the hero now carries id="contact". --}}

  @include('partials.lead-popup')

  @include('partials.footer')

@endsection

@push('scripts')
  <script>
    // Reveal on scroll
    const revealTargets = document.querySelectorAll(
      '.service-card, .stat-card, .step, .tcard, .industry, .section-head, .footer-cta'
    );
    revealTargets.forEach(el => el.classList.add('reveal'));
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    revealTargets.forEach(el => io.observe(el));

    // Service-card cursor spotlight
    document.querySelectorAll('.service-card').forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;
        card.style.setProperty('--mx', x + '%');
        card.style.setProperty('--my', y + '%');
      });
    });

    // Count-up stats
    const counters = document.querySelectorAll('.stat-num[data-count]');
    const countIO = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = parseFloat(el.dataset.count);
        const duration = 1600;
        const start = performance.now();
        const isFloat = !Number.isInteger(target);
        const tick = (now) => {
          const progress = Math.min((now - start) / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
          const val = target * eased;
          el.textContent = isFloat ? val.toFixed(1) : Math.floor(val);
          if (progress < 1) requestAnimationFrame(tick);
          else el.textContent = isFloat ? target.toFixed(1) : target;
        };
        requestAnimationFrame(tick);
        countIO.unobserve(el);
      });
    }, { threshold: 0.4 });
    counters.forEach(el => countIO.observe(el));

    // Smooth scroll with sticky offset
    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', (e) => {
        const id = a.getAttribute('href');
        if (id.length < 2) return;
        const target = document.querySelector(id);
        if (!target) return;
        e.preventDefault();
        const y = target.getBoundingClientRect().top + window.scrollY - 80;
        window.scrollTo({ top: y, behavior: 'smooth' });
      });
    });

    // Contact form → Google Sheets + WhatsApp
    const WA_NUMBER  = '14019987807'; // +1 (401) 998-7807
    const LEAD_URL   = "{{ route('lead.submit') }}";
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const form     = document.getElementById('leadForm');
    const formNote = document.getElementById('formNote');

    async function syncLeadToSheet(payload) {
      try {
        const res = await fetch(LEAD_URL, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Accept':         'application/json',
            'X-CSRF-TOKEN':   CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: payload,
        });
        return res.ok;
      } catch (e) {
        console.warn('Lead sync failed', e);
        return false;
      }
    }

    form?.addEventListener('submit', async (e) => {
      e.preventDefault();

      const data = new FormData(form);
      const name    = (data.get('name')    || '').toString().trim();
      const email   = (data.get('email')   || '').toString().trim();
      const phone   = (data.get('phone')   || '').toString().trim();
      const service = (data.get('service') || '').toString().trim();
      const message = (data.get('message') || '').toString().trim();
      const consentTx = form.querySelector('#consentTx').checked;
      const consentMk = form.querySelector('#consentMk').checked;

      if (!name || !email || !phone || !service) {
        alert('Please fill in your name, email, phone, and primary interest.');
        return;
      }
      if (!consentTx) {
        alert('Please accept the non-marketing text message consent to continue.');
        form.querySelector('#consentTx').focus();
        return;
      }
      if (!consentMk) {
        alert('Please accept the marketing text message consent to continue.');
        form.querySelector('#consentMk').focus();
        return;
      }

      const btn = form.querySelector('button[type="submit"]');
      btn.disabled = true;
      const originalHTML = btn.innerHTML;
      btn.innerHTML = 'Sending…';

      // 1) Push to Google Sheets via Laravel proxy (non-blocking on failure).
      const sheetPayload = new FormData();
      sheetPayload.append('name',       name);
      sheetPayload.append('email',      email);
      sheetPayload.append('phone',      phone);
      sheetPayload.append('service',    service);
      sheetPayload.append('message',    message);
      sheetPayload.append('consent_tx', 'yes');
      sheetPayload.append('consent_mk', 'yes');
      sheetPayload.append('page',       window.location.pathname);
      await syncLeadToSheet(sheetPayload);

      // 2) Open WhatsApp pre-filled (existing behaviour).
      const lines = [
        '*New inquiry from Digirisers website*', '',
        `*Name:* ${name}`,
        `*Email:* ${email}`,
        `*Phone:* ${phone}`,
        `*Primary interest:* ${service}`,
      ];
      if (message) lines.push('', '*Goals / message:*', message);
      lines.push(
        '', '— Consents —',
        `Non-marketing texts (Digirisers): ${consentTx ? 'Yes' : 'No'}`,
        `Marketing / promotional texts (Digirisers): ${consentMk ? 'Yes' : 'No'}`,
        '', `Submitted: ${new Date().toLocaleString()}`
      );
      const url = `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(lines.join('\n'))}`;
      btn.innerHTML = 'Opening WhatsApp…';
      const win = window.open(url, '_blank');
      if (!win) window.location.href = url;

      formNote.hidden = false;
      setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = originalHTML;
        form.reset();
        setTimeout(() => { formNote.hidden = true; }, 6000);
      }, 1200);
    });
  </script>
@endpush
