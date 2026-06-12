<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;

use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public function handle(Request $request, Closure $next){
		$start = microtime(true);

		$response = $next($request);

		$end = microtime(true);
		$time = round(($end - $start) * 1000); // ms

		try {

			$route = $request->route();

			ActivityLog::create([
				'user_id'       => Auth::id(),
				'user_name'     => Auth::check() ? Auth::user()->name : 'Guest',
				'action'        => 'page_open',
				'module'        => optional($route)->getName(),
				'url'           => $request->fullUrl(),
				'method'        => $request->method(),
				'ip_address'    => $request->ip(),
				'user_agent'    => $request->userAgent(),
				'route_name'    => optional($route)->getName(),
				'controller'    => optional($route)->getActionName(),
				'status_code'   => $response->getStatusCode(),
				'response_time' => $time,
				'session_id'    => session()->getId(),
				'referer'       => $request->headers->get('referer'),
				'request_data'  => json_encode($request->except(['password','password_confirmation'])),
			]);

		} catch (\Exception $e) {
			\Log::error($e->getMessage());
		}

		return $response;
	}
	
	
}