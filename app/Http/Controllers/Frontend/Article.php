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

class Article extends Common
{
    //
    public function index(Request $request){
		$data = Db::table('article')->where('state', 1)->orderBy('id','desc')->pages('', 12);
		return view('frontend.article.index', $data);
	}

	public function list(Request $request){
    	$id = (int)$request->id;

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

		$data = Db::table('article')->where($where)->orderBy('id','desc')->pages('', 12);
		//当前分类
		$data['category'] = Db::table('article_category')->where('id',$id)->where('state',1)->select(['id','name'])->item();
        
		return view('frontend.article.index', $data);
	}

	public function item(Request $request){
    	$id = (int)$request->id;

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		$data['article'] = Db::table('article')->where($where)->orderBy('id','desc')->item();
		$data['article']['content'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/none.png' ), $data['article']['content'] );

		//当前分类
		$data['category'] = Db::table('article_category')->where('id',$data['article']['category_id'])->where('state',1)->select(['id','name'])->item();

		DB::table('article')->increment('visit', 1);
        
		return view('frontend.article.item', $data);
	}

}
