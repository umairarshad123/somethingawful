@extends('admin.layout')

@section('title', 'Activity logs')

@section('content')
  <form method="GET" class="ad-filters">
    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search event / label / user" style="min-width:300px;">
    <select name="event">
      <option value="">All events</option>
      @foreach($events as $e)
        <option value="{{ $e }}" @selected(($filters['event'] ?? '') === $e)>{{ $e }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn-sm primary">Filter</button>
    <a href="{{ route('admin.activity-logs.index') }}" class="btn-sm ghost">Reset</a>
  </form>

  <div class="ad-card" style="padding: 0;">
    <div class="ad-table-wrap">
      <table class="ad-table">
        <thead><tr><th>When</th><th>Event</th><th>Label</th><th>User</th><th>Actor</th><th>IP</th></tr></thead>
        <tbody>
          @forelse($logs as $a)
            <tr>
              <td><small style="color:var(--soft);">{{ $a->created_at->format('M j H:i:s') }}</small></td>
              <td><span class="badge" style="background:#eff6ff; color:#1d4ed8;">{{ $a->event }}</span></td>
              <td>{{ $a->subject_label ?? '—' }}</td>
              <td>@if($a->user)<a href="{{ route('admin.users.show', $a->user) }}">{{ $a->user->email }}</a>@else<span style="color:var(--soft-2);">—</span>@endif</td>
              <td>{{ $a->actor?->email ?? 'system' }}</td>
              <td style="font-family:var(--font-mono); font-size:.78rem; color:var(--soft);">{{ $a->ip ?: '—' }}</td>
            </tr>
          @empty
            <tr><td colspan="6" style="text-align:center; padding:40px; color:var(--soft);">No activity recorded yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="ad-pager">{!! $logs->links() !!}</div>
@endsection
