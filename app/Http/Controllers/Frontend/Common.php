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

class Common extends Controller
{
    public function __construct(){
        
    }

    public function log($abstract){
    	$admin_id = auth()->guard('admin')->user()['id'];
    	$model = new \App\Http\Models\Log();
		$data = $model->backend(['admin_id'=>$admin_id,'abstract'=>$abstract]);

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
        $user_discount = $user_discount['discount'];
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
}