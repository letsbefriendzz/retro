<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function unusedColours()
    {
        return [];
    }
}
