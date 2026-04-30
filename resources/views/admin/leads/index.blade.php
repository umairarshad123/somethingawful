@extends('admin.layout')

@section('title', request()->get('source') === 'contact' ? 'Contact submissions' : 'Leads')

@section('content')
  <form method="GET" class="ad-filters">
    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search name / email / phone / message" style="min-width:280px;">
    <select name="status">
      <option value="">All statuses</option>
      @foreach($statuses as $s)
        <option value="{{ $s }}" @selected(($filters['status'] ?? '') === $s)>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
    <select name="source">
      <option value="">All sources</option>
      @foreach($sources as $key => $label)
        <option value="{{ $key }}" @selected(($filters['source'] ?? '') === $key)>{{ $label }}</option>
      @endforeach
    </select>
    <input type="text" name="service" value="{{ $filters['service'] ?? '' }}" placeholder="Service contains…">
    <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" title="From">
    <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" title="To">
    <button type="submit" class="btn-sm primary">Filter</button>
    <a href="{{ route('admin.leads.index') }}" class="btn-sm ghost">Reset</a>
    <a href="{{ route('admin.leads.export', request()->query()) }}" class="btn-sm ghost" style="margin-left:auto;">Export CSV</a>
  </form>

  <div class="ad-card" style="padding: 0;">
    <div class="ad-table-wrap">
      <table class="ad-table">
        <thead>
          <tr>
            <th>When</th><th>Name / Email</th><th>Phone</th><th>Service</th><th>Source</th><th>Status</th><th>Last activity</th><th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($leads as $l)
            <tr>
              <td><small style="color:var(--soft);">{{ $l->created_at->format('M j, H:i') }}</small></td>
              <td><strong>{{ $l->name }}</strong><br><small style="color:var(--soft);">{{ $l->email }}</small></td>
              <td>{{ $l->phone ?: '—' }}</td>
              <td>{{ $l->service ?: '—' }}</td>
              <td><span class="badge" style="background:#f1f5f9; color:var(--ink);">{{ \App\Models\Lead::SOURCES[$l->source] ?? $l->source }}</span></td>
              <td><span class="badge b-{{ $l->status }}">{{ $l->status }}</span></td>
              <td><small style="color:var(--soft);">{{ $l->last_activity_at?->diffForHumans() ?? '—' }}</small></td>
              <td><a href="{{ route('admin.leads.show', $l) }}">Open →</a></td>
            </tr>
          @empty
            <tr><td colspan="8" style="text-align:center; padding: 40px; color: var(--soft);">No leads match the filters.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="ad-pager">{!! $leads->links() !!}</div>
@endsection
