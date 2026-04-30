@extends('admin.layout')

@section('title', 'Users')

@section('content')
  <form method="GET" class="ad-filters">
    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search name / email / company" style="min-width:280px;">
    <select name="role">
      <option value="">All roles</option>
      <option value="admin" @selected(($filters['role'] ?? '') === 'admin')>Admin</option>
      <option value="customer" @selected(($filters['role'] ?? '') === 'customer')>Customer</option>
    </select>
    <select name="status">
      <option value="">All statuses</option>
      <option value="active" @selected(($filters['status'] ?? '') === 'active')>Active</option>
      <option value="suspended" @selected(($filters['status'] ?? '') === 'suspended')>Suspended</option>
    </select>
    <button type="submit" class="btn-sm primary">Filter</button>
    <a href="{{ route('admin.users.index') }}" class="btn-sm ghost">Reset</a>
  </form>

  <div class="ad-card" style="padding: 0;">
    <div class="ad-table-wrap">
      <table class="ad-table">
        <thead>
          <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Source</th><th>Last login</th><th>Service views</th><th>Joined</th><th></th></tr>
        </thead>
        <tbody>
          @forelse($users as $u)
            <tr>
              <td><strong>{{ $u->name }}</strong>@if($u->company)<br><small style="color:var(--soft);">{{ $u->company }}</small>@endif</td>
              <td>{{ $u->email }}</td>
              <td><span class="badge {{ $u->role === 'admin' ? 'b-admin' : '' }}" style="{{ $u->role !== 'admin' ? 'background:#f1f5f9; color:var(--ink);' : '' }}">{{ $u->role }}</span></td>
              <td><span class="badge b-{{ $u->status }}" style="{{ $u->status === 'active' ? '' : '' }}">{{ $u->status }}</span></td>
              <td>{{ $u->signup_source ?: 'email' }}</td>
              <td><small style="color:var(--soft);">{{ $u->last_login_at?->diffForHumans() ?? 'never' }}</small></td>
              <td>{{ $u->service_requests_count }}</td>
              <td><small style="color:var(--soft);">{{ $u->created_at->format('M j, Y') }}</small></td>
              <td><a href="{{ route('admin.users.show', $u) }}">Open →</a></td>
            </tr>
          @empty
            <tr><td colspan="9" style="text-align:center; padding:40px; color:var(--soft);">No users match the filters.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="ad-pager">{!! $users->links() !!}</div>
@endsection
