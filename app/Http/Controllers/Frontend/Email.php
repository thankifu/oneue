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
//use Mail;
use Illuminate\Support\Facades\Mail;

/**
 * 邮件发送
**/

class Email extends Common{
    
    //用户注册
    public function index(Request $request){
        
        //获取指定值
        $params = $request->only(['username', 'email']);
        if(!$params){
            $this->returnMessage(400,'参数错误');
        }

        //验证数据格式
        $this->validator($params);

        //获取设置参数值
        $username = trim($request->username);
        $email = trim($request->email);
        $email_code = $this->getCode(6);
        $email_code_md5 = md5(config('app.key').'_'.$email.'_'.$email_code);
        $site_name = $this->getSeting('site')['value']['name'];
        $subject = $site_name.'会员邮箱验证';

        //判断用户名是否存在
        $has = DB::table('user')->where('username',$username)->item();
        if($has){
            $this->returnMessage(400,'用户名已存在');
        }

        //判断邮箱是否存在
        $has = DB::table('user')->where('email',$email)->item();
        if($has){
            $this->returnMessage(400,'邮箱已存在');
        }

        //Mail::send()的返回值为空，所以需要在其他方法进行判断 
        Mail::send('frontend.email.index',['site_name'=>$site_name, 'username'=>$username, 'email_code'=>$email_code],function($message) use ($email, $subject){ 
            $message->to($email)->subject($subject);
        });

        //返回的一个错误数组，可以判断是否发送成功
        if(count(Mail::failures()) >= 1){
            $this->returnMessage(400,'发送失败');
        }

        //储存SESSION
        session(['email.time' => time()]);
        session(['email.code' => $email_code_md5]);

        //返回信息，如果在controller或者view里面写了exit;，那么session是不会被保存的，除非主动的写Session::save()才能手工的保存起来。或者把die();exit();换成return！
        //$this->returnMessage(200,'发送成功');
        echo json_encode(array('code'=>200,'text'=>'发送成功'));

        /*Mail::raw('你好！', function ($message) {
            $to = '@qq.com';
            $message->to($to)->subject('纯文本信息邮件测试');
        });*/
    }

    //重设密码
    public function reset(Request $request){
        //获取指定值
        $params = $request->only(['email']);
        //验证数据格式
        $this->validator($params);

        //获取设置参数值
        $email = trim($request->email);
        $email_code = $this->getCode(6);
        $email_code_md5 = md5($email.'_'.$email_code);
        $site_name = $this->getSeting('site')['value']['name'];
        $subject = $site_name.'会员密码重设';

        //判断邮箱是否存在
        $has = DB::table('user')->where('email',$email)->item();
        if(!$has){
            $this->returnMessage(400,'账号邮箱不存在');
        }

        $username = $has['username'];

        //Mail::send()的返回值为空，所以需要在其他方法进行判断
        Mail::send('frontend.email.reset',['site_name'=>$site_name, 'username'=>$username, 'email_code'=>$email_code],function($message) use ($email, $subject){ 
            $message->to($email)->subject($subject);
        });

        //返回的一个错误数组，可以判断是否发送成功
        if(count(Mail::failures()) >= 1){
            $this->returnMessage(400,'发送失败');
        }

        //储存SESSION
        session(['email.time' => time()]);
        session(['email.code' => $email_code_md5]);

        //返回信息，如果在controller或者view里面写了exit;，那么session是不会被保存的，除非主动的写Session::save()才能手工的保存起来。或者把die();exit();换成return！
        //$this->returnMessage(200,'发送成功');
        echo json_encode(array('code'=>200,'text'=>'发送成功'));
    }

}
