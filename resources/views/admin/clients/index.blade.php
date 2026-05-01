@extends('admin.layout')

@section('title', 'Clients')

@section('content')
  @if(session('flash'))
    <div class="ad-card" style="margin-bottom:14px; background:#ecfeff; border-color:#67e8f9; color:#0e7490;">{{ session('flash') }}</div>
  @endif

  <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px; flex-wrap:wrap;">
    <form method="GET" class="ad-filters">
      <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search name / email / company" style="min-width:280px;">
      <select name="status">
        <option value="">All statuses</option>
        @foreach($statuses as $s)
          <option value="{{ $s }}" @selected(($filters['status'] ?? '') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-sm primary">Filter</button>
      <a href="{{ route('admin.clients.index') }}" class="btn-sm ghost">Reset</a>
    </form>
    <form method="POST" action="{{ route('admin.clients.backfill') }}" onsubmit="return confirm('Sync clients table from every paid order? Idempotent — safe to run multiple times.');">
      @csrf
      <button type="submit" class="btn-sm primary" title="Mirror every paid order into the clients table. Use after webhook downtime.">Sync from paid orders</button>
    </form>
  </div>

  @if($clients->isEmpty())
    <div class="ad-card" style="text-align:center; color:var(--soft);">
      <p style="margin:0 0 6px; color:var(--ink); font-weight:600;">No clients yet.</p>
      <p style="margin:0; font-size:.88rem;">A client is auto-created on every <strong>paid</strong> order. If you have paid orders that aren't here yet, click <strong>Sync from paid orders</strong> above.</p>
    </div>
  @else
    <div class="ad-card" style="padding: 0;">
      <div class="ad-table-wrap">
        <table class="ad-table">
          <thead>
            <tr><th>Name / Email</th><th>Service</th><th>Status</th><th>Start</th><th>Linked lead</th><th>Created</th><th></th></tr>
          </thead>
          <tbody>
            @foreach($clients as $c)
              <tr>
                <td><strong>{{ $c->name }}</strong><br><small style="color:var(--soft);">{{ $c->email }}</small></td>
                <td>{{ $c->service ?: '—' }}</td>
                <td><span class="badge b-{{ $c->status }}">{{ $c->status }}</span></td>
                <td>{{ $c->start_date?->format('M j, Y') ?? '—' }}</td>
                <td>@if($c->lead_id)<a href="{{ route('admin.leads.show', $c->lead_id) }}">#{{ $c->lead_id }}</a>@else— @endif</td>
                <td><small style="color:var(--soft);">{{ $c->created_at->format('M j, Y') }}</small></td>
                <td>
                  <details>
                    <summary style="cursor:pointer; color:var(--blue-700);">Edit</summary>
                    <form method="POST" action="{{ route('admin.clients.update', $c) }}" style="margin-top:8px;">
                      @csrf @method('PATCH')
                      <select name="status" style="padding:6px 10px; border:1px solid var(--line); border-radius:8px; font:inherit; font-size:.82rem;">
                        @foreach($statuses as $s)
                          <option value="{{ $s }}" @selected($c->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                      </select>
                      <button type="submit" class="btn-sm primary" style="margin-left:6px;">Save</button>
                    </form>
                  </details>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="ad-pager">{!! $clients->links() !!}</div>
  @endif
@endsection
