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

class Search extends Common
{
    //
    public function index(Request $request){

    	$keyword = trim($request->keyword);
		
		$where = [];
		$where[] = ['state', '=', 1];
		if($keyword){
			if($request->path() == 'search' || $request->path() == 'search/product'){
				$where[] = ['name', 'like', '%'.$keyword.'%'];
    		}else{
    			$where[] = ['title', 'like', '%'.$keyword.'%'];
    		}
		}

		$appends = [];
		if($keyword){
			$appends['keyword'] = $keyword;
		}

		$user_id = 0;
    	if(auth()->user()){
    		$user_id = auth()->user()->id;
    	}

		if($request->path() == 'search' || $request->path() == 'search/product'){
			$discount = $this->getUserDiscount();

			$data = Db::table('product')->where($where)->orderBy('id','desc')->pages('', 12);

			foreach ($data['lists'] as $key => $value) {
				//用户价格折扣
				$price  = $this->getProductPrice($data['lists'][$key]['selling'], $discount);
				$data['lists'][$key]['price'] = $price;

				//用户喜欢状态
				$like = 0;
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $data['lists'][$key]['id'])->where('state',1)->item();
				if($user_like){
					$like = 1;
				}
				$data['lists'][$key]['like'] = $like;
			}
		}else{
			$data = Db::table('article')->where($where)->orderBy('id','desc')->pages('', 12);
			foreach ($data['lists'] as $key => $value) {
				//用户喜欢状态
				$like = 0;
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $data['lists'][$key]['id'])->where('state',1)->item();
				if($user_like){
					$like = 1;
				}
				$data['lists'][$key]['like'] = $like;
			}
		}

    	

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '商品 - '.$site['name'];
		$data['page_keywords'] = '商品,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.search.index', $data);
	}
}
