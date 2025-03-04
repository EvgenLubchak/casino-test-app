<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryLink extends Model
{
    protected $fillable = [
        'user_id', 'token', 'expires_at',
    ];

    // Cast expires_at to a date instance (Carbon)
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if the current instance is valid based on expiration.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->expires_at && $this->expires_at->isFuture();
    }
}
