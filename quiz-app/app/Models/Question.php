<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
	
    protected $table = 'questions'; 

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'correct_option',
        'correct_option_number',
        'marks'
    ];
    protected $appends = ['quiz_title'];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }

    public function getQuizTitleAttribute()
    {
        return $this->quiz ? $this->quiz->quiz_title : null;
    }
}
