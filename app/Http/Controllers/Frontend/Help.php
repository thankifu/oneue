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
 * 帮助
**/

class Help extends Common
{
	//详情
	public function show(Request $request){

		//获取参数
    	$id = (int)$request->id;

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		//获取详情
		$help = Db::table('help')->where($where)->orderBy('id','desc')->item();

		//没有数据
		if(!$help){
    		return redirect('/');
    	}

    	//格式化数据
		$help['content'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/star-none.png' ), $help['content'] );

		//定义返回数据
		$data['help'] = $help;
		$data['page']['title'] = $help['seo_title']?$help['seo_title']:$help['title'].' - 帮助 - '.$site['name'];
		$data['page']['keywords'] = $help['seo_keywords'];
		$data['page']['description'] = $help['seo_description'];

		//访问量+1
		DB::table('help')->increment('visit', 1);
        
        //返回数据
		return view('frontend.help.show', $data);

	}

}
