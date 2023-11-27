<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    protected $table = 'question_banks';

    protected $fillable = [
        'quiz_id', 'question', 'option1', 'option2', 'option3', 'option4', 'answer',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
