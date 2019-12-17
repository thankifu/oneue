<?php
namespace App\Http\Views;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Frontend{
    protected $data;

    public function __construct(Request $request){
        //$this->_menus = [];
        $this->data['_user']=auth()->user();

        //$this->data['_menus']=$this->_getMenus($request, $this->data['_admin']);
        $this->data['_site'] = $this->_getSeting('site')['value'];
        //$this->data['_side']=$request->cookie('_side');

        $this->data['_article_category'] = Db::table('article_category')->where('state', 1)->select(['id','name'])->cates('id');
        $this->data['_product_category'] = Db::table('product_category')->where('state', 1)->select(['id','name'])->cates('id');
        $this->data['_product'] = Db::table('product')->where('state', 1)->limit('5')->lists();
        $discount = $this->_getUserDiscount();
        foreach ($this->data['_product'] as $key => $value) {
            $price  = $this->_getProductPrice($this->data['_product'][$key]['selling'], $discount);
            $this->data['_product'][$key]['price'] = $price;
        }

        $this->data['_cart'] = Db::table('cart')->where(array(['user_id', $this->data['_user']['id']],['state', 1]))->lists();
        $this->data['_cart']['count'] = Db::table('cart')->where(array(['user_id', $this->data['_user']['id']],['state', 1]))->sum('quantity');


        //$this->data['_user_discount'] = Db::table('user_level')->select(['discount'])->where('id', $this->data['_user']['level'])->item();
    }

    // 根据key获取配置详情
    private function _getSeting($key){
        $data = Db::table('admin_setting')->where(array('key'=>$key))->item();
        $data['value'] && $data['value'] = json_decode($data['value'],true);
        !$data['value'] && $data['value'] = false;
        return $data;
    }

    private function _getUserDiscount(){
        if(!auth()->user()){
            return 1;
            exit();
        }
        $user_level = auth()->user()->level;
        $user_discount = Db::table('user_level')->select(['discount'])->where('id', $user_level)->item();
        $user_discount = $user_discount['discount'];
        $result = number_format(floatval($user_discount) / 10, 2, '.', '');
        return $result;
    }

    private function _getProductPrice($price, $discount = 1){
        if(!auth()->user()){
            return $price;
            exit();
        }   
        $result = number_format(floatval($price) * $discount, 2, '.', '');
        return $result;
    }

    public function compose(View $view)
    {
        $view->with($this->data);
    }
}
