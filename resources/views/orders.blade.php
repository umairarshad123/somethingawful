@extends('layouts.app')

@section('title', 'Orders & Billing History — Digirisers')
@section('description', 'Your order and billing history.')
@section('robots', 'noindex,follow')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
  <style>
    body { background: #f5f8ff; }
    .od-shell { padding: 56px 0 80px; min-height: calc(100svh - 64px); }
    .od-wrap  { max-width: 1100px; margin: 0 auto; padding: 0 24px; }
    .od-head  { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 22px; }
    .od-head h1 { font-size: 1.6rem; margin: 0; letter-spacing: -0.02em; color: var(--ink); }
    .od-back { font-size: .88rem; color: var(--blue-700); font-weight: 600; text-decoration: none; }
    .od-back:hover { text-decoration: underline; }
    .od-card  {
      background: #fff; border: 1px solid var(--line); border-radius: 18px;
      padding: 20px 22px; margin-bottom: 12px;
      display: grid; grid-template-columns: 1fr auto; gap: 14px; align-items: center;
      box-shadow: 0 1px 2px rgba(11,16,32,.04);
    }
    .od-card h3 { font-size: 1rem; margin: 0 0 4px; color: var(--ink); letter-spacing: -0.01em; }
    .od-meta  { font-size: .82rem; color: var(--soft); display: flex; gap: 14px; flex-wrap: wrap; }
    .od-meta .od-num { font-family: 'JetBrains Mono', ui-monospace, monospace; font-weight: 500; color: var(--ink); }
    .od-amount { text-align: right; }
    .od-amount strong { display: block; font-size: 1.05rem; color: var(--ink); }
    .od-amount small { font-size: .78rem; color: var(--soft); }
    .od-pill {
      display: inline-block; padding: 3px 10px; border-radius: 999px;
      font-size: .68rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
    }
    .od-pill-paid    { background: #dcfce7; color: #166534; }
    .od-pill-pending { background: #fef9c3; color: #854d0e; }
    .od-pill-failed  { background: #fee2e2; color: #991b1b; }
    .od-pill-refund  { background: #e0e7ff; color: #3730a3; }
    .od-empty {
      text-align: center; padding: 60px 24px;
      background: #fff; border: 1px dashed var(--line); border-radius: 18px;
    }
    .od-empty h3 { font-size: 1.1rem; margin: 0 0 6px; color: var(--ink); }
    .od-empty p  { font-size: .92rem; color: var(--soft); margin: 0 0 16px; }
    .od-empty .btn-primary {
      display: inline-flex; align-items: center; padding: 10px 18px; border-radius: 10px;
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      color: #fff; font-weight: 600; font-size: .9rem; text-decoration: none;
    }
    .od-actions {
      display: flex; gap: 10px; flex-wrap: wrap;
      margin-top: 18px;
    }
    .od-action {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 9px 14px; border-radius: 999px;
      font-size: .85rem; font-weight: 600;
      background: #fff; border: 1px solid var(--line);
      color: var(--ink); text-decoration: none;
    }
    .od-action:hover { border-color: var(--ink); }
    .od-action.primary {
      background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
      color: #fff; border-color: transparent;
    }
    @media (max-width: 600px) {
      .od-card { grid-template-columns: 1fr; }
      .od-amount { text-align: left; }
    }
  </style>
@endpush

@section('content')
  @include('partials.header')

  <div class="od-shell">
    <div class="od-wrap">
      <div class="od-head">
        <h1>Orders &amp; billing history</h1>
        <a href="{{ route('dashboard') }}" class="od-back">← Back to dashboard</a>
      </div>

      @if (session('flash'))
        <div class="od-card" style="grid-template-columns: 1fr; background: #ecfeff; border-color: #67e8f9; color: #0e7490;">
          {{ session('flash') }}
        </div>
      @endif

      @forelse ($orders as $order)
        <div class="od-card">
          <div>
            <h3>{{ $order->service_name }}</h3>
            <div class="od-meta">
              <span class="od-num">{{ $order->order_number }}</span>
              <span>{{ $order->created_at?->format('M j, Y g:i a') }}</span>
              <span>{{ $order->cycle_label }}</span>
              @php
                $cls = match ($order->payment_status) {
                  'paid'              => 'od-pill-paid',
                  'pending'           => 'od-pill-pending',
                  'failed'            => 'od-pill-failed',
                  'refunded',
                  'partially_refunded'=> 'od-pill-refund',
                  default             => 'od-pill-pending',
                };
              @endphp
              <span class="od-pill {{ $cls }}">{{ str_replace('_', ' ', $order->payment_status) }}</span>
            </div>
          </div>
          <div class="od-amount">
            <strong>{{ $order->formatted_amount }}</strong>
            <small>{{ strtoupper($order->currency) }}</small>
          </div>
        </div>
      @empty
        <div class="od-empty">
          <h3>No orders yet.</h3>
          <p>Once you place an order, it'll show up here with full payment history.</p>
          <a href="{{ url('/shop') }}" class="btn-primary">Visit the shop</a>
        </div>
      @endforelse

      <div class="od-actions">
        <a href="{{ route('billing.portal') }}" class="od-action primary">Manage billing in Stripe →</a>
        <a href="{{ url('/shop') }}" class="od-action">Browse shop</a>
        <a href="{{ route('contact') }}" class="od-action">Contact support</a>
      </div>
    </div>
  </div>

  @include('partials.footer')
@endsection
