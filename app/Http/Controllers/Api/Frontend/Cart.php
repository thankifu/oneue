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

namespace App\Http\Controllers\Api\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 购物车
**/

class Cart extends Common{

    //购物清单
    public function index(Request $request){

    	//用户信息
    	$user = $this->getUser();
        $user_id = $user['id'];

        //站点信息
        $site = $this->getSeting('site')['value'];

        //用户折扣
        $user_discount = $this->getUserDiscount();

        $cart = Db::table('cart')->where(array(['user_id', $user_id],['state', 1]))->lists();

        $product_id = array_column($cart, 'product_id');
        $specification_id = array_column($cart, 'specification_id');

        $products = Db::table('product')->whereIn('id', $product_id)->cates('id');
        $specifications = Db::table('product_specification')->whereIn('id', $specification_id)->cates('id');

        foreach ($products as $key => $value) {
        	$price  = $this->getProductPrice($products[$key]['selling'], $user_discount);
			$products[$key]['price'] = $price;
        }

        foreach ($specifications as $key => $value) {
        	$price  = $this->getProductPrice($specifications[$key]['selling'], $user_discount);
			$specifications[$key]['price'] = $price;
        }

        foreach ($cart as $key => $value) {
        	$cart[$key]['name'] = $products[$value['product_id']]['name'];
        	if($value['specification_id'] > 0){
        		$cart[$key]['name'] = $cart[$key]['name'].' - '.$specifications[$value['specification_id']]['name'];
        	}

			$cart[$key]['picture'] = $value['specification_id'] > 0 && $specifications[$value['specification_id']]['picture'] ? config('app.url').$specifications[$value['specification_id']]['picture'] : config('app.url').$products[$value['product_id']]['picture'];
			$cart[$key]['price'] = $value['specification_id'] > 0 ? $specifications[$value['specification_id']]['price'] : $products[$value['product_id']]['price'];
			$cart[$key]['stock'] = $value['specification_id'] > 0 ? $specifications[$value['specification_id']]['quantity'] : $products[$value['product_id']]['quantity'];
        }

        //定义返回数据
    	$data['cart'] = $cart;
		$data['page']['title'] = '购物车 - '.$site['name'];
		$data['page']['keywords'] = '购物车,'.$site['name'];
		$data['page']['description'] = '';

		//返回数据
		$this->returnMessage(200, '成功', $data);

	}

	public function create(Request $request){
		$user = $this->getUser();
        $user_id = $user['id'];

        $product_id = (int)$request->product;
		$specification_id = (int)$request->specification;
		$data['quantity'] = (int)$request->quantity;
		
		//检查商品及规格
		$product = Db::table('product')->where(array(['id', $product_id],['state', 1]))->item();
		if(!$product){
			$this->returnMessage(400,'该商品已下架');
		}

		$specification = Db::table('product_specification')->where(array(['id', $specification_id],['product_id', $product_id]))->item();
		if($specification_id>0 && !$specification){
			$this->returnMessage(400,'该商品规格已下架');
		}

		//检查库存1
		if($specification){
			$quantity = $specification['quantity'];
		}else{
			$quantity = $product['quantity'];
		}
		if($quantity <= 0){
			$this->returnMessage(400,'库存不足');
		}

		//检查是否已存在
		$has = Db::table('cart')->where(array(['user_id', $user_id],['product_id', $product_id],['specification_id', $specification_id]))->item();

		//检查库存2
		if($has){
			if($quantity < floatval($data['quantity'] + $has['quantity'])){
				$this->returnMessage(400,'购物车中已存在'.$has['quantity'].'个，仅能加入'.floatval($quantity-$has['quantity']).'个');
			}
		}else{
			if($quantity < $data['quantity']){
				$this->returnMessage(400,'库存不足，仅剩'.$quantity.'个');
			}
		}
		
		//设置参数
		$data['user_id'] = $user_id;
		$data['product_id'] = $product_id;
		$data['specification_id'] = $specification_id;
		$data['created'] = time();
		$data['modified'] = time();
		$data['state'] = 1;

		if($has){
			//更新数量
			$cart = Db::table('cart')->where(array(['user_id', $user_id],['product_id', $product_id],['specification_id', $specification_id]))->increment('quantity', $data['quantity']);
		}else{
			//插入数据库
			$cart = Db::table('cart')->insertGetId($data);
		}

		if(!$cart){
			$this->returnMessage(400,'加入失败');
		}

		$this->returnMessage(200,'加入成功');

	}

	public function increment(Request $request){
		$user = $this->getUser();
        $user_id = $user['id'];

		$product_id = (int)$request->product;
		$specification_id = (int)$request->specification;

		$cart = Db::table('cart')->where(array(['user_id', $user_id],['product_id', $product_id],['specification_id', $specification_id]))->item();
		$cart_quantity = $cart['quantity'];

		//检查商品及规格
		$product = Db::table('product')->where(array(['id', $product_id],['state', 1]))->item();
		if(!$product){
			$this->returnMessage(400,'该商品已下架');
		}

		$specification = Db::table('product_specification')->where(array(['id', $specification_id],['product_id', $product_id]))->item();
		if($specification_id>0 && !$specification){
			$this->returnMessage(400,'该商品规格已下架');
		}

		//检查库存
		if($specification){
			$quantity = $specification['quantity'];
		}else{
			$quantity = $product['quantity'];
		}
		if($quantity < floatval($cart_quantity + 1)){
			$this->returnMessage(400,'库存不足，仅剩'.$quantity.'个');
		}

		//更新数据库
		$result = Db::table('cart')->where(array(['user_id', $user_id],['product_id', $product_id],['specification_id', $specification_id]))->increment('quantity', 1);

		if(!$result){
			$this->returnMessage(200,'增加失败');
		}

		$this->returnMessage(200,'增加成功');
	}

	public function decrement(Request $request){
		$user = $this->getUser();
        $user_id = $user['id'];

		$product_id = (int)$request->product;
		$specification_id = (int)$request->specification;

		$cart = Db::table('cart')->where(array(['user_id', $user_id],['product_id', $product_id],['specification_id', $specification_id]))->item();
		$cart_quantity = $cart['quantity'];

		//检查商品及规格
		$product = Db::table('product')->where(array(['id', $product_id],['state', 1]))->item();
		if(!$product){
			$this->returnMessage(400,'该商品已下架');
		}

		$specification = Db::table('product_specification')->where(array(['id', $specification_id],['product_id', $product_id]))->item();
		if($specification_id>0 && !$specification){
			$this->returnMessage(400,'该商品规格已下架');
		}

		//检查库存
		if($specification){
			$quantity = $specification['quantity'];
		}else{
			$quantity = $product['quantity'];
		}
		if($quantity < floatval($cart_quantity - 1)){
			Db::table('cart')->where(array(['user_id', $user_id],['product_id', $product_id],['specification_id', $specification_id]))->update(['quantity' => $quantity]);
			$this->returnMessage(200,'超出库存，已增加最大值',array('quantity'=>$quantity));
		}

		//更新数据库
		$result = Db::table('cart')->where(array(['user_id', $user_id],['product_id', $product_id],['specification_id', $specification_id]))->decrement('quantity', 1);

		if(!$result){
			$this->returnMessage(400,'增加失败');
		}
		
		$this->returnMessage(200,'增加成功');
	}

	public function delete(Request $request){
		$user = $this->getUser();
        $user_id = $user['id'];

		$product_id = (int)$request->product;
		$specification_id = (int)$request->specification;

		$result = Db::table('cart')->where(array(['user_id', $user_id],['product_id', $product_id],['specification_id', $specification_id]))->delete();
		if(!$result){
			$this->returnMessage(400,'删除失败');
		}
		
		$this->returnMessage(200,'删除成功');
	}

}
