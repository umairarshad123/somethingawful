<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'password',
        'role',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** Convenience: full name. */
    public function getNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /** Initials for avatar. */
    public function getInitialsAttribute(): string
    {
        $a = mb_substr($this->first_name, 0, 1);
        $b = mb_substr($this->last_name,  0, 1);
        return mb_strtoupper($a . $b);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
