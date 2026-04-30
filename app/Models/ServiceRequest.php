<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    protected $fillable = [
        'slug', 'service_name', 'category',
        'user_id', 'was_logged_in', 'signed_up_after',
        'action', 'follow_up_status',
        'ip', 'user_agent', 'referrer',
    ];

    protected function casts(): array
    {
        return [
            'was_logged_in'   => 'boolean',
            'signed_up_after' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
