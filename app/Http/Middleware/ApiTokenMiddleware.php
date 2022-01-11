<?php
/**
 * @Author zayn
 * @Date 2021/11/11 15:08
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        if (Auth::guard('api')->guest()) {
            return response()->json(fail([], '权限不足', 401));
        }
        if (Auth::guard('api')->user()['state'] == 0) return response()->json(fail([], '账号已被禁用，无法使用', 401));

        $games = json_decode(Auth::guard('api')->user()['games'], true);
        if (!in_array('0', $games)) return response()->json(fail([], '该账户未允许使用此脚本，请联系管理员', 402));

        Auth::login(Auth::guard('api')->user());
        return $next($request);
    }
}
