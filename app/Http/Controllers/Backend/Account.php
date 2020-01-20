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

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * ----------------------------------------------------------------------
 * 账户
 * ----------------------------------------------------------------------
**/

class Account extends Common
{
	use AuthenticatesUsers;

    //指定数据库
	protected $table = 'admin';

    //构造函数
    public function __construct()
    {
        //$this->middleware('guest:admin')->except('logout');
        $this->middleware('guest.admin')->except('logout');
    }

	protected function guard()
    {
        return auth()->guard('admin');
    }

    //登录页面
    public function showLogin(){
        return view('backend.account.login');
    }

    //登录验证
    public function login(Request $request){
        $username = trim($request->username);
        $password = trim($request->password);

        $res = $this->guard()->attempt(
            ['username' =>$username, 'password' => $password]
        );
        if(!$res){
            //exit(json_encode(array('code'=>1,'msg'=>'登录失败')));
            $this->returnMessage(400,'登录失败');
        }
        // 更新登录ip、时间
        Db::table('admin')->where(array('username'=>$username))->update(array('logined_ip'=>$request->getClientIp(),'logined'=>time()));

        $this->log('登录系统。');

        echo json_encode(array('code'=>200,'text'=>'登录成功'));
    }

    //退出
    public function logout(Request $request)
    {
        /*$this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/admin');*/

        if($this->guard()->check()){
            $this->guard()->logout();
        }
        echo json_encode(array('code'=>200,'text'=>'退出成功'));
        
    }

    

}
