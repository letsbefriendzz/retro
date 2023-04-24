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

    protected $guarded = [];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
