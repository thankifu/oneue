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

/**
 * 商品
**/

class Product extends Common{
    //列表
    public function index(Request $request){
    	//用户信息
    	$user = $this->getUser();

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//获取列表
		$data = Db::table('product')->where('state', 1)->orderBy('id','desc')->pages('', 12);

		//更新参数
		foreach ($data['lists'] as $key => $value) {
			//用户价格折扣
			$data['lists'][$key]['price'] = $data['lists'][$key]['selling'];
			//用户喜欢状态
			$data['lists'][$key]['like'] = 0;
			//如果登录
			if($user){
				//用户价格折扣
				$data['lists'][$key]['price'] = $this->getProductPrice($data['lists'][$key]['selling'], $user_discount);
				//用户喜欢状态
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $data['lists'][$key]['id'])->where('state',1)->item();
				if($user_like){
					$data['lists'][$key]['like'] = 1;
				}
			}
		}

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '商品 - '.$site['name'];
		$data['page_keywords'] = '商品,'.$site['name'];
		$data['page_description'] = '';

		//返回模板
		return view('frontend.product.index', $data);
	}

	//分类列表
	public function category(Request $request){
    	//获取参数
    	$id = (int)$request->id;

    	//用户信息
    	$user = $this->getUser();

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

		//获取列表
		$data = Db::table('product')->where($where)->orderBy('id','desc')->pages('', 12);

		//更新参数
		foreach ($data['lists'] as $key => $value) {
			//用户价格折扣
			$data['lists'][$key]['price'] = $data['lists'][$key]['selling'];
			//用户喜欢状态
			$data['lists'][$key]['like'] = 0;
			//如果登录
			if($user){
				//用户价格折扣
				$data['lists'][$key]['price'] = $this->getProductPrice($data['lists'][$key]['selling'], $user_discount);
				//用户喜欢状态
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $data['lists'][$key]['id'])->where('state',1)->item();
				if($user_like){
					$data['lists'][$key]['like'] = 1;
				}
			}
		}

		//当前分类
		$data['category'] = Db::table('product_category')->where('id',$id)->where('state',1)->select(['id','name','seo_title','seo_keywords','seo_description'])->item();

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = $data['category']['seo_title']?$data['category']['seo_title']:$data['category']['name'].' - 商品 - '.$site['name'];
		$data['page_keywords'] = $data['category']['seo_keywords'];
		$data['page_description'] = $data['category']['seo_description'];
        
        //返回模板
		return view('frontend.product.index', $data);
	}

	//详情
	public function show(Request $request){
		//获取参数
    	$id = (int)$request->id;
    	
    	//用户信息
    	$user = $this->getUser();

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		//获取详情
		$data['product'] = Db::table('product')->where($where)->orderBy('id','desc')->item();

		//格式化参数
		$data['product']['description'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/star-none.png' ), $data['product']['description'] );

		//更新参数
		if($user){
			$data['product']['price'] = $this->getProductPrice($data['product']['selling'], $user_discount);
		}
		isset ($data['product']['price']) && $data['product']['price'] = $this->getProductPrice($data['product']['selling'], $user_discount);

		//当前分类
		$data['category'] = Db::table('product_category')->where('id',$data['product']['category_id'])->where('state',1)->select(['id','name'])->item();

		//商品图片
		$data['pictures'] = DB::table('product_picture')->select(['id','picture','position'])->where('product_id',$data['product']['id'])->lists();

		//商品规格
		$data['specifications'] = Db::table('product_specification')->where('product_id',$data['product']['id'])->lists();
		foreach ($data['specifications'] as $key => $value) {
			$price  = $this->getProductPrice($data['specifications'][$key]['selling'], $user_discount);
			$data['specifications'][$key]['price'] = $price;
		}

		//更新规格参数
		if($data['specifications']){
			$market_min = Db::table('product_specification')->where('product_id',$data['product']['id'])->where('quantity', '>', 1)->min('market');
			$market_max = Db::table('product_specification')->where('product_id',$data['product']['id'])->where('quantity', '>', 1)->max('market');
			$selling_min = Db::table('product_specification')->where('product_id',$data['product']['id'])->where('quantity', '>', 1)->min('selling');
			$selling_max = Db::table('product_specification')->where('product_id',$data['product']['id'])->where('quantity', '>', 1)->max('selling');
			$price_min = $this->getProductPrice($selling_min, $user_discount);
			$price_max = $this->getProductPrice($selling_max, $user_discount);
			if($market_min != $market_max){
				$data['product']['market'] = $market_min.' - '.$market_max;
			}else{
				$data['product']['market'] = $market_min;
			}
			if($selling_min != $selling_max){
				$data['product']['selling'] = $selling_min.' - '.$selling_max;
			}else{
				$data['product']['selling'] = $selling_min;
			}
			if($price_min != $price_max){
				$data['product']['price'] = $price_min.' - '.$price_max;
			}else{
				$data['product']['price'] = $price_min;
			}
		}

		//喜欢状态&用户等级
		$data['like'] = 0;
		if($user){
			//用户等级
			$user_level = $user['level'];
            $data['level'] = Db::table('user_level')->select(['name'])->where('id', $user_level)->item();

            //喜欢状态
            $user_id = $user['id'];
			$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $id)->where('state',1)->item();
			if($user_like){
				$data['like'] = 1;
			}
        }

        //SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = $data['product']['seo_title']?$data['product']['seo_title']:$data['product']['name'].' - 商品 - '.$site['name'];
		$data['page_keywords'] = $data['product']['seo_keywords'];
		$data['page_description'] = $data['product']['seo_description'];
		
		//访问量+1
		DB::table('product')->where('id', $id)->increment('visit', 1);
        
        //返回模板
		return view('frontend.product.show', $data);
	}
}
