<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizmaster extends Model
{
    use HasFactory;

    protected $table = 'quiz_master';

    protected $fillable = [
        'name',
        'email',
        'role',
        'bio',
        'photo',
        'status',
        'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}