@extends('admin.layout')

@section('title', 'Lead · ' . $lead->name)

@section('content')
  <p><a href="{{ route('admin.leads.index') }}" style="color:var(--blue-700); font-size:.88rem;">← All leads</a></p>

  <div class="ad-detail">
    <div class="ad-card">
      <div style="display:flex; justify-content:space-between; align-items:start; gap:14px;">
        <div>
          <h2 style="margin:0;">{{ $lead->name }}</h2>
          <p style="margin: 6px 0 0; color: var(--soft);">{{ $lead->email }} · {{ $lead->phone ?? '—' }}</p>
        </div>
        <span class="badge b-{{ $lead->status }}">{{ $lead->status }}</span>
      </div>

      <hr style="margin: 18px 0; border: 0; border-top: 1px solid var(--line);">

      <div class="field"><strong>Service</strong><span>{{ $lead->service ?: '—' }}</span></div>
      <div class="field"><strong>Source</strong><span>{{ \App\Models\Lead::SOURCES[$lead->source] ?? $lead->source }}</span></div>
      <div class="field"><strong>Page</strong><span>{{ $lead->page ?: '—' }}</span></div>
      <div class="field"><strong>Submitted</strong><span>{{ $lead->created_at->format('M j, Y · H:i') }}</span></div>
      <div class="field"><strong>Last activity</strong><span>{{ $lead->last_activity_at?->format('M j, Y · H:i') ?? '—' }}</span></div>
      <div class="field"><strong>Linked user</strong><span>@if($lead->user)<a href="{{ route('admin.users.show', $lead->user) }}">{{ $lead->user->email }}</a>@else— @endif</span></div>
      <div class="field"><strong>IP</strong><span style="font-family:var(--font-mono);">{{ $lead->ip ?: '—' }}</span></div>
      <div class="field"><strong>UA</strong><span style="font-family:var(--font-mono); font-size:.8rem; color:var(--soft);">{{ $lead->user_agent ?: '—' }}</span></div>

      <div style="margin-top: 18px;">
        <strong style="display:block; font-size:.78rem; color:var(--soft); text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">Message</strong>
        <div style="padding:14px; background:#fafafa; border:1px solid var(--line); border-radius:10px; font-size:.92rem; line-height:1.55;">{{ $lead->message ?: '—' }}</div>
      </div>
    </div>

    <div class="ad-card">
      <h3>Update lead</h3>
      <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
        @csrf @method('PATCH')
        <label style="display:block; font-size:.76rem; color:var(--soft); text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">Status</label>
        <select name="status" style="width:100%; padding:10px 12px; border:1px solid var(--line); border-radius:10px; font: inherit; margin-bottom: 14px;">
          @foreach($statuses as $s)
            <option value="{{ $s }}" @selected($lead->status === $s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>

        <label style="display:block; font-size:.76rem; color:var(--soft); text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">Assigned label</label>
        <input type="text" name="assigned_label" value="{{ $lead->assigned_label }}" placeholder="e.g. Sarah · Tier-1" style="width:100%; padding:10px 12px; border:1px solid var(--line); border-radius:10px; font: inherit; margin-bottom: 14px;">

        <label style="display:block; font-size:.76rem; color:var(--soft); text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">Internal notes</label>
        <textarea name="internal_notes" rows="6" style="width:100%; padding:10px 12px; border:1px solid var(--line); border-radius:10px; font: inherit; margin-bottom: 14px;">{{ $lead->internal_notes }}</textarea>

        <button type="submit" class="btn btn-primary" style="width:100%;">Save changes</button>
      </form>
      <p style="font-size:.78rem; color:var(--soft); margin-top:10px;">Marking <strong>Won</strong> will auto-create a client record.</p>
    </div>
  </div>

  <div class="ad-card" style="margin-top: 18px;">
    <h3>Activity for this lead</h3>
    @if($activity->isEmpty())
      <p style="color:var(--soft); font-size:.88rem;">No activity yet beyond submission.</p>
    @else
      <ul class="timeline">
        @foreach($activity as $a)
          <li>
            <span class="dot"></span>
            <div>
              <div class="ev"><strong>{{ $a->event }}</strong> — {{ $a->subject_label }}</div>
              <div class="meta">{{ $a->actor?->email ?? 'system' }} · {{ $a->created_at->format('M j · H:i') }}</div>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
@endsection
