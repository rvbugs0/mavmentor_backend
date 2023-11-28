<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = [
        'title', 'location', 'expires_at',
    ];

    public function setExpiresAtAttribute($value)
    {
        $this->attributes['expires_at'] = \Carbon\Carbon::parse($value);
    }
}
