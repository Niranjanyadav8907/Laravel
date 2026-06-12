<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
		'user_name',
		'action',
		'module',
		'description',
		'url',
		'method',
		'ip_address',
		'user_agent',
		'route_name',
		'controller',
		'status_code',
		'response_time',
		'session_id',
		'referer',
		'request_data',
		'error_message',
    ];
	
}