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

class Slide extends Common
{
    //列表
    public function index(Request $request){

		$title = trim($request->title);
		$state = (int)$request->state;
		
		$where = [];
		if($title){
			$where[] = ['title', 'like', '%'.$title.'%'];
		}
		if(isset($request->state)){
			$where[] = ['state', '=', $state];
		}

		$appends = [];
		if($title){
			$appends['title'] = $title;
		}
		if(isset($request->state)){
			$appends['state'] = $state;
		}
		
		$data = Db::table('slide')->where($where)->orderBy('id','desc')->pages($appends);

		return view('backend.slide.index',$data);
	}

	//增改
	public function item(Request $request){
		$id = (int)$request->id;
		$data['slide'] = Db::table('slide')->where('id',$id)->item();
		return view('backend.slide.item',$data);
	}

	//保存
	public function save(Request $request){
		$id = (int)$request->id;
		$data['title'] = trim($request->title);
		$data['subtitle'] = trim($request->subtitle);
		$data['picture'] = trim($request->picture);
		$data['url'] = trim($request->url);
		$data['position'] = (int)$request->position;
		$data['state'] = (int)$request->state;

		if($id){
			$data['modified'] = time();
			$res = Db::table('slide')->where('id',$id)->update($data);
			$log = '修改轮播：'.$data['title'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('slide')->insertGetId($data);
			$log = '新增轮播：'.$data['title'].'，ID：'.$res.'。';
		}

		//添加日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//删除
	public function delete(Request $request){
		$id = (int)$request->id;
		$has = DB::table('slide')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'轮播不存在');
		}
		$res = DB::table('slide')->where('id',$id)->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加日志
		$this->log('删除轮播：'.$has['title'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

}
