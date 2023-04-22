<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $id
 */
class Note extends Model
{
    use HasFactory;

    public const RETRO_COLUMNS = [
        'wentWell',
        'toImprove',
        'toDiscuss',
    ];

    protected $guarded = [];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }
}
