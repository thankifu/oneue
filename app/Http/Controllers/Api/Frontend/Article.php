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
use Tymon\JWTAuth\Facades\JWTAuth;
//use App\Http\Controllers\Frontend\Common;

class Article extends Common
{

    //
    public function index(Request $request){
        $user = $this->getUser();

		$data = Db::table('article')->select(['id','title','content','picture','visit'])->where('state', 1)->orderBy('id','desc')->pages('', 12);

		foreach ($data['lists'] as $key => $value) {
			$data['lists'][$key]['picture'] = config('app.url').$data['lists'][$key]['picture'];
			$data['lists'][$key]['content'] = str_limit(strip_tags($data['lists'][$key]['content']), $limit = 120, $end = '...');

			//用户喜欢状态
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

		$this->returnMessage(200, '成功', $data);
	}

	public function category(Request $request){
    	$id = (int)$request->id;

        $user = $this->getUser();

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['category_id', '=', $id];
		}

		$data = Db::table('article')->where($where)->orderBy('id','desc')->pages('', 12);
		
		foreach ($data['lists'] as $key => $value) {
			//用户喜欢状态
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
        
		$this->returnMessage(200, '成功', $data);
	}

	public function show(Request $request){
    	$id = (int)$request->id;

    	$user = $this->getUser();

    	$where = [];
    	$where[] = ['state', '=', 1];
		if(isset($request->id)){
			$where[] = ['id', '=', $id];
		}

		$data['article'] = Db::table('article')->select(['id','title','content','picture','category_id','seo_title','seo_keywords','seo_description','created'])->where($where)->orderBy('id','desc')->item();
		$data['article']['content'] = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s">', config('app.url').'${2}' ), $data['article']['content'] );
		$data['article']['created'] = date('Y-m-d H:i:s',$data['article']['created']);

		//config('app.url').$data['lists'][$key]['picture'];

		//当前分类
		$data['article']['category'] = Db::table('article_category')->where('id',$data['article']['category_id'])->where('state',1)->select(['id','name'])->item();

		//喜欢状态
		$data['like'] = 0;
		if($user){
            //喜欢状态
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

		DB::table('article')->where('id', $id)->increment('visit', 1);
        
		$this->returnMessage(200, '成功', $data);
	}

}
