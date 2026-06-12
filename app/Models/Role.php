<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Role extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'role';

    protected $fillable = [
        'role_name',
        'role_slug',
        'description',
        'status',
        'is_system_role',
    ];
	
	public function permissions(){
        return $this->hasMany(Accessibility::class);  
    }
}
