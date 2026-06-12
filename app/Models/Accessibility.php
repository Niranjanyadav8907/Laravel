<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessibility extends Model
{
    use HasFactory;

	
	protected $table = 'accessibilities';

    protected $fillable = [
        'role_id','module','action','access'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

