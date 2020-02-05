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

class Home extends Common
{
    //
    public function index(Request $request){
    	$user = $this->getUser();
    	$discount = $this->getUserDiscount();

    	$data['slides'] = Db::table('slide')->select(['id','title','subtitle','picture','url','position'])->where('state', 1)->orderBy('position','asc')->orderBy('id','asc')->lists();
    	foreach ($data['slides'] as $key => $value) {
			$data['slides'][$key]['picture'] = config('app.url').$data['slides'][$key]['picture'];
		}

		$data['products'] = Db::table('product')->select(['id','name','market','selling','picture'])->where('state', 1)->orderBy('id','desc')->limit('6')->lists();
		foreach ($data['products'] as $key => $value) {
			
			$data['products'][$key]['picture'] = config('app.url').$data['products'][$key]['picture'];

			//用户价格折扣
			$data['products'][$key]['price'] = $data['products'][$key]['selling'];

			$data['products'][$key]['like'] = 0;
			if($user){
				//用户价格折扣
				$data['products'][$key]['price'] = $this->getProductPrice($data['products'][$key]['selling'], $discount);
				//用户喜欢状态
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('product_id', $data['products'][$key]['id'])->where('state',1)->item();
				if($user_like){
					$data['products'][$key]['like'] = 1;
				}
			}
		}
		
        $data['articles'] = Db::table('article')->select(['id','title','content','picture'])->where('state', 1)->orderBy('id','desc')->limit('6')->lists();
        foreach ($data['articles'] as $key => $value) {
			$data['articles'][$key]['picture'] = config('app.url').$data['articles'][$key]['picture'];
			$data['articles'][$key]['content'] = str_limit(strip_tags($data['articles'][$key]['content']), $limit = 120, $end = '...');

			//用户喜欢状态
			$data['articles'][$key]['like'] = 0;
			if($user){
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $data['articles'][$key]['id'])->where('state',1)->item();
				if($user_like){
					$data['articles'][$key]['like'] = 1;
				}
			}
		}

        $site = $this->getSeting('site')['value'];
		$data['page_title'] = $site['seo_title']?$site['seo_title']:$site['name'].' - '.$site['title'];
		$data['page_keywords'] = $site['seo_keywords'];
		$data['page_description'] = $site['seo_description'];

		unset($site['seo_title']);
		unset($site['seo_keywords']);
		unset($site['seo_description']);
		$data['site'] = $site;
		
        
		$this->returnMessage(200, '成功', $data);
	}

}
