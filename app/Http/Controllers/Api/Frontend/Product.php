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

namespace App\Http\Controllers\Api\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Common
{
    //
    public function index(Request $request){
    	$user = $this->getUser();
    	$discount = $this->getUserDiscount();
    	
		$data = Db::table('product')->select(['id','name','market','selling','picture'])->where('state', 1)->orderBy('id','desc')->pages('', 12);

		foreach ($data['lists'] as $key => $value) {
			$data['lists'][$key]['picture'] = config('app.url').$data['lists'][$key]['picture'];

			//用户价格折扣
			$data['lists'][$key]['price'] = $data['lists'][$key]['selling'];
			//用户喜欢状态
			$data['lists'][$key]['like'] = 0;
			//如果登录
			if($user){
				//用户价格折扣
				$data['lists'][$key]['price'] = $this->getProductPrice($data['lists'][$key]['selling'], $discount);
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

		$this->returnMessage(200, '成功', $data);
	}

	public function category(Request $request){
    	$id = (int)$request->id;
    	
    	$user = $this->getUser();

    	$discount = $this->getUserDiscount();

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

		$data = Db::table('product')->where($where)->orderBy('id','desc')->pages('', 12);

		foreach ($data['lists'] as $key => $value) {
			//用户价格折扣
			$data['lists'][$key]['price'] = $data['lists'][$key]['selling'];
			//用户喜欢状态
			$data['lists'][$key]['like'] = 0;
			//如果登录
			if($user){
				//用户价格折扣
				$data['lists'][$key]['price'] = $this->getProductPrice($data['lists'][$key]['selling'], $discount);
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
        
		$this->returnMessage(200, '成功', $data);
	}

	public function show(Request $request){
    	$id = (int)$request->id;

    	$user = $this->getUser();

    	$discount = $this->getUserDiscount();

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		$data['product'] = Db::table('product')->select(['id','name','description','market','selling','picture','quantity','volume','visit','category_id','seo_title','seo_keywords','seo_description','seo_keywords'])->where($where)->orderBy('id','desc')->item();
		$data['product']['description'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/star-none.png' ), $data['product']['description'] );
		$data['product']['picture'] = config('app.url').$data['product']['picture'];

		$data['product']['price'] = $data['product']['selling'];

		if($user){
			$data['product']['price'] = $this->getProductPrice($data['product']['selling'], $discount);
		}

		//当前分类
		$data['product']['category'] = Db::table('product_category')->where('id',$data['product']['category_id'])->where('state',1)->select(['id','name'])->item();

		//图片
		$data['product']['pictures'] = DB::table('product_picture')->select(['id','picture','position'])->where('product_id',$data['product']['id'])->lists();
		foreach ($data['product']['pictures'] as $key => $value) {
			$data['product']['pictures'][$key]['picture'] = config('app.url').$data['product']['pictures'][$key]['picture'];
		}

		//规格
		$data['product']['specifications'] = Db::table('product_specification')->where('product_id',$data['product']['id'])->lists();
		foreach ($data['product']['specifications'] as $key => $value) {
			$data['product']['specifications'][$key]['price'] = $data['product']['specifications'][$key]['selling'];

			//有图片才重新赋值
			if($data['product']['specifications'][$key]['picture']){
				$data['product']['specifications'][$key]['picture'] = config('app.url').$data['product']['specifications'][$key]['picture'];
			}
			
			if($user){
				$data['product']['specifications'][$key]['price'] = $this->getProductPrice($data['product']['specifications'][$key]['selling'], $discount);
			}
		}

		if($data['product']['specifications']){
			$market_min = Db::table('product_specification')->where('product_id',$data['product']['id'])->where('quantity', '>', 1)->min('market');
			$market_max = Db::table('product_specification')->where('product_id',$data['product']['id'])->where('quantity', '>', 1)->max('market');
			$selling_min = Db::table('product_specification')->where('product_id',$data['product']['id'])->where('quantity', '>', 1)->min('selling');
			$selling_max = Db::table('product_specification')->where('product_id',$data['product']['id'])->where('quantity', '>', 1)->max('selling');
			$price_min = $this->getProductPrice($selling_min, $discount);
			$price_max = $this->getProductPrice($selling_max, $discount);
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

		//喜欢状态
		$data['like'] = 0;
		if($user){
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
		
		DB::table('product')->where('id', $id)->increment('visit', 1);
        
		$this->returnMessage(200, '成功', $data);
	}

}
