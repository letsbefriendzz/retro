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

    public function columns()
    {
        return $this->hasMany(Column::class);
    }

    public function createDefaultColumns()
    {
        collect(Column::DEFAULT_COLUMNS)->each(function ($column) {
            $this->columns()->create([
                'title' => $column['title'],
                'session_id' => $this->id
            ]);
        });
    }
}
