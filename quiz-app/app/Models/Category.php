<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];

    public function quiz(){
        return $this->hasMany(Quiz::class);
    }

    public function quizzes(){
        return $this->hasMany(Quiz::class, 'category_id');
    }

}