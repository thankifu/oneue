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

class Help extends Common
{
    //列表
    public function index(Request $request){

		$title = trim($request->title);
		$category_id = (int)$request->category_id;
		
		$where = [];
		if($title){
			$where[] = ['title', 'like', '%'.$title.'%'];
		}
		if(isset($request->category_id)){
			$where[] = ['category_id', '=', $category_id];
		}

		$appends = [];
		if($title){
			$appends['title'] = $title;
		}
		if(isset($request->category_id)){
			$appends['category_id'] = $category_id;
		}
		/*echo '<pre>';
		print_r($where);*/
		$data = Db::table('help')->where($where)->orderBy('id','desc')->pages($appends);

		//分类
		$data['categories'] = Db::table('help_category')->select(['id','name'])->cates('id');
		return view('backend.help.index',$data);
	}

	//增改
	public function item(Request $request){
		$id = (int)$request->id;
		$data['help'] = Db::table('help')->where('id',$id)->item();

		//分类
		$data['categories'] = DB::table('help_category')->select(['id','name'])->cates('id');
		return view('backend.help.item',$data);
	}

	//保存
	public function save(Request $request){
		$id = (int)$request->id;
		$data['title'] = trim($request->title);
		$data['content'] = trim($request->content);
		$data['position'] = (int)$request->position;
		$data['category_id'] = (int)$request->category_id;
		$data['seo_title'] = trim($request->seo_title);
		$data['seo_description'] = trim($request->seo_description);
		$data['seo_keywords'] = trim($request->seo_keywords);
		$data['state'] = (int)$request->state;

		if($id){
			$data['modified'] = time();
			$res = Db::table('help')->where('id',$id)->update($data);
			$log = '修改帮助：'.$data['title'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('help')->insertGetId($data);
			$log = '新增帮助：'.$data['title'].'，ID：'.$res.'。';
		}

		//添加日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//删除
	public function delete(Request $request){
		$id = (int)$request->id;
		$has = DB::table('help')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'帮助不存在');
		}
		$res = DB::table('help')->where('id',$id)->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加日志
		$this->log('删除帮助：'.$has['title'].'，ID：'.$id.'。');
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
		$data['lists'] = DB::table('help_category')->where('parent',$data['parent'])->where($where)->orderBy('position','asc')->orderBy('id','asc')->lists();
		//返回上一级
		$data['back'] = 0;
		if($data['parent'] > 0){
			$parent = DB::table('help_category')->where('id',$data['parent'])->where($where)->item();
			$data['back'] = $parent['parent'];
		}

		return view('backend.help.category.index',$data);
	}

	//分类添加修改
	public function categoryItem(Request $request){
		$parent = (int)$request->parent;
		$id = (int)$request->id;
		$data['parent'] = Db::table('help_category')->where('id',$parent)->item();
		$data['category'] = Db::table('help_category')->where('id',$id)->item();
		return view('backend.help.category.item',$data);
	}

	//分类保存
	public function categorySave(Request $request){
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
			$res = Db::table('help_category')->where('id',$id)->update($data);
			$log = '修改帮助分类：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('help_category')->insertGetId($data);
			$log = '新增帮助分类：'.$data['name'].'，ID：'.$res.'。';
		}

		//添加日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//分类删除
	public function categoryDelete(Request $request){
		$id = (int)$request->id;
		$has = Db::table('help_category')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'帮助分类不存在');
		}
		Db::table('help_category')->where('id',$id)->delete();

		//添加日志
		$this->log('删除帮助分类：'.$has['name'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

}
