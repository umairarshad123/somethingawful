@extends('admin.layout')

@section('title', 'User · ' . $user->name)

@section('content')
  <p><a href="{{ route('admin.users.index') }}" style="color:var(--blue-700); font-size:.88rem;">← All users</a></p>

  <div class="ad-detail">
    <div class="ad-card">
      <div style="display:flex; align-items:center; gap:14px;">
        <span style="width:54px; height:54px; border-radius:50%; background:linear-gradient(135deg,#3b82f6,#1e3a8a); color:#fff; font-weight:700; font-size:1.1rem; display:grid; place-items:center;">{{ $user->initials }}</span>
        <div>
          <h2 style="margin:0;">{{ $user->name }}</h2>
          <p style="margin:4px 0 0; color:var(--soft);">{{ $user->email }}</p>
        </div>
        <div style="margin-left:auto;">
          <span class="badge {{ $user->role === 'admin' ? 'b-admin' : '' }}" style="{{ $user->role !== 'admin' ? 'background:#f1f5f9; color:var(--ink);' : '' }}">{{ $user->role }}</span>
          <span class="badge b-{{ $user->status }}">{{ $user->status }}</span>
        </div>
      </div>

      <hr style="margin: 18px 0; border: 0; border-top: 1px solid var(--line);">

      <div class="field"><strong>Phone</strong><span>{{ $user->phone ?: '—' }}</span></div>
      <div class="field"><strong>Company</strong><span>{{ $user->company ?: '—' }}</span></div>
      <div class="field"><strong>Created</strong><span>{{ $user->created_at->format('M j, Y · H:i') }}</span></div>
      <div class="field"><strong>Last login</strong><span>{{ $user->last_login_at?->format('M j, Y · H:i') ?? 'never' }}</span></div>
      <div class="field"><strong>Last login IP</strong><span style="font-family:var(--font-mono);">{{ $user->last_login_ip ?: '—' }}</span></div>
      <div class="field"><strong>Signup source</strong><span>{{ $user->signup_source ?: 'email' }}</span></div>
      <div class="field"><strong>Email verified</strong><span>{{ $user->email_verified_at?->format('M j, Y') ?? 'no' }}</span></div>
      <div class="field"><strong>Service views</strong><span>{{ $user->service_requests_count }}</span></div>
      <div class="field"><strong>Linked leads</strong><span>{{ $user->leads_count }}</span></div>
    </div>

    <div class="ad-card">
      <h3>Update user</h3>
      <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PATCH')
        <label style="display:block; font-size:.76rem; color:var(--soft); text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">Role</label>
        <select name="role" style="width:100%; padding:10px 12px; border:1px solid var(--line); border-radius:10px; font: inherit; margin-bottom: 14px;">
          <option value="customer" @selected($user->role === 'customer')>Customer</option>
          <option value="admin" @selected($user->role === 'admin')>Admin</option>
        </select>
        <label style="display:block; font-size:.76rem; color:var(--soft); text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">Status</label>
        <select name="status" style="width:100%; padding:10px 12px; border:1px solid var(--line); border-radius:10px; font: inherit; margin-bottom: 14px;">
          <option value="active" @selected($user->status === 'active')>Active</option>
          <option value="suspended" @selected($user->status === 'suspended')>Suspended</option>
        </select>
        <button type="submit" class="btn btn-primary" style="width:100%;">Save</button>
      </form>
    </div>
  </div>

  <div class="ad-card" style="margin-top:18px;">
    <h3>Recent service views ({{ $serviceRequests->count() }})</h3>
    @if($serviceRequests->isEmpty())
      <p style="color:var(--soft); font-size:.88rem;">No service interactions yet.</p>
    @else
      <table class="ad-table">
        <thead><tr><th>When</th><th>Service</th><th>Action</th><th>Logged in</th></tr></thead>
        <tbody>
          @foreach($serviceRequests as $sr)
            <tr>
              <td>{{ $sr->created_at->format('M j H:i') }}</td>
              <td>{{ $sr->service_name ?? $sr->slug }}</td>
              <td>{{ $sr->action }}</td>
              <td>{{ $sr->was_logged_in ? 'yes' : 'no' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  <div class="ad-card" style="margin-top:18px;">
    <h3>Linked leads</h3>
    @if($leads->isEmpty())
      <p style="color:var(--soft); font-size:.88rem;">No leads linked to this user.</p>
    @else
      <table class="ad-table">
        <thead><tr><th>When</th><th>Service</th><th>Source</th><th>Status</th><th></th></tr></thead>
        <tbody>
          @foreach($leads as $l)
            <tr>
              <td>{{ $l->created_at->format('M j H:i') }}</td>
              <td>{{ $l->service ?? '—' }}</td>
              <td>{{ $l->source }}</td>
              <td><span class="badge b-{{ $l->status }}">{{ $l->status }}</span></td>
              <td><a href="{{ route('admin.leads.show', $l) }}">Open →</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  <div class="ad-card" style="margin-top:18px;">
    <h3>Activity</h3>
    @if($activity->isEmpty())
      <p style="color:var(--soft); font-size:.88rem;">No activity yet.</p>
    @else
      <ul class="timeline">
        @foreach($activity as $a)
          <li><span class="dot"></span><div><div class="ev"><strong>{{ $a->event }}</strong> — {{ $a->subject_label }}</div><div class="meta">{{ $a->created_at->diffForHumans() }}</div></div></li>
        @endforeach
      </ul>
    @endif
  </div>
@endsection
