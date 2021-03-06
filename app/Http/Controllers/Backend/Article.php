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
			$where[] = ['title', 'like', '%'.$title.'%'];
		}
		if($category_id){
			$where[] = ['category_id', '=', $category_id];
		}

		$appends = [];
		if($title){
			$appends['title'] = $title;
		}
		if($category_id){
			$appends['category_id'] = $category_id;
		}
		
		$data = Db::table('article')->where($where)->orderBy('id','desc')->pages($appends);
		//分类
		$data['categories'] = Db::table('article_category')->select(['id','name'])->cates('id');
		return view('backend.article.index',$data);
	}

	//添加修改
	public function show(Request $request){
		$id = (int)$request->id;
		$data['article'] = Db::table('article')->where('id',$id)->item();
		//分类
		$data['categories'] = DB::table('article_category')->select(['id','name'])->cates('id');
		return view('backend.article.show',$data);
	}

	//保存
	public function store(Request $request){
		$id = (int)$request->id;
		$data['title'] = trim($request->title);
		$data['content'] = trim($request->content);
		$data['author'] = trim($request->author);
		$data['picture'] = trim($request->picture);
		$data['author'] = trim($request->author);
		$data['seo_title'] = trim($request->seo_title);
		$data['seo_description'] = trim($request->seo_description);
		$data['seo_keywords'] = trim($request->seo_keywords);
		$data['category_id'] = (int)$request->category_id;
		$data['state'] = (int)$request->state;

		if($id){
			$data['modified'] = time();
			$res = Db::table('article')->where('id',$id)->update($data);
			$log = '修改文章：'.$data['title'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('article')->insertGetId($data);
			$log = '新增文章：'.$data['title'].'，ID：'.$res.'。';
		}

		//添加日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//删除
	public function delete(Request $request){
		$id = (int)$request->id;
		$has = DB::table('article')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'文章不存在');
		}
		$res = DB::table('article')->where('id',$id)->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加日志
		$this->log('删除文章：'.$has['title'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

	//分类列表
    public function categoryIndex(Request $request){
		$name = trim($request->name);
		$state = (int)$request->state;
		
		$where = [];
		if($name){
			$where[] = ['name', 'like', '%'.$name.'%'];
		}
		if(isset($request->state)){
			$where[] = ['state', '=', $state];
		}

		$data['parent'] = (int)$request->parent;
		$data['lists'] = DB::table('article_category')->where('parent',$data['parent'])->where($where)->orderBy('position','asc')->orderBy('id','asc')->lists();
		//返回上一级
		$data['back'] = 0;
		if($data['parent'] > 0){
			$parent = DB::table('article_category')->where('id',$data['parent'])->where($where)->item();
			$data['back'] = $parent['parent'];
		}

		return view('backend.article.category.index',$data);
	}

	//分类添加修改
	public function categoryShow(Request $request){
		$parent = (int)$request->parent;
		$id = (int)$request->id;
		$data['parent'] = Db::table('article_category')->where('id',$parent)->item();
		$data['category'] = Db::table('article_category')->where('id',$id)->item();
		return view('backend.article.category.show',$data);
	}

	//分类保存
	public function categoryStore(Request $request){
		$id = (int)$request->id;
		$data['name'] = trim($request->name);
		$data['parent'] = (int)$request->parent;
		$data['position'] = (int)$request->position;
		$data['seo_title'] = trim($request->seo_title);
		$data['seo_keywords'] = trim($request->seo_keywords);
		$data['seo_description'] = trim($request->seo_description);
		$data['state'] = (int)$request->state;
		
		if($data['name'] == ''){
			$this->returnMessage(400,'请输入分类名称');
		}

		if($id){
			$data['modified'] = time();
			$res = Db::table('article_category')->where('id',$id)->update($data);
			$log = '修改文章分类：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('article_category')->insertGetId($data);
			$log = '新增文章分类：'.$data['name'].'，ID：'.$res.'。';
		}

		//添加日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//分类删除
	public function categoryDelete(Request $request){
		$id = (int)$request->id;
		$has = Db::table('article_category')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'文章分类不存在');
		}
		Db::table('article_category')->where('id',$id)->delete();

		//添加日志
		$this->log('删除文章分类：'.$has['name'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

}
