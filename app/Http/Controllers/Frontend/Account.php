<?php
/**
* ----------------------------------------------------------------------
* 福州星科创想网络科技有限公司
* ----------------------------------------------------------------------
* COPYRIGHT © 2015-PRESENT STARSLABS.COM ALL RIGHTS RESERVED.
* ----------------------------------------------------------------------
* LICENSED: MIT [https://github.com/thankifu/oneue/blob/master/LICENSE]
* ----------------------------------------------------------------------
* AUTHOR: THANKIFU [i@thankifu.com]
* ----------------------------------------------------------------------
* RELEASED ON: 2019.11.15
* ----------------------------------------------------------------------
*/
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Account extends Common
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest:admin')->except('logout');
        $this->middleware('guest')->except('logout');
    }

    //登录页
    public function showLogin(){
        return view('frontend.account.login');
    }

    //登录验证
    public function login(Request $request){
        $username = trim($request->username);
        $password = trim($request->password);

        /*// 验证用户名登录方式
        $usernameLogin = Auth::attempt(
            ['username' => $username, 'password' => $password], $request->has('remember')
        );
        if ($usernameLogin) {
            return true;
        }
        // 验证手机号登录方式
        $mobileLogin = Auth::attempt(
            ['mobile' => $username, 'password' => $password], $request->has('remember')
        );
        if ($mobileLogin) {
            return true;
        }

        // 验证邮箱登录方式
        $emailLogin = Auth::attempt(
            ['email' => $username, 'password' => $password], $request->has('remember')
        );
        if ($emailLogin) {
            return true;
        }*/

        $res = Auth::attempt(
            ['username' =>$username, 'password' => $password, 'state'=>1], $request->has('remember')
        );

        if(!$res){
            $this->returnMessage(400,'登录失败');
        }
        // 更新登录ip、时间
        Db::table('user')->where(array('username'=>$username))->update(array('logined_ip'=>$request->getClientIp(),'logined'=>time()));

        //$this->log('登录系统。');

        echo json_encode(array('code'=>200,'text'=>'登录成功'));
    }

    //退出
    public function logout()
    {
        if(Auth::check()){
            Auth::logout();  //退出登录
        }
        echo json_encode(array('code'=>200,'text'=>'退出成功'));
    }

    /*public function checkName($name){
        $is_name = ;
        $is_email = ;
        $is_phone = ;
    }*/
    

}
