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

/**
 * 商品
**/

class Product extends Common{
    
    //列表
    public function index(Request $request){
    	
    	//用户信息
    	$user = $this->getUser();

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//获取列表
		$page = Db::table('product')->select(['id','name','market','selling','picture'])->where('state', 1)->orderBy('id','desc')->page(10);
		$products = $page->list;

		//格式化列表数据
		foreach ($products as $key => $value) {
			$products[$key]['picture'] = config('app.url').$products[$key]['picture'];
			$products[$key]['price'] = $products[$key]['selling'];
			$products[$key]['like'] = 0;
			if($user){
				$products[$key]['price'] = $this->getProductPrice($products[$key]['selling'], $user_discount);
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $products[$key]['id'])->where('state',1)->item();
				if($user_like){
					$products[$key]['like'] = 1;
				}
			}
		}

		//定义返回数据
		$data['products'] = $products;
		$data['page']['title'] = '商品 - '.$site['name'];
		$data['page']['keywords'] = '商品,'.$site['name'];
		$data['page']['description'] = '';
		$data['page']['pagination'] = $page;

		//返回数据
		$this->returnMessage(200, '成功', $data);

	}

	//分类列表
	public function category(Request $request){

    	//获取参数
    	$id = (int)$request->id;
    	
    	//用户信息
    	$user = $this->getUser();

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

		//获取列表
		$page = Db::table('product')->select(['id','name','market','selling','picture'])->where($where)->orderBy('id','desc')->page(10);
		$products = $page->list;

		//格式化列表数据
		foreach ($products as $key => $value) {
			$products[$key]['picture'] = config('app.url').$products[$key]['picture'];
			$products[$key]['price'] = $products[$key]['selling'];
			$products[$key]['like'] = 0;
			if($user){
				$products[$key]['price'] = $this->getProductPrice($products[$key]['selling'], $user_discount);
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $products[$key]['id'])->where('state',1)->item();
				if($user_like){
					$products[$key]['like'] = 1;
				}
			}
		}

		//当前分类
		$category = Db::table('product_category')->where('id',$id)->where('state',1)->select(['id','name','seo_title','seo_keywords','seo_description'])->item();

		//定义返回数据
		$data['products'] = $products;
		$data['products']['category'] = $category;
		$data['page']['title'] = $products['category']['seo_title'] ? $products['category']['seo_title'] : $products['category']['name'].' - 商品 - '.$site['name'];
		$data['page']['keywords'] = $products['category']['seo_keywords'];
		$data['page']['description'] = $products['category']['seo_description'];
		$data['page']['pagination'] = $page;
        
        //返回数据
		$this->returnMessage(200, '成功', $data);

	}

	//详情
	public function show(Request $request){

    	//获取参数
    	$id = (int)$request->id;

    	//用户信息
    	$user = $this->getUser();

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		//获取详情
		$product = Db::table('product')->select(['id','name','description','market','selling','picture','quantity','volume','visit','category_id','seo_title','seo_keywords','seo_description','seo_keywords'])->where($where)->orderBy('id','desc')->item();

		//格式化详情数据
		$product['description'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/star-none.png' ), $product['description'] );
		$product['picture'] = config('app.url').$product['picture'];
		$product['price'] = $product['selling'];
		if($user){
			$product['price'] = $this->getProductPrice($product['selling'], $user_discount);
		}

		//当前分类
		$product['category'] = Db::table('product_category')->where('id',$product['category_id'])->where('state',1)->select(['id','name'])->item();

		//图片
		$product['pictures'] = DB::table('product_picture')->select(['id','picture','position'])->where('product_id',$product['id'])->lists();
		foreach ($product['pictures'] as $key => $value) {
			$product['pictures'][$key]['picture'] = config('app.url').$product['pictures'][$key]['picture'];
		}

		//规格
		$product['specifications'] = Db::table('product_specification')->where('product_id',$product['id'])->lists();
		foreach ($product['specifications'] as $key => $value) {
			$product['specifications'][$key]['price'] = $product['specifications'][$key]['selling'];

			//有图片才重新赋值
			if($product['specifications'][$key]['picture']){
				$product['specifications'][$key]['picture'] = config('app.url').$product['specifications'][$key]['picture'];
			}
			
			if($user){
				$product['specifications'][$key]['price'] = $this->getProductPrice($product['specifications'][$key]['selling'], $user_discount);
			}
		}

		if($product['specifications']){
			$market_min = Db::table('product_specification')->where('product_id',$product['id'])->where('quantity', '>', 1)->min('market');
			$market_max = Db::table('product_specification')->where('product_id',$product['id'])->where('quantity', '>', 1)->max('market');
			$selling_min = Db::table('product_specification')->where('product_id',$product['id'])->where('quantity', '>', 1)->min('selling');
			$selling_max = Db::table('product_specification')->where('product_id',$product['id'])->where('quantity', '>', 1)->max('selling');
			$price_min = $this->getProductPrice($selling_min, $user_discount);
			$price_max = $this->getProductPrice($selling_max, $user_discount);
			if($market_min != $market_max){
				$product['market'] = $market_min.' - '.$market_max;
			}else{
				$product['market'] = $market_min;
			}
			if($selling_min != $selling_max){
				$product['selling'] = $selling_min.' - '.$selling_max;
			}else{
				$product['selling'] = $selling_min;
			}
			if($price_min != $price_max){
				$product['price'] = $price_min.' - '.$price_max;
			}else{
				$product['price'] = $price_min;
			}
		}

		//喜欢状态
		$product['like'] = 0;
		if($user){
            $user_id = $user['id'];
			$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $id)->where('state',1)->item();
			if($user_like){
				$product['like'] = 1;
			}
        }
		
		//访问量+1
		DB::table('product')->where('id', $id)->increment('visit', 1);

		//定义返回数据
        $data['product'] = $product;
		$data['page']['title'] = $product['seo_title'] ? $product['seo_title'] : $product['name'].' - 商品 - '.$site['name'];
		$data['page']['keywords'] = $product['seo_keywords'];
		$data['page']['description'] = $product['seo_description'];
        
        //返回数据
		$this->returnMessage(200, '成功', $data);

	}

}
