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

class User extends Common
{
    //列表
    public function index(Request $request){
		$username = trim($request->username);
		$state = (int)$request->state;

		$where = [];
		if($username){
			$where[] = ['username', 'like', '%'.$username.'%'];
		}
		if(isset($request->state)){
			$where[] = ['state', '=', $state];
		}

		$appends = [];
		if($username){
			$appends['username'] = $username;
		}
		if(isset($request->state)){
			$appends['state'] = $state;
		}

		//print_r($state);exit();
		
		$data = Db::table('user')->where($where)->orderBy('id','desc')->pages($appends);
		$data['levels'] = Db::table('user_level')->select(['id','name'])->cates('id');
		return view('backend.user.index',$data);
	}

	//添加修改
	public function show(Request $request){
		$id = (int)$request->id;
		$data['user'] = Db::table('user')->where('id',$id)->item();
		$data['levels'] = Db::table('user_level')->select(['id','name'])->where('state', 1)->cates('id');
		return view('backend.user.show',$data);
	}

	//保存
	public function store(Request $request){
		$id = (int)$request->id;
		$username = trim($request->username);
		$password = trim($request->password);
		$data['email'] = trim($request->email);
		$data['phone'] = trim($request->phone);
		$data['sex'] = (int)$request->sex;
		$data['age'] = (int)$request->age;
		$data['level'] = (int)$request->level;
		$data['state']= (int)$request->state;

		if($id == 0 && !$username){
			$this->returnMessage(400,'请输入用户名');
		}
		if($id == 0 && $password==''){
			$this->returnMessage(400,'请输入密码');
		}
		
		if($id){
			$data['modified'] = time();
			if($password){
				$admin = DB::table('user')->where('id',$id)->item();
				$data['password'] = password_hash($password,PASSWORD_DEFAULT);
			}
			DB::table('user')->where('id',$id)->update($data);
			$log = '修改用户：'.$username.'，ID：'.$id.'。';
		}else{
			$has = DB::table('user')->where('username',$username)->item();
			if($has){
				$this->returnMessage(400,'用户名已存在');
			}
			$data['created'] = time();
			$data['username'] = $username;
			$data['password'] = password_hash($password,PASSWORD_DEFAULT);
			$id = DB::table('user')->insertGetId($data);
			$log = '新增用户：'.$data['username'].'，ID：'.$id.'。';
		}

		//添加日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//删除
	public function delete(Request $request){
		$id = (int)$request->id;
		$has = DB::table('user')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'用户不存在');
		}
		$res = DB::table('user')->where('id',$id)->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加日志
		$this->log('删除用户：'.$has['username'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

	//等级列表
    public function levelIndex(Request $request){
    	$name = trim($request->name);
		$state = (int)$request->state;
		
		$where = [];
		if($name){
			$where[] = ['name', 'like', '%'.$name.'%'];
		}
		if(isset($request->state)){
			$where[] = ['state', '=', $state];
		}

		$appends = [];
		if($name){
			$appends['name'] = $name;
		}
		if(isset($request->state)){
			$appends['state'] = $state;
		}

		$data = Db::table('user_level')->where($where)->orderBy('id','desc')->pages($appends);
		return view('backend.user.level.index',$data);
	}

	//等级添加修改
	public function levelShow(Request $request){
		$id = (int)$request->id;
		$data['level'] = Db::table('user_level')->where('id',$id)->item();
		return view('backend.user.level.show',$data);
	}

	//等级保存
	public function levelStore(Request $request){
		$id = (int)$request->id;
		$data['name'] = trim($request->name);
		$data['discount'] = trim($request->discount);
		$data['state']= (int)$request->state;

		if(!$data['name']){
			$this->returnMessage(400,'请输入等级名称');
		}
		if(!$data['discount']){
			$this->returnMessage(400,'请输入等级折扣');
		}

		if($id){
			$data['modified'] = time();
			$res = Db::table('user_level')->where('id',$id)->update($data);
			$log = '修改用户等级：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('user_level')->insertGetId($data);
			$log = '添加用户等级：'.$data['name'].'，ID：'.$res.'。';
		}

		//添加日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//等级删除
	public function levelDelete(Request $request){
		$id = (int)$request->id;
		$has = DB::table('user_level')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'用户等级不存在');
		}
		$res = DB::table('user_level')->where('id',$id)->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加日志
		$this->log('删除用户等级：'.$has['name'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

}
