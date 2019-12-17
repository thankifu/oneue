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

class Product extends Common
{
    //
    public function index(Request $request){
    	$discount = $this->getUserDiscount();

		$data = Db::table('product')->where('state', 1)->orderBy('id','desc')->pages('', 12);

		foreach ($data['lists'] as $key => $value) {
			$price  = $this->getProductPrice($data['lists'][$key]['selling'], $discount);
			$data['lists'][$key]['price'] = $price;
		}

		return view('frontend.product.index', $data);
	}

	public function category(Request $request){
    	$id = (int)$request->id;
    	$discount = $this->getUserDiscount();

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

		$data = Db::table('product')->where($where)->orderBy('id','desc')->pages('', 12);

		foreach ($data['lists'] as $key => $value) {
			$price  = $this->getProductPrice($data['lists'][$key]['selling'], $discount);
			$data['lists'][$key]['price'] = $price;
		}

		//当前分类
		$data['category'] = Db::table('product_category')->where('id',$id)->where('state',1)->select(['id','name'])->item();
        
		return view('frontend.product.index', $data);
	}

	public function item(Request $request){
    	$id = (int)$request->id;
    	$discount = $this->getUserDiscount();

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		$data['product'] = Db::table('product')->where($where)->orderBy('id','desc')->item();
		$data['product']['description'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/none.png' ), $data['product']['description'] );

		$data['product']['price'] = $this->getProductPrice($data['product']['selling'], $discount);

		//当前分类
		$data['category'] = Db::table('product_category')->where('id',$data['product']['category_id'])->where('state',1)->select(['id','name'])->item();

		//图片
		$data['pictures'] = DB::table('product_picture')->select(['id','picture','position'])->where('product_id',$data['product']['id'])->lists();

		//规格
		$data['specifications'] = Db::table('product_specification')->where('product_id',$data['product']['id'])->lists();
		foreach ($data['specifications'] as $key => $value) {
			$price  = $this->getProductPrice($data['specifications'][$key]['selling'], $discount);
			$data['specifications'][$key]['price'] = $price;
		}

		if(auth()->user()){
            $user_level = auth()->user()->level;
            $data['level'] = Db::table('user_level')->select(['name'])->where('id', $user_level)->item();
            //print_r($data['level_name']);
        }
		
		DB::table('product')->increment('visit', 1);
        
		return view('frontend.product.item', $data);
	}

}