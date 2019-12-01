<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * 权限验证中间件
 */
class AuthenticateMenus{

    public function handle($request,Closure $next){
        $_admin = Auth::guard('admin')->user();

        $request->_admin = $_admin;
        // need to fix
        if($_admin['group_id']==1){
            return $next($request);
        }

        $group = DB::table('admin_group')->where(array('id'=>$_admin['group_id']))->select('name','permission')->first();
        if(!$group || !$group->permission){
            return response($this->_noPermission($request),200);
        }
        $_admin['group_name'] = $group->name;
        $group->permission = json_decode($group->permission,true);

        // controller和action
        $request_action = $request->route()->getActionName();
        list($class, $action) = explode('@', $request_action);
        $class_list = explode('\\',$class);
        $controller = $class_list[count($class_list)-1];

        $curMenu = DB::table('admin_menu')->where('controller',$controller)->where('action',$action)->first();
        if(!$curMenu){
            return response($this->_noPermission($request),200);
        }
        if(!in_array($curMenu->id, $group->permission)){
            return response($this->_noPermission($request),200);
        }

        return $next($request);
    }

    // 没有权限
    private function _noPermission($request,$msg = '没有权限，请联系管理员'){
        if($request->ajax()){
            $response = json_encode(array('code'=>1,'msg'=>$msg));
        }else{
            $response = '<div style="text-align:center;color:#666;margin-top:10px;">'.$msg.'</div>';
        }
        return $response;
    }
}
