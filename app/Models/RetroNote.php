<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RetroNote extends Model
{
    use HasFactory;

    public const RETRO_COLUMNS = [
        'wentWell',
        'toImprove',
        'toDiscuss',
    ];

    protected $guarded = [];

    public function retroSession(): BelongsTo
    {
        return $this->belongsTo(RetroSession::class);
    }
}
