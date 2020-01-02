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

class Order extends Common
{
    //列表
    public function index(Request $request){
		$no = trim($request->no);
		$state = (int)$request->state;
		
		$where = [];
		if($no){
			$where[] = ['no', 'like', '%'.$no.'%'];
		}
		if(isset($request->state)){
			$where[] = ['state', '=', $state];
		}

		$appends = [];
		if($no){
			$appends['no'] = $no;
		}
		if(isset($request->state)){
			$appends['state'] = $state;
		}
		
		$data = Db::table('order')->where($where)->orderBy('id','desc')->pages($appends);
		//用户
		$data['users'] = DB::table('user')->select(['id','username'])->cates('id');
		return view('backend.order.index',$data);
	}

	//添加修改
	public function item(Request $request){
		$id = (int)$request->id;
		$data['order'] = Db::table('order')->where('id',$id)->item();
		$data['products'] = DB::table('order_product')->cates('id');
		
		//用户
		$data['users'] = DB::table('user')->select(['id','username'])->cates('id');
		return view('backend.order.item',$data);
	}

	//保存
	public function save(Request $request){
		$id = (int)$request->id;
		
		//添加操作日志
		//$this->log($log);
		$this->returnMessage(200,'保存成功');
	}


	// 保存分类
	public function product(Request $request){
		$id = (int)$request->id;

		if($id){
			$result = Db::table('order_product')->where('order_id', $id)->lists();
		}else{
			$this->returnMessage(400,'查询失败');
		}

		//添加操作日志
		//$this->log($log);
		$this->returnMessage(200,'查询成功',$result);
	}

}
