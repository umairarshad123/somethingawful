@extends('admin.layout')
@section('title', 'Orders')

@section('content')
  <form method="GET" class="ad-filters">
    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search order# / email / service / name" style="min-width:280px;">
    <select name="payment_status">
      <option value="">All payment statuses</option>
      @foreach (['pending','paid','failed','refunded','partially_refunded'] as $s)
        <option value="{{ $s }}" @selected(($filters['payment_status'] ?? '') === $s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
      @endforeach
    </select>
    <select name="billing_cycle">
      <option value="">All cycles</option>
      @foreach (['project','mo','week','per_zap','per_script','per_asset'] as $c)
        <option value="{{ $c }}" @selected(($filters['billing_cycle'] ?? '') === $c)>{{ $c }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn-sm primary">Filter</button>
    <a href="{{ route('admin.orders.index') }}" class="btn-sm ghost">Reset</a>
  </form>

  <div class="ad-card" style="padding: 0;">
    <div class="ad-table-wrap">
      <table class="ad-table">
        <thead>
          <tr>
            <th>Order</th><th>When</th><th>Customer</th><th>Service</th><th>Cycle</th><th>Amount</th><th>Payment</th><th>Order</th><th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $o)
            <tr>
              <td><strong style="font-family:var(--font-mono); font-size:.82rem;">{{ $o->order_number }}</strong></td>
              <td><small style="color:var(--soft);">{{ $o->created_at->format('M j, H:i') }}</small></td>
              <td><strong>{{ $o->first_name }} {{ $o->last_name }}</strong><br><small style="color:var(--soft);">{{ $o->email }}</small></td>
              <td>{{ $o->service_name }}</td>
              <td><span class="badge" style="background:#effae6; color:#3a8c12;">{{ $o->cycle_label }}</span></td>
              <td><strong>{{ $o->formatted_amount }}</strong></td>
              <td>
                @if($o->payment_status === 'paid')<span class="badge b-won">Paid</span>
                @elseif($o->payment_status === 'pending')<span class="badge b-new">Pending</span>
                @elseif($o->payment_status === 'failed')<span class="badge b-lost">Failed</span>
                @elseif($o->payment_status === 'refunded')<span class="badge" style="background:#fef3c7; color:#92400e;">Refunded</span>
                @else<span class="badge">{{ $o->payment_status }}</span>@endif
              </td>
              <td><span class="badge" style="background:#f1f5f9; color:var(--ink);">{{ $o->order_status }}</span></td>
              <td><a href="{{ route('admin.orders.show', $o) }}">Open →</a></td>
            </tr>
          @empty
            <tr><td colspan="9" style="text-align:center; padding:40px; color:var(--soft);">No orders yet. Once a customer pays via Stripe, the order lands here.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="ad-pager">{!! $orders->links() !!}</div>
@endsection
