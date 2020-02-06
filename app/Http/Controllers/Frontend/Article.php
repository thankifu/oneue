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
 * 文章
**/

class Article extends Common{
    //列表
    public function index(Request $request){
    	//用户信息
    	$user = $this->getUser();

    	//获取列表
		$data = Db::table('article')->where('state', 1)->orderBy('id','desc')->pages('', 12);

		//更新参数
		foreach ($data['lists'] as $key => $value) {
			//喜欢状态
			$data['lists'][$key]['like'] = 0;
			if($user){
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $data['lists'][$key]['id'])->where('state',1)->item();
				if($user_like){
					$data['lists'][$key]['like'] = 1;
				}
			}
		}

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '文章 - '.$site['name'];
		$data['page_keywords'] = '文章,'.$site['name'];
		$data['page_description'] = '';

		//返回模板
		return view('frontend.article.index', $data);
	}

	//分类列表
	public function category(Request $request){
    	//获取参数
    	$id = (int)$request->id;
    	
    	//用户信息
    	$user = $this->getUser();

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

		//获取列表
		$data = Db::table('article')->where($where)->orderBy('id','desc')->pages('', 12);
		
		//更新参数
		foreach ($data['lists'] as $key => $value) {
			//喜欢状态
			$data['lists'][$key]['like'] = 0;
			if($user){
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $data['lists'][$key]['id'])->where('state',1)->item();
				if($user_like){
					$data['lists'][$key]['like'] = 1;
				}
			}
		}

		//当前分类
		$data['category'] = Db::table('article_category')->where('id',$id)->where('state',1)->select(['id','name','seo_title','seo_keywords','seo_description'])->item();

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = $data['category']['seo_title']?$data['category']['seo_title']:$data['category']['name'].' - 文章 - '.$site['name'];
		$data['page_keywords'] = $data['category']['seo_keywords'];
		$data['page_description'] = $data['category']['seo_description'];
        
        //返回模板
		return view('frontend.article.index', $data);
	}

	//详情
	public function show(Request $request){
    	//获取参数
    	$id = (int)$request->id;

    	//用户信息
    	$user = $this->getUser();

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		//获取详情
		$data['article'] = Db::table('article')->where($where)->orderBy('id','desc')->item();

		//格式化参数
		$data['article']['content'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}">', '/images/star-none.png' ), $data['article']['content'] );

		//当前分类
		$data['category'] = Db::table('article_category')->where('id',$data['article']['category_id'])->where('state',1)->select(['id','name'])->item();

        //喜欢状态
		$data['like'] = 0;
		if($user){
            $user_id = $user['id'];
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

		//访问量+1
		DB::table('article')->where('id', $id)->increment('visit', 1);
        
        //返回模板
		return view('frontend.article.show', $data);
	}

}
