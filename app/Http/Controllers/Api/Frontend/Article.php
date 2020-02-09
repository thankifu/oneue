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

/**
 * 文章
**/

class Article extends Common{

    //列表
    public function index(Request $request){
    	
        //用户信息
        $user = $this->getUser();

        //站点信息
        $site = $this->getSeting('site')['value'];

        //获取列表
		$page = Db::table('article')->select(['id','title','content','picture','visit'])->where('state', 1)->orderBy('id','desc')->page(10);
		$articles = $page->list;

		//格式化列表数据
		foreach ($articles as $key => $value) {
			$articles[$key]['picture'] = config('app.url').$articles[$key]['picture'];
			$articles[$key]['content'] = str_limit(strip_tags($articles[$key]['content']), $limit = 120, $end = '...');
			$articles[$key]['like'] = 0;
			if($user){
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $articles[$key]['id'])->where('state',1)->item();
				if($user_like){
					$articles[$key]['like'] = 1;
				}
			}
		}

		//定义返回数据
		$data['articles'] = $articles;
		$data['page']['title'] = '文章 - '.$site['name'];
		$data['page']['keywords'] = '文章,'.$site['name'];
		$data['page']['description'] = '';
		$data['page']['pagination'] = $page;

		//返回数据
		$this->returnMessage(200, '成功', $data);

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
		$page = Db::table('article')->select(['id','title','content','picture','visit'])->where($where)->orderBy('id','desc')->page(10);
		$articles = $page->list;
		
		//格式化列表数据
		foreach ($articles as $key => $value) {
			$articles[$key]['picture'] = config('app.url').$articles[$key]['picture'];
			$articles[$key]['content'] = str_limit(strip_tags($articles[$key]['content']), $limit = 120, $end = '...');
			$articles[$key]['like'] = 0;
			if($user){
				$user_id = $user['id'];
				$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $articles[$key]['id'])->where('state',1)->item();
				if($user_like){
					$articles[$key]['like'] = 1;
				}
			}
		}

		//当前分类
		$articles['category'] = Db::table('article_category')->where('id',$id)->where('state',1)->select(['id','name','seo_title','seo_keywords','seo_description'])->item();

		//定义返回数据
		$data['articles'] = $articles;
		$data['page']['title'] = $articles['category']['seo_title']?$articles['category']['seo_title']:$articles['category']['name'].' - 文章 - '.$site['name'];
		$data['page']['keywords'] = $articles['category']['seo_keywords'];
		$data['page']['description'] = $articles['category']['seo_description'];
		$data['page']['pagination'] = $page;
        
        //返回数据
		$this->returnMessage(200, '成功', $data);

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
		$article = Db::table('article')->select(['id','title','content','picture','category_id','seo_title','seo_keywords','seo_description','created'])->where($where)->orderBy('id','desc')->item();
		
		//格式化详情数据
		$article['content'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s">', config('app.url').'${2}' ), $article['content'] );
		$article['created'] = date('Y-m-d H:i:s', $article['created']);

		//当前分类
		$article['category'] = Db::table('article_category')->where('id',$article['category_id'])->where('state',1)->select(['id','name'])->item();

		//喜欢状态
		$article['like'] = 0;
		if($user){
            $user_id = $user['id'];
			$user_like = Db::table('user_like')->where('user_id', $user_id)->where('article_id', $id)->where('state',1)->item();
			if($user_like){
				$article['like'] = 1;
			}
        }

        //访问量+1
		DB::table('article')->where('id', $id)->increment('visit', 1);

        //定义返回数据
        $data['article'] = $article;
		$data['page']['title'] = $article['seo_title'] ? $article['seo_title'] : $article['title'].' - 文章 - '.$site['name'];
		$data['page']['keywords'] = $article['seo_keywords'];
		$data['page']['description'] = $article['seo_description'];
        
        //返回数据
		$this->returnMessage(200, '成功', $data);

	}

}
