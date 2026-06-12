<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizAttempt extends Model
{
    use HasFactory;

    protected $table = 'user_quiz_attempts';
    protected $primaryKey = 'id';   // ✅ correct
    public $timestamps = true;      // created_at, updated_at present


    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'total_attempt_question',
        'started_at',
        'finished_at',
        'status',
        'message'
    ];
 
    public function answers()
    {
        return $this->hasMany(UserAnswer::class, 'attempt_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /* public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    } */
	public function quiz(){
		return $this->belongsTo(Quiz::class, 'quiz_id');
	}

	
}
