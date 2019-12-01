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
		$data['users'] = DB::table('user')->select(['id','username'])->cates('id');
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
			//$descs = '修改后台菜单：《'.$data['name'].'》,ID：'.$id;
		}else{
			$data['created'] = time();
			$res = Db::table('article')->insertGetId($data);
			//$descs = '添加后台菜单：《'.$data['name'].'》,ID：'.$res;
		}

		//添加操作日志
		//$this->oplog($request->_admin['id'],$descs);
		$this->returnMessage(200,'保存成功');
	}

	//删除
	public function delete(Request $request){
		$id = (int)$request->id;
		$is = DB::table('admin')->where(array('id'=>$id))->item();
		if(!$is){
			$this->returnMessage(400,'管理员不存在');
		}
		$res = DB::table('admin')->where(array('id'=>$id))->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加操作日志
		//$this->oplog($request->_admin['id'],'删除管理员：《'.$admins['name'].'》,ID：'.$id);
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

		$appends = [];
		if($name){
			$appends['name'] = $name;
		}
		if(isset($request->state)){
			$appends['state'] = $state;
		}

		/*print_r($where);
		die();*/
		
		$data = Db::table('article_category')->where($where)->orderBy('id','desc')->pages($appends);

		return view('backend.article.category',$data);
	}

}
