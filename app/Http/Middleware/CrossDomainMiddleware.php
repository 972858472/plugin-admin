<?php
/**
 * @Author zayn
 * @Date 2021/11/17 11:52
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class CrossDomainMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
