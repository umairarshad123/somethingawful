@extends('admin.layout')
@section('title', 'Order · ' . $order->order_number)

@section('content')
  <p><a href="{{ route('admin.orders.index') }}" style="color:var(--blue-700); font-size:.88rem;">← All orders</a></p>

  <div class="ad-detail">
    <div class="ad-card">
      <div style="display:flex; justify-content:space-between; align-items:start; gap:14px; margin-bottom:6px;">
        <div>
          <h2 style="margin:0; font-family:var(--font-mono); font-size:1.1rem;">{{ $order->order_number }}</h2>
          <p style="margin:6px 0 0; color:var(--soft); font-size:.92rem;">{{ $order->service_name }} · {{ $order->cycle_label }}</p>
        </div>
        <div style="text-align:right;">
          <strong style="font-size:1.6rem; color:#3a8c12; letter-spacing:-0.02em;">{{ $order->formatted_amount }}</strong>
          <div>
            @if($order->payment_status === 'paid')<span class="badge b-won">Paid</span>
            @elseif($order->payment_status === 'pending')<span class="badge b-new">Pending</span>
            @elseif($order->payment_status === 'failed')<span class="badge b-lost">Failed</span>
            @elseif($order->payment_status === 'refunded')<span class="badge" style="background:#fef3c7; color:#92400e;">Refunded</span>
            @endif
          </div>
        </div>
      </div>

      <hr style="margin:18px 0; border:0; border-top:1px solid var(--line);">

      <div class="field"><strong>Customer</strong><span>{{ $order->first_name }} {{ $order->last_name }}</span></div>
      <div class="field"><strong>Email</strong><span>{{ $order->email }}</span></div>
      <div class="field"><strong>Phone</strong><span>{{ $order->phone ?: '—' }}</span></div>
      <div class="field"><strong>Company</strong><span>{{ $order->company ?: '—' }}</span></div>
      <div class="field"><strong>Website</strong><span>{{ $order->website ?: '—' }}</span></div>
      <div class="field"><strong>Created</strong><span>{{ $order->created_at->format('M j, Y · H:i') }}</span></div>
      <div class="field"><strong>Paid at</strong><span>{{ $order->paid_at?->format('M j, Y · H:i') ?: '—' }}</span></div>
      <div class="field"><strong>Order status</strong><span>{{ $order->order_status }}</span></div>
      <div class="field"><strong>Linked client</strong><span>@if($order->client)<a href="{{ route('admin.clients.index', ['q' => $order->client->email]) }}">#{{ $order->client->id }} · {{ $order->client->email }}</a>@else— not yet @endif</span></div>
      <div class="field"><strong>Linked user</strong><span>@if($order->user)<a href="{{ route('admin.users.show', $order->user) }}">{{ $order->user->email }}</a>@else— guest @endif</span></div>

      @if($order->notes)
        <div style="margin-top: 14px;">
          <strong style="display:block; font-size:.78rem; color:var(--soft); text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">Customer notes</strong>
          <div style="padding:14px; background:#fafafa; border:1px solid var(--line); border-radius:10px; font-size:.92rem; line-height:1.55; white-space:pre-wrap;">{{ $order->notes }}</div>
        </div>
      @endif
    </div>

    <div class="ad-card">
      <h3>Stripe</h3>
      <div class="field" style="font-family:var(--font-mono); font-size:.78rem;">
        <strong>Session</strong><span style="word-break:break-all;">{{ $order->stripe_session_id ?: '—' }}</span>
      </div>
      <div class="field" style="font-family:var(--font-mono); font-size:.78rem;">
        <strong>Customer</strong><span style="word-break:break-all;">{{ $order->stripe_customer_id ?: '—' }}</span>
      </div>
      <div class="field" style="font-family:var(--font-mono); font-size:.78rem;">
        <strong>Payment intent</strong><span style="word-break:break-all;">{{ $order->stripe_payment_intent_id ?: '—' }}</span>
      </div>
      <div class="field" style="font-family:var(--font-mono); font-size:.78rem;">
        <strong>Subscription</strong><span style="word-break:break-all;">{{ $order->stripe_subscription_id ?: '—' }}</span>
      </div>

      @if($order->payment_status === 'paid' && ! $order->isRecurring() && $order->stripe_payment_intent_id)
        <hr style="margin:18px 0; border:0; border-top:1px solid var(--line);">
        @if ($errors->any())
          <div class="ad-flash" style="background:#fef2f2; color:#b91c1c; border-color:#fecaca;">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.orders.refund', $order) }}" onsubmit="return confirm('Refund this order in full? This cannot be undone.');">
          @csrf
          <button type="submit" class="btn" style="background:#dc2626; color:#fff; padding: 11px 16px; font-weight:600; border-radius:10px; border:0; cursor:pointer; font:inherit;">Refund full amount</button>
          <p style="font-size:.78rem; color:var(--soft); margin:10px 0 0;">Issues a Stripe refund. The order is marked refunded automatically.</p>
        </form>
      @elseif($order->isRecurring())
        <p style="font-size:.85rem; color:var(--soft); margin-top:14px;">Subscriptions are managed via the Stripe Customer Portal — admins can cancel from the Stripe dashboard.</p>
      @endif
    </div>
  </div>
@endsection
