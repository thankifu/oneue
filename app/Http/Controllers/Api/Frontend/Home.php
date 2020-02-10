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
 * 首页
**/

class Home extends Common{
    
    //首页
    public function index(Request $request){

    	//用户信息
    	$user = $this->getUser();

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//获取轮播
    	$slides = Db::table('slide')->select(['id','title','subtitle','picture','url','position'])->where('state', 1)->orderBy('position','asc')->orderBy('id','asc')->lists();
    	foreach ($slides as $key => $value) {
			$slides[$key]['picture'] = config('app.url').$slides[$key]['picture'];
		}

		//获取商品
		$products = Db::table('product')->select(['id','name','market','selling','picture'])->where('state', 1)->orderBy('id','desc')->limit('6')->lists();
		foreach ($products as $key => $value) {
			
			$products[$key]['picture'] = config('app.url').$products[$key]['picture'];

			//用户价格折扣
			$products[$key]['price'] = $products[$key]['selling'];

			$products[$key]['like'] = 0;
			if($user){
				//用户价格折扣
				$products[$key]['price'] = $this->getProductPrice($products[$key]['selling'], $user_discount);
				//用户喜欢状态
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $products[$key]['id'])->where('state',1)->item();
				if($user_like){
					$products[$key]['like'] = 1;
				}
			}
		}
		
		//获取文章
        $articles = Db::table('article')->select(['id','title','content','picture'])->where('state', 1)->orderBy('id','desc')->limit('6')->lists();
        foreach ($articles as $key => $value) {
			$articles[$key]['picture'] = config('app.url').$articles[$key]['picture'];
			$articles[$key]['content'] = str_limit(strip_tags($articles[$key]['content']), $limit = 120, $end = '...');

			//用户喜欢状态
			$articles[$key]['like'] = 0;
			if($user){
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $articles[$key]['id'])->where('state',1)->item();
				if($user_like){
					$articles[$key]['like'] = 1;
				}
			}
		}

        //定义返回数据
        $data['slides'] = $slides;
        $data['products'] = $products;
		$data['articles'] = $articles;
		$data['page']['title'] = $site['seo_title']?$site['seo_title']:$site['name'].' - '.$site['title'];
		$data['page']['keywords'] = $site['seo_keywords'];
		$data['page']['description'] = $site['seo_description'];
		$data['site'] = $site;
        
        //返回数据
		$this->returnMessage(200, '成功', $data);

	}

}
