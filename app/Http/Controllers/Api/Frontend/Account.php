<?php
/**
 * ----------------------------------------------------------------------
 * ONEUE - A SIMPLE E-COMMERCE SYSTEM
 * ----------------------------------------------------------------------
 * AUTHOR: THANKIFU [i@thankifu.com]
 * ----------------------------------------------------------------------
 * RELEASED ON: 2019.11.15
 * ----------------------------------------------------------------------
 * LICENSED: MIT [https://github.com/thankifu/oneue/blob/master/LICENSE]
 * ----------------------------------------------------------------------
**/

namespace App\Http\Controllers\Api\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Frontend\Common;

class Account extends Common
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest:api')->except('logout');
    }

    //登录验证
    public function login(Request $request){
        $username = trim($request->username);
        $password = trim($request->password);

        if($username == ''){
            $this->returnMessage(400,'请输入用户名');
        }
        if($password == ''){
            $this->returnMessage(400,'请输入密码');
        }

        $token = null;
        $input = $request->only('username', 'password');

        //验证数据格式
        $this->validator($input);

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'code' => 400,
                'text' => '登录失败',
            ]);
        }

        return response()->json([
            'code' => 200,
            'text' => '登录成功',
            'data' => array('token' => $token),
        ]);
    }

    //退出
    public function logout(Request $request)
    {
        $token = trim($request->token);
        if($token == ''){
            $this->returnMessage(400,'Token 错误');
        }

        JWTAuth::invalidate($request->token);

        return response()->json([
            'code' => 200,
            'text' => '退出成功',
        ]);
    }

    //注册验证
    public function register(Request $request){

        echo json_encode(array('code'=>200,'text'=>'注册成功'));
        
    }

    public function user(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        return response()->json(['result' => $user]);
    }

}
