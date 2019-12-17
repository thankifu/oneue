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

class Home extends Common
{
    //
    public function index(Request $request){
    	$discount = $this->getUserDiscount();

		$data['product'] = Db::table('product')->orderBy('id','desc')->limit('6')->lists();
		foreach ($data['product'] as $key => $value) {
			$price  = $this->getProductPrice($data['product'][$key]['selling'], $discount);
			$data['product'][$key]['price'] = $price;
		}
		
        $data['article'] = Db::table('article')->orderBy('id','desc')->limit('6')->lists();
        
		return view('frontend.home.index', $data);
	}

}