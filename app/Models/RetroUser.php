<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetroUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function retroSession()
    {
        return $this->belongsTo(RetroSession::class);
    }
}
