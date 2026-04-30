@extends('admin.layout')

@section('title', request()->get('action') === 'clicked_pricing' ? 'Pricing requests' : 'Service requests')

@section('content')
  <div class="ad-stats" style="grid-template-columns: 1fr; padding: 0 0 14px;">
    <div class="ad-card">
      <h3>Top services this period</h3>
      @if($aggregated->isEmpty())
        <p style="color:var(--soft); font-size:.88rem;">No service requests recorded yet.</p>
      @else
        <div style="display:flex; flex-wrap:wrap; gap:8px;">
          @foreach($aggregated as $a)
            <a href="{{ route('admin.service-requests.index', ['q' => $a->slug]) }}" style="padding:7px 12px; background:#f1f5f9; border-radius:999px; font-size:.82rem; font-weight:600; color:var(--ink); text-decoration:none;">
              {{ $a->name }} <span style="color:var(--blue-700); font-family:var(--font-mono); margin-left:4px;">{{ $a->hits }}</span>
            </a>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  <form method="GET" class="ad-filters">
    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search slug / name / user email" style="min-width:280px;">
    <select name="action">
      <option value="">All actions</option>
      <option value="viewed" @selected(($filters['action'] ?? '') === 'viewed')>Viewed</option>
      <option value="clicked_pricing" @selected(($filters['action'] ?? '') === 'clicked_pricing')>Clicked pricing</option>
    </select>
    <select name="logged_in">
      <option value="">All users</option>
      <option value="yes" @selected(($filters['logged_in'] ?? '') === 'yes')>Logged in</option>
      <option value="no" @selected(($filters['logged_in'] ?? '') === 'no')>Guests</option>
    </select>
    <select name="follow_up_status">
      <option value="">Any follow-up</option>
      <option value="pending" @selected(($filters['follow_up_status'] ?? '') === 'pending')>Pending</option>
      <option value="contacted" @selected(($filters['follow_up_status'] ?? '') === 'contacted')>Contacted</option>
      <option value="done" @selected(($filters['follow_up_status'] ?? '') === 'done')>Done</option>
    </select>
    <button type="submit" class="btn-sm primary">Filter</button>
    <a href="{{ route('admin.service-requests.index') }}" class="btn-sm ghost">Reset</a>
  </form>

  <div class="ad-card" style="padding: 0;">
    <div class="ad-table-wrap">
      <table class="ad-table">
        <thead>
          <tr><th>When</th><th>Service</th><th>Action</th><th>User</th><th>Logged in</th><th>Signed up after</th><th>Follow-up</th></tr>
        </thead>
        <tbody>
          @forelse($requests as $r)
            <tr>
              <td><small style="color:var(--soft);">{{ $r->created_at->format('M j H:i') }}</small></td>
              <td><strong>{{ $r->service_name ?? $r->slug }}</strong><br><small style="color:var(--soft);">/shop/{{ $r->slug }}</small></td>
              <td><span class="badge" style="background:#eff6ff; color:#1d4ed8;">{{ $r->action }}</span></td>
              <td>@if($r->user)<a href="{{ route('admin.users.show', $r->user) }}">{{ $r->user->email }}</a>@else<span style="color:var(--soft-2);">—</span> @endif</td>
              <td>{{ $r->was_logged_in ? '✓' : '—' }}</td>
              <td>{{ $r->signed_up_after ? '✓' : '—' }}</td>
              <td><span class="badge" style="background:#f1f5f9; color:var(--ink);">{{ $r->follow_up_status }}</span></td>
            </tr>
          @empty
            <tr><td colspan="7" style="text-align:center; padding:40px; color:var(--soft);">No service requests match the filters.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="ad-pager">{!! $requests->links() !!}</div>
@endsection
