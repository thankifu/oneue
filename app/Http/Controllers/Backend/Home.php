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

class Home extends Common
{
    //
    public function index(Request $request){
		$data['_admin']=auth()->guard('admin')->user();
        $data['_menus']=$this->_getMenus($request, $data['_admin']);
        $data['_site'] = $this->_getSeting('site')['value'];
        $data['_side']=$request->cookie('_side');
		return view('backend.home.index', $data);
	}

	public function welcome(Request $request){
		return view('backend.home.welcome');
	}

    private function _getMenus(Request $request, $_admin){
        $group = DB::table('admin_group')->where('id',$_admin['group_id'])->item();
        $menus = false;
        if($group['permission']){
            $group['permission'] = json_decode($group['permission'],true);
            $where = 'id in('.implode(',', $group['permission']).') and hidden=0 and state=1';
            $menus = DB::table('admin_menu')->whereRaw($where)->orderBy('position','asc')->orderBy('id','asc')->cates('id');
        }

        if($menus){
            $temp = [];
            foreach ($menus as $key => $value) {
                $value['controller'] = strtolower($value['controller']);
                $value['action'] = strtolower($value['action']);
                $temp[$value['id']] = $value;
                if($value['path']){
                    $temp[$key]['url'] = '/admin/'.$value['controller'].'/'.$value['path'];
                }else{
                    $temp[$key]['url'] = '/admin/'.$value['controller'].'/'.$value['action'];
                }
                
            }
            
            $menus = $temp;
            $menus = $this->_formateMenus($menus);
        }
        return $menus;
    }

    //处理角色菜单
    private function _formateMenus($items){
        $data = array();
        foreach ($items as $item){
            if (isset($items[$item['parent']])){
                $items[$item['parent']]['children'][] = &$items[$item['id']];
            }else{
                $data[] = &$items[$item['id']];
            }
        }
        return $data;
    }

    //根据key获取配置详情
    private function _getSeting($key){
        $data = Db::table('admin_setting')->where(array('key'=>$key))->item();
        $data['value'] && $data['value'] = json_decode($data['value'],true);
        !$data['value'] && $data['value'] = false;
        return $data;
    }
}
