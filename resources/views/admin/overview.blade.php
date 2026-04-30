@extends('admin.layout')

@section('title', 'Overview')

@section('content')
  <div class="ad-stats">
    <div class="ad-stat"><div class="label">Total leads</div><div class="num">{{ number_format($stats['leads_total']) }}</div><div class="delta">{{ $stats['leads_new'] }} new · {{ $stats['leads_today'] }} today</div></div>
    <div class="ad-stat"><div class="label">Accounts</div><div class="num">{{ number_format($stats['users_total']) }}</div><div class="delta {{ $stats['users_today'] ? 'up' : 'flat' }}">+{{ $stats['users_today'] }} today</div></div>
    <div class="ad-stat"><div class="label">Service requests</div><div class="num">{{ number_format($stats['service_requests']) }}</div><div class="delta">all-time</div></div>
    <div class="ad-stat"><div class="label">Contact submissions</div><div class="num">{{ number_format($stats['contact_subs']) }}</div><div class="delta">via /contact</div></div>
    <div class="ad-stat"><div class="label">Active clients</div><div class="num">{{ number_format($stats['clients_active']) }}</div><div class="delta">onboarding + active</div></div>
    <div class="ad-stat"><div class="label">New status</div><div class="num">{{ number_format($stats['leads_new']) }}</div><div class="delta">unassigned leads</div></div>
    <div class="ad-stat"><div class="label">Today (leads)</div><div class="num">{{ number_format($stats['leads_today']) }}</div><div class="delta">since midnight</div></div>
    <div class="ad-stat"><div class="label">Today (signups)</div><div class="num">{{ number_format($stats['users_today']) }}</div><div class="delta">since midnight</div></div>
  </div>

  <div style="display:grid; grid-template-columns: 1.4fr 1fr; gap: 18px; margin-bottom: 24px;">
    <div class="ad-card">
      <h3>Most-requested services</h3>
      @if($topServices->isEmpty())
        <p style="color:var(--soft); font-size:.9rem;">No service requests yet. Once visitors view a service detail page, you'll see them here.</p>
      @else
        <div class="ad-table-wrap">
          <table class="ad-table">
            <thead><tr><th>Service</th><th style="text-align:right;">Hits</th><th></th></tr></thead>
            <tbody>
              @foreach($topServices as $s)
                <tr>
                  <td><strong>{{ $s->name }}</strong><br><small style="color:var(--soft);">/shop/{{ $s->slug }}</small></td>
                  <td style="text-align:right;"><strong>{{ $s->hits }}</strong></td>
                  <td><a href="{{ route('admin.service-requests.index', ['q' => $s->slug]) }}">Drill in →</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <div class="ad-card">
      <h3>Recent leads</h3>
      @if($recentLeads->isEmpty())
        <p style="color:var(--soft); font-size:.9rem;">No leads yet.</p>
      @else
        <ul class="timeline">
          @foreach($recentLeads as $l)
            <li>
              <span class="dot" style="background: {{ ['new'=>'#3b82f6','contacted'=>'#d97706','qualified'=>'#7c3aed','proposal'=>'#ea580c','won'=>'#16a34a','lost'=>'#b91c1c'][$l->status] ?? '#3b82f6' }};"></span>
              <div>
                <div class="ev"><a href="{{ route('admin.leads.show', $l) }}">{{ $l->name }}</a> <span class="badge b-{{ $l->status }}">{{ $l->status }}</span></div>
                <div class="meta">{{ $l->email }} · {{ $l->service ?? '—' }} · {{ $l->created_at->diffForHumans() }}</div>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>

  <div class="ad-card">
    <h3>Recent activity</h3>
    @if($recentActivity->isEmpty())
      <p style="color:var(--soft); font-size:.9rem;">No activity recorded yet.</p>
    @else
      <ul class="timeline">
        @foreach($recentActivity as $a)
          <li>
            <span class="dot"></span>
            <div>
              <div class="ev"><strong>{{ $a->event }}</strong> — {{ $a->subject_label ?? '—' }}</div>
              <div class="meta">{{ $a->user?->email ?? 'guest' }} · {{ $a->created_at->diffForHumans() }}</div>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
@endsection
