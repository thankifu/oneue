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

        if($username == ''){
            $this->returnMessage(400,'请输入用户名');
        }
        if($password == ''){
            $this->returnMessage(400,'请输入密码');
        }

        //exit(var_dump($request->has('remember')));

        $result = Auth::attempt(
            ['username' => $username, 'password' => $password, 'state'=>1], $request->has('remember')
        );

        if(!$result){
            $this->returnMessage(400,'登录失败');
        }

        //更新登录ip、时间
        Db::table('user')->where(array('username'=>$username))->update(array('logined_ip'=>$request->getClientIp(),'logined'=>time()));

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

    //注册页
    public function showRegister(){
        return view('frontend.account.register');
    }

    //注册验证
    public function register(Request $request){

        //$this->returnMessage(400,'演示环境禁止注册');

        $username = trim($request->username);
        $password = trim($request->password);

        if($username == ''){
            $this->returnMessage(400,'请输入用户名');
        }
        if($password == ''){
            $this->returnMessage(400,'请输入密码');
        }

        $has = DB::table('user')->where('username',$username)->item();
        if($has){
            $this->returnMessage(400,'用户名已存在');
        }

        $data['username'] = $username;
        $data['password'] = bcrypt($password);
        $data['created'] = time();
        $data['state'] = 1;

        $result = Db::table('user')->insertGetId($data);

        if(!$result){
            $this->returnMessage(400,'注册失败');
        }

        $result = Auth::attempt(
            ['username' => $username, 'password' => $password, 'state'=>1]
        );

        if(!$result){
            $this->returnMessage(400,'自动登录失败');
        }

        // 更新登录ip、时间
        Db::table('user')->where(array('username'=>$username))->update(array('logined_ip'=>$request->getClientIp(),'logined'=>time()));

        echo json_encode(array('code'=>200,'text'=>'注册成功'));
        
    }

}
