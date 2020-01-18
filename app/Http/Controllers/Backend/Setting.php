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
use Illuminate\Support\Facades\Mail;
use Config;

class Setting extends Common
{
    //网站设置
	public function index(){
		$data = $this->getSeting('site');
		return view('backend/setting/index',$data);
	}

	//附件设置
	public function annex(){
		$data = $this->getSeting('annex');
		return view('backend/setting/annex',$data);
	}

	//保存设置
	public function store(Request $request){
		$data = $request->all();
		$key = $data['key'];
		unset($data['key']);
		unset($data['_token']);
		$is = Db::table('admin_setting')->where(array('key'=>$key))->item();
		if($is){
			Db::table('admin_setting')->where(array('key'=>$key))->update(array('value'=>json_encode($data)));
		}else{
			Db::table('admin_setting')->insert(array('key'=>$key,'value'=>json_encode($data)));
		}

		if($key === 'site'){
			$log = '修改网站设置。';
		}
		if($key === 'annex'){
			$log = '修改附件设置。';
		}

		//添加操作日志
		$this->log($log);

		$this->returnMessage(200,'保存成功');
	}

}
