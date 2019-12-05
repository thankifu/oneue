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
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Article extends Common
{
    //列表
    public function index(Request $request){

		$title = trim($request->title);
		$category_id = trim($request->category_id);
		
		$where = [];
		if($title){
			$where = [['title', 'like', '%'.$title.'%']];
		}
		if($category_id){
			$where = [['category_id', '=', $category_id]];
		}

		$appends = [];
		if($title){
			$appends['title'] = $title;
		}
		if($category_id){
			$appends['category_id'] = $category_id;
		}
		
		$data = Db::table('article')->where($where)->orderBy('id','desc')->pages($appends);
		//文章分类
		$data['categories'] = Db::table('article_category')->select(['id','name'])->cates('id');
		return view('backend.article.index',$data);
	}

	//添加修改
	public function add(Request $request){
		$id = (int)$request->id;
		$data['article'] = Db::table('article')->where(array('id'=>$id))->item();
		//分类
		$data['categories'] = DB::table('article_category')->select(['id','name'])->cates('id');
		return view('backend.article.add',$data);
	}

	//保存
	public function save(Request $request){
		$id = (int)$request->id;
		$data['title'] = trim($request->title);
		$data['content'] = trim($request->content);
		$data['author'] = trim($request->author);
		$data['picture'] = trim($request->picture);
		$data['author'] = trim($request->author);
		$data['seo_title'] = trim($request->seo_title);
		$data['seo_description'] = trim($request->seo_description);
		$data['seo_keywords'] = trim($request->seo_keywords);
		$data['user_id'] = (int)$request->user_id;
		$data['category_id'] = (int)$request->category_id;
		$data['state'] = (int)$request->state;

		if($id){
			$data['modified'] = time();
			$res = Db::table('article')->where(array('id'=>$id))->update($data);
			$log = '修改文章：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('article')->insertGetId($data);
			$log = '添加文章：'.$data['name'].'，ID：'.$res.'。';
		}

		//添加操作日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//删除
	public function delete(Request $request){
		$id = (int)$request->id;
		$is = DB::table('article')->where(array('id'=>$id))->item();
		if(!$is){
			$this->returnMessage(400,'文章不存在');
		}
		$res = DB::table('article')->where(array('id'=>$id))->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加操作日志
		$this->log('删除文章：'.$is['title'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

	//分类列表
    public function category(Request $request){
		$name = trim($request->name);
		$state = (int)$request->state;
		
		$where = [];
		if($name){
			$where = [['name', 'like', '%'.$name.'%']];
		}
		if(isset($request->state)){
			$where = [['state', '=', $state]];
		}

		$data['parent'] = (int)$request->parent;
		$data['lists'] = DB::table('article_category')->where(array('parent'=>$data['parent']))->where($where)->orderBy('position','asc')->orderBy('id','asc')->lists();
		// 返回上一级菜单
		$data['back_id'] = 0;
		if($data['parent'] > 0){
			$parent = DB::table('article_category')->where(array('id'=>$data['parent']))->where($where)->item();
			$data['back_id'] = $parent['parent'];
		}

		return view('backend.article.category.index',$data);
	}

	//添加修改分类
	public function categoryAdd(Request $request){
		$parent = (int)$request->parent;
		$id = (int)$request->id;
		$data['parent'] = Db::table('article_category')->where(array('id'=>$parent))->item();
		$data['category'] = Db::table('article_category')->where(array('id'=>$id))->item();
		return view('backend.article.category.add',$data);
	}

	// 保存菜单
	public function categorySave(Request $request){
		$id = (int)$request->id;
		$data['parent'] = (int)$request->parent;
		$data['name'] = trim($request->name);
		$data['position'] = (int)$request->position;
		$data['state'] = (int)$request->state;
		
		if($data['name'] == ''){
			$this->returnMessage(400,'请输入菜单名称');
		}

		if($id){
			$data['modified'] = time();
			$res = Db::table('article_category')->where(array('id'=>$id))->update($data);
			$log = '修改文章分类：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('article_category')->insertGetId($data);
			$log = '添加文章分类：'.$data['name'].'，ID：'.$res.'。';
		}

		//添加操作日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	public function categoryDelete(Request $request){
		$id = (int)$request->id;
		$is = Db::table('article_category')->where(array('id'=>$id))->item();
		if(!$is){
			$this->returnMessage(400,'文章分类不存在');
		}
		Db::table('article_category')->where(array('id'=>$id))->delete();

		//添加操作日志
		$this->log('删除文章分类：'.$is['name'].'，ID：'.$id.'。');

		$this->returnMessage(200,'删除成功');
	}

}
