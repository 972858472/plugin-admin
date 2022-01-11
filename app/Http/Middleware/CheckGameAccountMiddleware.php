<?php
/**
 * @Author zayn
 * @Date 2021/11/11 15:08
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckGameAccountMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->post('gameAccount') !== Auth::user()['game_account']) {
            return response()->json(fail($request->post(), '钱包地址错误', 402));
        }
        return $next($request);
    }
}
