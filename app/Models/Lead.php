<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'company',
        'service', 'message',
        'source', 'page',
        'status', 'assigned_label', 'internal_notes',
        'ip', 'user_agent',
        'user_id',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'last_activity_at' => 'datetime',
        ];
    }

    /** Allowed status values, in workflow order. */
    public const STATUSES = ['new', 'contacted', 'qualified', 'proposal', 'won', 'lost'];

    /** Source labels surfaced in the admin filters. */
    public const SOURCES = [
        'hero'    => 'Hero form',
        'popup'   => 'Lead popup',
        'contact' => 'Contact page',
        'manual'  => 'Manual entry',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
