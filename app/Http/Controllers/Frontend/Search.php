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

		if($request->path() == 'search' || $request->path() == 'search/product'){
			$discount = $this->getUserDiscount();

			$data = Db::table('product')->where($where)->orderBy('id','desc')->pages('', 12);

			foreach ($data['lists'] as $key => $value) {
				$price  = $this->getProductPrice($data['lists'][$key]['selling'], $discount);
				$data['lists'][$key]['price'] = $price;
			}
		}else{
			$data = Db::table('article')->where($where)->orderBy('id','desc')->pages('', 12);
		}

    	

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '商品 - '.$site['name'];
		$data['page_keywords'] = '商品,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.search.index', $data);
	}
}
