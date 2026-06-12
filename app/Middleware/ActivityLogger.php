<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;

use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
   /*  public function handle(Request $request, Closure $next){
        $response = $next($request);

        try {
            ActivityLog::create([
                'user_id'    => Auth::id(),
                'user_name'  => Auth::user()->name ?? 'Guest',
                'action'     => 'page_open',
                'url'        => $request->fullUrl(),
                'method'     => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            // ignore errors silently
        }

        return $response;
    } */
}