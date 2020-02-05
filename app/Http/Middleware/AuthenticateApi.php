<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class AuthenticateApi
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
        //exit(var_dump($request->token));
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'code' => 401,
                    'text' => '请先登录',
                ]);
            }
            //如果想向控制器里传入用户信息，将数据添加到$request里面
            //$request->attributes->add(["user" => $user]);//添加参数
            return $next($request);
        } catch (Exception $exception) {
            if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'code' => 401,
                    'text' => 'Token 无效',
                ]);
            }else if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'code' => 401,
                    'text' => '请重新登录', //Token 过期
                ]);
            }else{
                return response()->json([
                    'code' => 401,
                    'text' => '出错了，请先登录',
                ]);
            }
        }
    }
}
