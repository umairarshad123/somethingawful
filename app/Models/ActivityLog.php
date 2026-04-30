<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class ActivityLog extends Model
{
    protected $fillable = [
        'event', 'subject_label', 'subject_type', 'subject_id',
        'user_id', 'actor_id', 'payload',
        'ip', 'user_agent',
    ];

    protected function casts(): array
    {
        return ['payload' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Convenience constructor used everywhere across the app to drop a row
     * without repeating boilerplate at call sites.
     */
    public static function record(
        string $event,
        ?string $label = null,
        ?Model $subject = null,
        ?int $userId = null,
        array $payload = [],
        ?Request $request = null
    ): self {
        return self::create([
            'event'         => $event,
            'subject_label' => $label,
            'subject_type'  => $subject ? class_basename($subject) : null,
            'subject_id'    => $subject?->getKey(),
            'user_id'       => $userId,
            'actor_id'      => auth()->id(),
            'payload'       => $payload ?: null,
            'ip'            => $request?->ip(),
            'user_agent'    => $request ? substr((string) $request->userAgent(), 0, 240) : null,
        ]);
    }
}
