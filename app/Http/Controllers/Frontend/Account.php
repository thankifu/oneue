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

        $site = $this->getSeting('site')['value'];
        $auth_register = $site['auth_register'];
        $auth_email = $site['auth_email'];
        $auth_phone = $site['auth_phone'];

        if(!$auth_register){
            $this->returnMessage(400,'禁止注册');
        }

        $this->validator($request->all());

        $username = trim($request->username);
        $password = trim($request->password);

        $email = trim($request->email);
        $email_code = trim($request->email_code);
        $phone = trim($request->phone);
        $phone_code = trim($request->phone_code);

        if($auth_email){
            $data['email'] = $email;
            $this->checkEmailCode($email, $email_code);
        }

        if($auth_phone){
            $data['phone'] = $phone;
            $this->checkPhoneCode($phone, $phone_code);
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

        if(!session_id()) session_start();
        if(isset($_SESSION[$email.'_email_code'])){
            unset($_SESSION[$email.'_email_code']);
        }

        // 更新登录ip、时间
        Db::table('user')->where(array('username'=>$username))->update(array('logined_ip'=>$request->getClientIp(),'logined'=>time()));

        echo json_encode(array('code'=>200,'text'=>'注册成功'));
        
    }
}
