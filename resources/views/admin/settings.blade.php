@extends('admin.layout')

@section('title', 'Settings')

@section('content')
  <div class="ad-card">
    <h3>Environment</h3>
    <div class="field" style="display:grid; grid-template-columns:200px 1fr; padding:10px 0; border-bottom:1px dashed var(--line);"><strong style="color:var(--soft); text-transform:uppercase; font-size:.78rem; letter-spacing:.06em;">App env</strong><span style="font-family:var(--font-mono);">{{ config('app.env') }}</span></div>
    <div class="field" style="display:grid; grid-template-columns:200px 1fr; padding:10px 0; border-bottom:1px dashed var(--line);"><strong style="color:var(--soft); text-transform:uppercase; font-size:.78rem; letter-spacing:.06em;">App URL</strong><span style="font-family:var(--font-mono);">{{ config('app.url') }}</span></div>
    <div class="field" style="display:grid; grid-template-columns:200px 1fr; padding:10px 0; border-bottom:1px dashed var(--line);"><strong style="color:var(--soft); text-transform:uppercase; font-size:.78rem; letter-spacing:.06em;">DB connection</strong><span style="font-family:var(--font-mono);">{{ config('database.default') }}</span></div>
    <div class="field" style="display:grid; grid-template-columns:200px 1fr; padding:10px 0; border-bottom:1px dashed var(--line);"><strong style="color:var(--soft); text-transform:uppercase; font-size:.78rem; letter-spacing:.06em;">Google OAuth</strong><span>{{ config('services.google.client_id') ? '✓ configured' : '✗ missing' }}</span></div>
    <div class="field" style="display:grid; grid-template-columns:200px 1fr; padding:10px 0;"><strong style="color:var(--soft); text-transform:uppercase; font-size:.78rem; letter-spacing:.06em;">GSheet lead URL</strong><span>{{ config('services.gsheet.lead_url') ? '✓ configured' : '✗ missing' }}</span></div>
  </div>

  <div class="ad-card" style="margin-top:18px;">
    <h3>How data flows</h3>
    <p style="font-size:.92rem; color:var(--muted); line-height:1.65;">
      Every form submission writes to the local database <strong>and</strong> mirrors to Google Sheets. If the Sheet is unreachable, the local record still persists — you'll never lose a lead. The activity log captures account creation, sign-ins, lead submissions, contact submissions, and pricing-page views; it's the source of truth for "what happened on the site recently."
    </p>
  </div>

  <div class="ad-card" style="margin-top:18px;">
    <h3>Admin housekeeping</h3>
    <p style="font-size:.92rem; color:var(--muted); line-height:1.65;">To create another admin user, set their <code>role</code> to <code>admin</code> in the Users section, or run <code>UPDATE users SET role = 'admin' WHERE email = ...</code> in your DB. To suspend an account, change its status to <code>suspended</code>.</p>
  </div>
@endsection
