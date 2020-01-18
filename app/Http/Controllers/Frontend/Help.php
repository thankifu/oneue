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

class Help extends Common
{

	public function show(Request $request){
    	$id = (int)$request->id;

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		$data['help'] = Db::table('help')->where($where)->orderBy('id','desc')->item();
		$data['help']['content'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/star-none.png' ), $data['help']['content'] );

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = $data['help']['seo_title']?$data['help']['seo_title']:$data['help']['title'].' - 帮助 - '.$site['name'];
		$data['page_keywords'] = $data['help']['seo_keywords'];
		$data['page_description'] = $data['help']['seo_description'];

		DB::table('help')->increment('visit', 1);
        
		return view('frontend.help.show', $data);
	}

}
