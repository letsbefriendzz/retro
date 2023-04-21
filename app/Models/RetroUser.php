<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RetroUser extends Model
{
    use HasFactory;

    public const DAISY_UI_COLOURS = [
        'primary-focus',
        'accent-focus',
        'info',
        'success',
        'success-content',
        'warning',
        'error',
        'error-content',
    ];

    protected $guarded = [];

    public function retroSession(): BelongsTo
    {
        return $this->belongsTo(RetroSession::class);
    }

    public function retroNotes(): HasMany
    {
        return $this->hasMany(RetroNote::class);
    }
}
