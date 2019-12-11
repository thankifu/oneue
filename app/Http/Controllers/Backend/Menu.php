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

class Menu extends Common
{
    // 菜单
	public function index(Request $request){
		// 下级菜单
		$data['parent'] = (int)$request->parent;
		$data['lists'] = DB::table('admin_menu')->where('parent',$data['parent'])->orderBy('position','asc')->orderBy('id','asc')->lists();
		// 返回上一级菜单
		$data['back_id'] = 0;
		if($data['parent'] > 0){
			$parent = DB::table('admin_menu')->where('id',$data['parent'])->item();
			$data['back_id'] = $parent['parent'];
		}
		return view('backend/menu/index',$data);
	}

	// 添加修改菜单
	public function add(Request $request){
		$parent = (int)$request->parent;
		$id = (int)$request->id;
		$data['parent_menu'] = Db::table('admin_menu')->where('id',$parent)->item();
		$data['menu'] = Db::table('admin_menu')->where('id',$id)->item();
		return view('backend/menu/add',$data);
	}

	// 保存菜单
	public function save(Request $request){
		$id = (int)$request->id;
		$data['parent'] = (int)$request->parent;
		$data['name'] = trim($request->name);
		$data['controller'] = trim($request->controller);
		$data['action'] = trim($request->action);
		$data['position'] = (int)$request->position;
		$data['hidden'] = (int)$request->hidden;
		$data['state'] = (int)$request->state;
		
		if($data['name'] == ''){
			//exit(json_encode(array('code'=>1,'msg'=>'请输入菜单名称')));
			$this->returnMessage(400,'请输入菜单名称');
		}
		/*if($data['parent']>0 && $data['controller'] == ''){
			exit(json_encode(array('code'=>1,'msg'=>'控制器名称不能为空')));
		}
		if($data['parent']>0 && $data['action'] == ''){
			exit(json_encode(array('code'=>1,'msg'=>'方法名称不能为空')));
		}*/

		if($id){
			$data['modified'] = time();
			$res = Db::table('admin_menu')->where('id',$id)->update($data);
			$log = '编辑后台菜单：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('admin_menu')->insertGetId($data);
			$log = '新增后台菜单：'.$data['name'].'，ID：'.$res.'。';
		}

		//添加操作日志
		$this->log($log);
		//exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
		$this->returnMessage(200,'保存成功');
	}

	public function delete(Request $request){
		$id = (int)$request->id;
		$is = Db::table('admin_menu')->where('id',$id)->item();
		if(!$is){
			//exit(json_encode(array('code'=>1,'msg'=>'菜单不存在')));
			$this->returnMessage(400,'菜单不存在');
		}
		Db::table('admin_menu')->where('id',$id)->delete();

		//添加操作日志
		$this->oplog('删除后台菜单：'.$is['name'].'，ID：'.$id.'。');

		//exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
		$this->returnMessage(200,'删除成功');
	}
}
