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
 * 首页
**/

class Home extends Common
{
	//首页
    public function index(Request $request){
    	
    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//获取轮播列表
    	$slides = Db::table('slide')->where('state', 1)->orderBy('position','asc')->orderBy('id','asc')->lists();

    	//获取商品列表
		$products = Db::table('product')->where('state', 1)->orderBy('id','desc')->limit('6')->lists();
		if($products){
			foreach ($products as $key => $value) {
				$price  = $this->getProductPrice($value['selling'], $user_discount);
				$products[$key]['price'] = $price;
			}
		}
		
		//获取文章列表
        $articles = Db::table('article')->where('state', 1)->orderBy('id','desc')->limit('6')->lists();

        //定义返回数据
        $data['slides'] = $slides;
        $data['products'] = $products;
        $data['articles'] = $articles;
		$data['page']['title'] = $site['seo_title']?$site['seo_title']:$site['name'].' - '.$site['title'];
		$data['page']['keywords'] = $site['seo_keywords'];
		$data['page']['description'] = $site['seo_description'];
        
        //返回数据
		return view('frontend.home.index', $data);

	}
}
