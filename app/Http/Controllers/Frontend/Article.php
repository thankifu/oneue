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

class Article extends Common
{
    //列表
    public function index(Request $request){

    	//用户信息
    	$user = $this->getUser();

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//获取列表
		$articles = Db::table('article')->where('state', 1)->orderBy('id','desc')->pages('', 12);

    	//获取喜欢的列表
    	if($user){
    		$user_id = $user['id'];
    		$user_likes = Db::table('user_like')->where('user_id', $user_id)->where('state',1)->where('article_id','>',0)->cates('article_id');
		}

		//格式化数据
		if($articles['lists']){
			foreach ($articles['lists'] as $key => $value) {
				$articles['lists'][$key]['like'] = isset($user_likes[$value['id']])?'1':'0';
			}
		}

		//定义返回数据
		$data['articles'] = $articles['lists'];
		$data['page']['title'] = '文章 - '.$site['name'];
		$data['page']['keywords'] = '文章,'.$site['name'];
		$data['page']['description'] = '';
		$data['page']['pagination'] = $articles['links'];

		//返回数据
		return view('frontend.article.index', $data);
	}

	//分类列表
	public function category(Request $request){
    	
    	//获取参数
    	$id = (int)$request->id;
    	
    	//用户信息
    	$user = $this->getUser();

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

		//获取列表
		$articles = Db::table('article')->where($where)->orderBy('id','desc')->pages('', 12);

		//没有数据
		if(!$articles['lists']){
    		return redirect('/article');
    	}

    	//获取当前分类
		$category = Db::table('article_category')->where('id',$id)->where('state',1)->select(['id','name','seo_title','seo_keywords','seo_description'])->item();

    	//获取喜欢的列表
    	if($user){
    		$user_id = $user['id'];
    		$user_likes = Db::table('user_like')->where('user_id', $user_id)->where('state',1)->where('article_id','>',0)->cates('article_id');
		}

		//格式化数据
		foreach ($articles['lists'] as $key => $value) {
			$articles['lists'][$key]['like'] = isset($user_likes[$value['id']])?'1':'0';
		}

		//定义返回数据
		$data['articles'] = $articles['lists'];
		$data['category'] = $category;
		$data['page']['title'] = $category['seo_title']?$category['seo_title']:$category['name'].' - 文章 - '.$site['name'];
		$data['page']['keywords'] = $category['seo_keywords'];
		$data['page']['description'] = $category['seo_description'];
		$data['page']['pagination'] = $articles['links'];
        
        //返回数据
		return view('frontend.article.index', $data);

	}

	//详情
	public function show(Request $request){

    	//获取参数
    	$id = (int)$request->id;

    	//用户信息
    	$user = $this->getUser();

    	//站点信息
    	$site = $this->getSeting('site')['value'];

    	//查询参数
    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		//获取详情
		$article = Db::table('article')->where($where)->orderBy('id','desc')->item();

		//没有数据
		if(!$article){
    		return redirect('/article');
    	}

		//当前分类
		$category = Db::table('article_category')->where('id',$article['category_id'])->where('state',1)->select(['id','name'])->item();

        //喜欢状态
		$like = 0;
		if($user){
            $user_id = $user['id'];
			$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $id)->where('state',1)->item();
			if($user_like){
				$like = 1;
			}
        }

        //格式化参数
		$article['content'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}">', '/images/star-none.png' ), $article['content'] );
		if($category){
			$article['category_name'] = $category['name'];
		}

		//定义返回数据
		$data['article'] = $article;
		$data['article']['like'] = $like;
		$data['page']['title'] = $data['article']['seo_title']?$data['article']['seo_title']:$data['article']['title'].' - 文章 - '.$site['name'];
		$data['page']['keywords'] = $data['article']['seo_keywords'];
		$data['page']['description'] = $data['article']['seo_description'];

		//访问量+1
		DB::table('article')->where('id', $id)->increment('visit', 1);
        
        //返回数据
		return view('frontend.article.show', $data);
	}

}
