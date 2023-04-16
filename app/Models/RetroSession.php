<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RetroSession extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function retroNotes(): HasMany
    {
        return $this->hasMany(RetroNote::class);
    }

    public function retroUsers(): HasMany
    {
        return $this->hasMany(RetroUser::class);
    }
}
