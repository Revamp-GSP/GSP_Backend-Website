<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogResponseTime
{
    public function handle($request, Closure $next)
    {
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $executionTime = round(($endTime - $startTime) * 1000, 2); // dalam milidetik

        // Mendapatkan informasi tentang tindakan yang sedang diproses
        $action = $request->route()->getActionMethod();
        $uri = $request->getRequestUri();

        // Memasukkan informasi tentang tindakan yang sedang diproses ke dalam log
        Log::info("Response time for $action ($uri): {$executionTime} ms");

        return $response;
    }
}

