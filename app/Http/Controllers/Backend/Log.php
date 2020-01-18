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

class Log extends Common
{
    //列表
    public function index(Request $request){

		$ip = trim($request->ip);
		$abstract = trim($request->abstract);
		$admin_id = (int)$request->admin_id;
		
		$where = [];
		if($ip){
			$where[] = ['ip', 'like', '%'.$ip.'%'];
		}
		if($ip){
			$where[] = ['abstract', 'like', '%'.$abstract.'%'];
		}
		if(isset($request->admin_id)){
			$where[] = ['admin_id', '=', $admin_id];
		}

		$appends = [];
		if($ip){
			$appends['ip'] = $ip;
		}
		if($abstract){
			$appends['abstract'] = $abstract;
		}
		if(isset($request->admin_id)){
			$appends['admin_id'] = $admin_id;
		}
		
		$data = Db::table('admin_log')->where($where)->orderBy('id','desc')->pages($appends);

		//管理员
		$data['admins'] = DB::table('admin')->select(['id','username'])->cates('id');

		return view('backend.log.index',$data);
	}

}
