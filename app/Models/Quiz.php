<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
	
	protected $table = 'quiz'; 

    protected $fillable = [
        'user_id',
        'quiz_title',
        'quiz_description',
        'category_id',
        'difficulty',
        'total_questions',
        'status',
        'start_date',
        'end_date',
        'timer',
        'quiz_image',
        'created_by',
        'schedule',        
        'quiz_planner',    
        'quiz_controls'  

    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   

	
	public function questions(){
		return $this->hasMany(Question::class, 'quiz_id', 'id');
	}
}
