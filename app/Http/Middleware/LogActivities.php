<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;

class LogActivities
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            LogActivity::create([
                'subject' => $request->method() . ' ' . $request->path(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'agent' => $request->header('User-Agent'),
                'user_id' => Auth::id(),
            ]);

        }

        return $response;
    }
}
