<?php

namespace App\Http\Middleware;

use Closure;

class CekCustomersMiddleware
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
        if (!session('customer_id')) {
            return redirect('/customer-login');
        }
        return $next($request);
    }
}
