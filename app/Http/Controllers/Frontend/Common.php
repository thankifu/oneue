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

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Common extends Controller
{
    public function __construct(){
        
    }

    public function log($abstract){
    	$admin_id = auth()->guard('admin')->user()['id'];
    	$model = new \App\Http\Models\Log();
		$data = $model->backend(['admin_id'=>$admin_id,'abstract'=>$abstract]);

    }

    protected function validator($params){
        $input = $params;

        $rules = [
            'username' => 'sometimes|required|min:4|max:15',
            'password' => 'sometimes|required|min:6|max:20',
            'email' => 'sometimes|email',
            'email_code' => 'sometimes|required',
            'phone' => 'sometimes',
            'phone' => 'regex:/^1[345789][0-9]{9}$/',
            'phone_code' => 'sometimes|required',
        ];
        $messages = [
            'required'  => ':attribute不能为空',
            'min'  => ':attribute不能小于:min个字数',
            'max'  => ':attribute不能大于:max个字数',
            'email' => ':attribute格式错误',
            'regex' => ':attribute格式错误',
        ];
        $attributes = [
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'email_code' => '邮箱验证码',
            'phone' => '手机',
            'phone_code' => '手机验证码',

        ];

        $validator = Validator::make($input, $rules, $messages, $attributes);
       
        if ($validator->fails()) {
            $message = $validator->errors()->all();
            //print_r($message);
            $this->returnMessage(400,$message[0]);
        }
    }

    public function returnMessage($code, $text='', $data=[]){
        $return_data['code'] = $code;
        $return_data['text'] = $text;
        $return_data['data'] = $data;
        echo json_encode($return_data);
        die;
    }

    public function getUserDiscount(){
        if(!auth()->user()){
            return 1;
            exit();
        }
        $user_level = auth()->user()->level;
        $user_discount = Db::table('user_level')->select(['discount'])->where('id', $user_level)->item();
        if(!$user_discount){
            $user_discount = 10; //如果没有等级，则默认无折扣
        }else{
            $user_discount = $user_discount['discount'];
        }
        $result = number_format(floatval($user_discount) / 10, 2, '.', '');
        return $result;
    }

    public function getProductPrice($price, $discount = 1){
        if(!auth()->user()){
            return $price;
            exit();
        }   
        $result = number_format(floatval($price) * $discount, 2, '.', '');
        return $result;
    }

    //获取配置
    protected function getSeting($key){
        $data = Db::table('admin_setting')->where(array('key'=>$key))->item();
        $data['value'] && $data['value'] = json_decode($data['value'],true);
        !$data['value'] && $data['value'] = false;
        return $data;
    }

    protected function getNumber()
    {
        //生成16位订单编号
        $number = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        return $number;
    }

    //生成随机参数
    protected function getCode($len, $chars=null) {
        if (is_null($chars)){  
            $chars = "0123456789";  
        }   
        mt_srand(10000000*(double)microtime());  
        for ($i = 0, $code = '', $lc = strlen($chars)-1; $i < $len; $i++){  
            $code .= $chars[mt_rand(0, $lc)];   
        }
        return $code;
    }

    //邮箱验证码验证
    protected function checkEmailCode($email, $email_code){
        $email_code_md5 = md5($email.'_'.$email_code);
        
        if(!session_id()) session_start();
        //验证码处理
        if( isset($_SESSION[$email.'_email_code']) ) {
            if ($email_code_md5 != $_SESSION[$email.'_email_code']) {
                $this->returnMessage(400, "验证码错误");
            }
        }else{
            $this->returnMessage(400, "验证码不存在");
        }
        
    }

    //手机验证码验证
    protected function checkPhoneCode($phone, $phone_code){
        $phone_code_md5 = md5($phone.'_'.$phone_code);
        
        if(!session_id()) session_start();
        //验证码处理
        if( isset($_SESSION[$phone.'_phone_code']) ) {
            if ($phone_code_md5 != $_SESSION[$phone.'_phone_code']) {
                $this->returnMessage(400, "验证码错误");
            }
        }else{
            $this->returnMessage(400, "验证码不存在");
        }
    }
}