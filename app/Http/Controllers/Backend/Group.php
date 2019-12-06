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

class Group extends Common
{
    //列表
	public function index(Request $request){

		$name = trim($request->name);
		
		$where = [];
		if($name){
			$where = [['name', 'like', '%'.$name.'%']];
		}

		$appends = [];
		if($name){
			$appends['name'] = $name;
		}

		$data = Db::table('admin_group')->where($where)->orderBy('id','desc')->pages($appends);

		return view('/backend/group/index',$data);
	}

	//添加修改
	public function add(Request $request){
		$id = (int)$request->id;
		$data['group'] = DB::table('admin_group')->where(array('id'=>$id))->item();
		if($data['group']['permission']){
			$data['group']['permission'] = json_decode($data['group']['permission']);
		}

		$menu_list = DB::table('admin_menu')->where('state',1)->cates('id');
		$menus = $this->_getTreeItems($menu_list);
		$results = array();
		foreach ($menus as $value) {
			$value['children'] = isset($value['children'])?$this->_formateMenus($value['children']):false;
			$results[] = $value;
		}
		$data['menus'] = $results;
		return view('/backend/group/add',$data);
	}

	//保存
	public function save(Request $request){
		$id = (int)$request->id;
		$name = trim($request->name);
		$menus = $request->menu;

		if($name==''){
			//exit(json_encode(array('code'=>1,'msg'=>'请输入管理组名')));
			$this->returnMessage(400,'请输入管理组名');
		}

		$data['name'] = $name;
		$menus && $data['permission'] = json_encode(array_keys($menus));

		if($id){
			$data['modified'] = time();
			DB::table('admin_group')->where(array('id'=>$id))->update($data);
			$log = '编辑管理组：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$is = DB::table('admin_group')->where('name',$name)->item();
			if($is){
				//exit(json_encode(array('code'=>1,'msg'=>'管理组已存在')));
				$this->returnMessage(400,'管理组已存在');
			}
			$data['created'] = time();
			$id = DB::table('admin_group')->insertGetId($data);
			$log = '新增管理组：'.$data['name'].'，ID：'.$id.'。';
		}

		//添加操作日志
		$this->log($log);

		//exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
		$this->returnMessage(200,'保存成功');
	}

	//获取树型菜单的元素
	private function _getTreeItems($items){
		$tree = array();
	    foreach ($items as $item){
	        if (isset($items[$item['parent']])){
	            $items[$item['parent']]['children'][] = &$items[$item['id']];
	        }else{
	            $tree[] = &$items[$item['id']];
	        }
	    }
	    return $tree;
	}

	//格式化菜单
	private function _formateMenus($items,&$res = array()){
		foreach ($items as $item) {
			if(!isset($item['children'])){
				$res[] = $item;
			}else{
				$tem = $item['children'];
				unset($item['children']);
				$res[] = $item;
				$this->_formateMenus($tem,$res);
			}
		}
		return $res;
	}
}
