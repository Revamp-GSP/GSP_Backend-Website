<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_admin == 1) {
            return $next($request);
        } else {
            // Tampilkan pesan alert jika bukan admin
            return response()->json([
                'message' => "Anda tidak memiliki akses ke halaman ini."
            ]);
        }
    }
}
