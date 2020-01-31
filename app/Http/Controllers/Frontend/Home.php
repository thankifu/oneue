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

class Home extends Common
{
    //
    public function index(Request $request){
    	$discount = $this->getUserDiscount();

    	$data['slides'] = Db::table('slide')->where('state', 1)->orderBy('position','asc')->orderBy('id','asc')->lists();

		$data['products'] = Db::table('product')->where('state', 1)->orderBy('id','desc')->limit('6')->lists();
		foreach ($data['products'] as $key => $value) {
			$price  = $this->getProductPrice($data['products'][$key]['selling'], $discount);
			$data['products'][$key]['price'] = $price;
		}
		
        $data['articles'] = Db::table('article')->where('state', 1)->orderBy('id','desc')->limit('6')->lists();

        $site = $this->getSeting('site')['value'];
		$data['page_title'] = $site['seo_title']?$site['seo_title']:$site['name'].' - '.$site['title'];
		$data['page_keywords'] = $site['seo_keywords'];
		$data['page_description'] = $site['seo_description'];
        
		return view('frontend.home.index', $data);
	}

}
