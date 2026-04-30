<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'client_id',
        'stripe_subscription_id', 'stripe_customer_id', 'stripe_price_id',
        'service_slug', 'billing_cycle',
        'amount', 'currency',
        'status',
        'current_period_start', 'current_period_end',
        'cancel_at_period_end', 'canceled_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'current_period_start' => 'datetime',
            'current_period_end'   => 'datetime',
            'canceled_at'          => 'datetime',
            'cancel_at_period_end' => 'boolean',
            'metadata'             => 'array',
        ];
    }

    public function order(): BelongsTo  { return $this->belongsTo(Order::class); }
    public function user(): BelongsTo   { return $this->belongsTo(User::class); }
    public function client(): BelongsTo { return $this->belongsTo(Client::class); }
}
