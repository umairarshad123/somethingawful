<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id', 'client_id',
        'service_slug', 'service_name', 'billing_cycle', 'quantity',
        'amount', 'currency',
        'first_name', 'last_name', 'email', 'phone', 'company', 'website', 'notes',
        'stripe_session_id', 'stripe_payment_intent_id',
        'stripe_customer_id', 'stripe_subscription_id',
        'payment_status', 'order_status',
        'metadata', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'paid_at'  => 'datetime',
        ];
    }

    /** Cycle vocabulary used internally + for Stripe mode mapping. */
    public const CYCLE_PROJECT    = 'project';
    public const CYCLE_MONTHLY    = 'mo';
    public const CYCLE_WEEKLY     = 'week';
    public const CYCLE_PER_ZAP    = 'per_zap';
    public const CYCLE_PER_SCRIPT = 'per_script';
    public const CYCLE_PER_ASSET  = 'per_asset';

    public static function generateOrderNumber(): string
    {
        return 'DR-' . strtoupper(Str::random(10));
    }

    public function isRecurring(): bool
    {
        return in_array($this->billing_cycle, ['mo', 'week'], true);
    }

    public function user(): BelongsTo       { return $this->belongsTo(User::class); }
    public function client(): BelongsTo     { return $this->belongsTo(Client::class); }
    public function subscription(): HasOne  { return $this->hasOne(Subscription::class); }

    /** Format the amount for display ("$1,200" from cents). */
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount / 100, 2);
    }

    public function getCycleLabelAttribute(): string
    {
        return match ($this->billing_cycle) {
            'project'    => 'one-time',
            'mo'         => '/month',
            'week'       => '/week',
            'per_zap'    => 'per Zap',
            'per_script' => 'per script',
            'per_asset'  => 'per asset',
            default      => $this->billing_cycle,
        };
    }
}
