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
use Illuminate\Support\Facades\DB;

/**
 * 商品
**/

class Product extends Common
{
    //列表
    public function index(Request $request){
    	
    	//用户信息
    	$user = $this->getUser();

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//获取列表
		$products = Db::table('product')->where('state', 1)->orderBy('id','desc')->pages('', 12);

		//获取喜欢的列表
    	if($user){
    		$user_id = $user['id'];
    		$user_likes = Db::table('user_like')->where('user_id', $user_id)->where('state',1)->where('product_id','>',0)->cates('product_id');
		}

		//格式化数据
		if($products['lists']){
			foreach ($products['lists'] as $key => $value) {
				$products['lists'][$key]['like'] = isset($user_likes[$value['id']])?'1':'0';
				$products['lists'][$key]['price'] = $value['selling'];
				if($user){
					$data['lists'][$key]['price'] = $this->getProductPrice($value['selling'], $user_discount);
				}
			}
		}

		//定义返回数据
		$data['products'] = $products['lists'];
		$data['page']['title'] = '商品 - '.$site['name'];
		$data['page']['keywords'] = '商品,'.$site['name'];
		$data['page']['description'] = '';
		$data['page']['pagination'] = $products['links'];

		//返回数据
		return view('frontend.product.index', $data);

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
		$products = Db::table('product')->where($where)->orderBy('id','desc')->pages('', 12);

		//没有数据
		if(!$products['lists']){
    		return redirect('/product');
    	}

    	//获取当前分类
		$category = Db::table('product_category')->where('id',$id)->where('state',1)->select(['id','name','seo_title','seo_keywords','seo_description'])->item();

		//获取喜欢的列表
    	if($user){
    		$user_id = $user['id'];
    		$user_likes = Db::table('user_like')->where('user_id', $user_id)->where('state',1)->where('product_id','>',0)->cates('product_id');
		}

		//格式化数据
		if($products['lists']){
			foreach ($products['lists'] as $key => $value) {
				$products['lists'][$key]['like'] = isset($user_likes[$value['id']])?'1':'0';
				$products['lists'][$key]['price'] = $value['selling'];
				if($user){
					$data['lists'][$key]['price'] = $this->getProductPrice($value['selling'], $user_discount);
				}
			}
		}

		//定义返回数据
		$data['products'] = $products['lists'];
		$data['category'] = $category;
		$data['page']['title'] = $category['seo_title']?$category['seo_title']:$category['name'].' - 商品 - '.$site['name'];
		$data['page']['keywords'] = $category['seo_keywords'];
		$data['page']['description'] = $category['seo_description'];
		$data['page']['pagination'] = $products['links'];
        
        //返回数据
		return view('frontend.product.index', $data);

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
		$product = Db::table('product')->where($where)->orderBy('id','desc')->item();

		//没有数据
		if(!$product){
			return redirect('/product');
		}

		//当前分类
		$category = Db::table('product_category')->where('id',$product['category_id'])->where('state',1)->select(['id','name'])->item();

		//图片列表
		$pictures = DB::table('product_picture')->select(['id','picture','position'])->where('product_id',$id)->lists();

		//规格列表
		$specifications = Db::table('product_specification')->where('product_id',$id)->lists();

		//格式化参数
		$product['description'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/star-none.png' ), $product['description'] );
		$product['price'] = $product['selling'];
		if($user){
			$product['price'] = $this->getProductPrice($product['selling'], $user_discount);
		}
		if($category){
			$product['category_name'] = $category['name'];
		}
		if($specifications){
			foreach ($specifications as $key => $value) {
				$specifications[$key]['price'] = $this->getProductPrice($value['selling'], $user_discount);
			}
			$market_min = Db::table('product_specification')->where('product_id',$id)->where('quantity', '>', 1)->min('market');
			$market_max = Db::table('product_specification')->where('product_id',$id)->where('quantity', '>', 1)->max('market');
			$selling_min = Db::table('product_specification')->where('product_id',$id)->where('quantity', '>', 1)->min('selling');
			$selling_max = Db::table('product_specification')->where('product_id',$id)->where('quantity', '>', 1)->max('selling');
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

		//喜欢状态&用户等级
		$like = 0;
		if($user){
			//用户等级
			$user_level = $user['level'];
            $data['user']['level_name'] = Db::table('user_level')->select(['name'])->where('id', $user_level)->item()['name'];

            //喜欢状态
            $user_id = $user['id'];
			$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $id)->where('state',1)->item();
			if($user_like){
				$like = 1;
			}
        }

        //访问量+1
		DB::table('product')->where('id', $id)->increment('visit', 1);

        //定义返回数据
		$data['product'] = $product;
		$data['product']['like'] = $like;
		$data['product']['pictures'] = $pictures;
		$data['product']['specifications'] = $specifications;
		$data['page']['title'] = $product['seo_title']?$product['seo_title']:$product['name'].' - 商品 - '.$site['name'];
		$data['page']['keywords'] = $product['seo_keywords'];
		$data['page']['description'] = $product['seo_description'];		
        
        //返回数据
		return view('frontend.product.show', $data);

	}
}
