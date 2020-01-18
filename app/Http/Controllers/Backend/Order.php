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
	public function show(Request $request){
		$id = (int)$request->id;
		$data['order'] = Db::table('order')->where('id',$id)->item();
		$data['products'] = DB::table('order_product')->where('order_id',$id)->cates('id');
		
		//用户
		$data['users'] = DB::table('user')->select(['id','username'])->cates('id');
		return view('backend.order.show',$data);
	}

	//发货
	public function shipmentShow(Request $request){
		$id = (int)$request->id;

		if(!$id){
			$this->returnMessage(400,'订单参数错误');
		}

		$data['order'] = Db::table('order')->where('id',$id)->item();

		$data['expresses'] = Db::table('express')->select(['id','name'])->cates('id');

		return view('backend.order.shipment.show',$data);

	}

	//发货保存
	public function shipmentStore(Request $request){
		$id = (int)$request->id;

		if(!$id){
			$this->returnMessage(400,'订单参数错误');
		}

		$data['express_id'] = trim($request->express_id);
		$data['express_no'] = trim($request->express_no);
		$data['state'] = 3;
		$data['shipped'] = time();

		$express = Db::table('express')->select(['name'])->where('id',$data['express_id'])->item();
		$data['express_name'] = $express['name'];

		$res = Db::table('order')->where('id',$id)->update($data);
		$log = '订单发货：ID：'.$id.'。';

		//添加日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');

	}

}
