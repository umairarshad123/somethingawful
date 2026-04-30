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
            'subject_label' => self::safeLabel($label),
            'subject_type'  => $subject ? class_basename($subject) : null,
            'subject_id'    => $subject?->getKey(),
            'user_id'       => $userId,
            'actor_id'      => auth()->id(),
            'payload'       => $payload ?: null,
            'ip'            => $request?->ip(),
            'user_agent'    => $request ? substr((string) $request->userAgent(), 0, 240) : null,
        ]);
    }

    /**
     * Strip characters the production MySQL column can't store. The current
     * `subject_label` column on prod is `utf8` (3-byte) rather than utf8mb4,
     * which means anything outside the Basic Multilingual Plane crashes the
     * INSERT with SQLSTATE[22007]. Some MySQL builds also choke on perfectly
     * valid 3-byte UTF-8 if the column collation is misconfigured.
     *
     * The defensive fix: transliterate down to ASCII before persisting.
     * Loses some fidelity (an arrow becomes ->) but never crashes.
     */
    private static function safeLabel(?string $label): ?string
    {
        if ($label === null || $label === '') return $label;
        $clean = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $label);
        if ($clean === false) {
            // iconv unavailable / refused. Fall back to a regex strip of
            // anything outside printable ASCII, replaced with a space.
            $clean = preg_replace('/[^\x20-\x7E]/u', ' ', $label) ?? '';
        }
        return mb_substr($clean, 0, 240);
    }
}
