<?php
namespace App\Http\Views;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Frontend{
    protected $data;

    public function __construct(Request $request){
        //$this->_menus = [];
        //$this->data['_admin']=auth()->guard('admin')->user();
        //$this->data['_menus']=$this->_getMenus($request, $this->data['_admin']);
        $this->data['_site'] = $this->_getSeting('site')['value'];
        //$this->data['_side']=$request->cookie('_side');

        $this->data['_article_category'] = Db::table('article_category')->where('state', 1)->select(['id','name'])->cates('id');
        $this->data['_product_category'] = Db::table('product_category')->where('state', 1)->select(['id','name'])->cates('id');
        $this->data['_product'] = Db::table('product')->where('state', 1)->limit('5')->lists();
    }

    // 根据key获取配置详情
    private function _getSeting($key){
        $data = Db::table('admin_setting')->where(array('key'=>$key))->item();
        $data['value'] && $data['value'] = json_decode($data['value'],true);
        !$data['value'] && $data['value'] = false;
        return $data;
    }

    public function compose(View $view)
    {
        $view->with($this->data);
    }
}
