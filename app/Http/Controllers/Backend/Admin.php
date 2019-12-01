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

class Admin extends Common
{
    //列表
    public function index(Request $request){
		$name = trim($request->name);
		$username = trim($request->username);
		$group_id = trim($request->group_id);
		
		$where = [];
		if($name){
			$where = [['name', 'like', '%'.$name.'%']];
		}
		if($username){
			$where = [['username', 'like', '%'.$username.'%']];
		}
		if($group_id){
			$where = [['group_id', '=', $group_id]];
		}

		$appends = [];
		if($name){
			$appends['name'] = $name;
		}
		if($username){
			$appends['username'] = $username;
		}
		if($group_id){
			$appends['group_id'] = $group_id;
		}
		
		$data = Db::table('admin')->where($where)->orderBy('id','desc')->pages($appends);
		//管理员组
		$data['groups'] = Db::table('admin_group')->select(['id','name'])->cates('id');
		return view('backend.admin.index',$data);
	}

	//添加修改
	public function add(Request $request){
		$id = (int)$request->id;
		$data['admin'] = Db::table('admin')->where(array('id'=>$id))->item();
		// 管理员组
		$data['groups'] = DB::table('admin_group')->select(['id','name'])->cates('id');
		return view('backend.admin.add',$data);
	}

	//保存
	public function save(Request $request){
		$id = (int)$request->id;
		$username = trim($request->username);
		$password = trim($request->password);
		$data['group_id'] = (int)$request->group_id;
		$data['name'] = trim($request->name);
		$data['phone'] = trim($request->phone);
		$data['state']= (int)$request->state;

		if($id == 0 && $password==''){
			$this->returnMessage(400,'请输入密码');
		}
		if($id == 0 && !$username){
			$this->returnMessage(400,'请输入用户名');
		}
		if(!$data['group_id']){
			$this->returnMessage(400,'请选择管理组');
		}
		if(!$data['name']){
			$this->returnMessage(400,'请输入真实姓名');
		}
		if($id){
			$data['modified'] = time();
			if($password){
				$admin = DB::table('admin')->where('id',$id)->item();
				$data['password'] = password_hash($password,PASSWORD_DEFAULT);
			}
			DB::table('admin')->where('id',$id)->update($data);
			$descs = '编辑管理员：《'.$data['name'].'》,ID：'.$id;
		}else{
			$is = DB::table('admin')->where('username',$username)->item();
			if($is){
				$this->returnMessage(400,'用户已存在');
			}
			$data['created'] = time();
			$data['username'] = $username;
			$data['password'] = password_hash($password,PASSWORD_DEFAULT);
			$id = DB::table('admin')->insertGetId($data);
			$descs = '添加管理员：《'.$data['name'].'》,ID：'.$id;
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

	//禁用
	public function forbid(){

	}

	//启用
	public function resume(){

	}
}
