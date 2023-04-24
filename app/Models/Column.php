<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Column extends Model
{
    use HasFactory;

    public const DEFAULT_COLUMNS = [
        [
            'title' => 'Went Well',
        ],
        [
            'title' => 'To Improve',
        ],
        [
            'title' => 'To Discuss',
        ],
    ];

    protected $guarded = [];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
