<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = [
        'name', 'first_name', 'last_name',
        'email', 'phone', 'company', 'website',
        'service', 'billing_cycle',
        'status', 'payment_status',
        'start_date', 'end_date',
        'notes',
        'lead_id', 'user_id',
        'stripe_customer_id', 'stripe_subscription_id',
        'last_payment_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date'      => 'date',
            'end_date'        => 'date',
            'last_payment_at' => 'datetime',
        ];
    }

    public const STATUSES = ['onboarding', 'active', 'paused', 'completed', 'churned'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
