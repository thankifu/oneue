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

class Article extends Common
{
    //
    public function index(Request $request){
    	$user_id = 0;
    	if(auth()->user()){
    		$user_id = auth()->user()->id;
    	}

		$data = Db::table('article')->where('state', 1)->orderBy('id','desc')->pages('', 12);

		foreach ($data['lists'] as $key => $value) {
			//用户喜欢状态
			$like = 0;
			$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $data['lists'][$key]['id'])->where('state',1)->item();
			if($user_like){
				$like = 1;
			}
			$data['lists'][$key]['like'] = $like;
		}

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '文章 - '.$site['name'];
		$data['page_keywords'] = '文章,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.article.index', $data);
	}

	public function category(Request $request){
    	$id = (int)$request->id;
    	$user_id = 0;
    	if(auth()->user()){
    		$user_id = auth()->user()->id;
    	}

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

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

		//当前分类
		$data['category'] = Db::table('article_category')->where('id',$id)->where('state',1)->select(['id','name','seo_title','seo_keywords','seo_description'])->item();

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = $data['category']['seo_title']?$data['category']['seo_title']:$data['category']['name'].' - 文章 - '.$site['name'];
		$data['page_keywords'] = $data['category']['seo_keywords'];
		$data['page_description'] = $data['category']['seo_description'];
        
		return view('frontend.article.index', $data);
	}

	public function show(Request $request){
    	$id = (int)$request->id;

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		$data['article'] = Db::table('article')->where($where)->orderBy('id','desc')->item();
		$data['article']['content'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}>', '/images/star-none.png' ), $data['article']['content'] );

		//当前分类
		$data['category'] = Db::table('article_category')->where('id',$data['article']['category_id'])->where('state',1)->select(['id','name'])->item();

		//喜欢状态
		$data['like'] = 0;
		if(auth()->user()){
            //喜欢状态
            $user_id = auth()->user()->id;
			$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $id)->where('state',1)->item();
			if($user_like){
				$data['like'] = 1;
			}
        }

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = $data['article']['seo_title']?$data['article']['seo_title']:$data['article']['title'].' - 文章 - '.$site['name'];
		$data['page_keywords'] = $data['article']['seo_keywords'];
		$data['page_description'] = $data['article']['seo_description'];

		DB::table('article')->where('id', $id)->increment('visit', 1);
        
		return view('frontend.article.show', $data);
	}

}
