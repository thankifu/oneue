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

class Common extends Controller
{
    public function __construct(Request $request){
        
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

    //获取配置
    protected function getSeting($key){
        $data = Db::table('admin_setting')->where(array('key'=>$key))->item();
        $data['value'] && $data['value'] = json_decode($data['value'],true);
        !$data['value'] && $data['value'] = false;
        return $data;
    }

}