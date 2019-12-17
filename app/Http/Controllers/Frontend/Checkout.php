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
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Checkout extends Common
{
    //
    public function index(Request $request){
    	if(!auth()->user()){
            $this->returnMessage(400,'未登录');
        }

        $user_id = auth()->user()->id;

    	$id = (int)$request->id;
    	$data['checkout'] = Db::table('checkout')->where(array(['user_id', $user_id],['state', 1]))->item();
    	if(!$data['checkout']){
    		return redirect('/cart');
    	}
    	$data['address'] = Db::table('user_address')->where('id', $data['checkout']['address_id'])->item();
		$data['products'] = Db::table('checkout_product')->where(array(['checkout_id', $data['checkout']['id']],['state', 1]))->orderBy('id','desc')->lists();
		
		return view('frontend.checkout.index', $data);
	}

	public function create(Request $request){
		if(!auth()->user()){
            $this->returnMessage(400,'未登录');
        }

        $user_id = auth()->user()->id;
        $list = [];

        if(isset($request->product) && isset($request->specification) && isset($request->quantity)){
        	$product_id = (int)$request->product;
			$specification_id = (int)$request->specification;
			$quantity = (int)$request->quantity;
			$list[] = array('product_id'=>$product_id, 'specification_id'=>$specification_id, 'quantity'=>$quantity);
        }else{
	    	$cart = Db::table('cart')->where(array(['user_id', $user_id],['state', 1]))->lists();
	    	foreach ($cart as $value) {
	    		$list[] = array('product_id'=>$value['product_id'], 'specification_id'=>$value['specification_id'], 'quantity'=>$value['quantity']);
	    	}
        }

        /*echo '<pre>';
    	print_r($list);
    	exit();*/

    	$res = $this->_create($user_id, $list);
    	if($res['code'] != 200){
    		$this->returnMessage($res['code'],$res['text']);
    	}

    	$this->returnMessage($res['code'],$res['text']);
    	
	}

	//$product_id, $specification_id, $quantity
	private function _create($user_id, $list){
		$discount = $this->getUserDiscount();
		$data['quantity'] = 0;
		$data['market'] = 0;
		$data['selling'] = 0;
		$data['vip_offer'] = 0;
		$data['total'] = 0;
		foreach ($list as $key => $value) {
			//检查商品及规格
			$product = Db::table('product')->where(array(['id', $value['product_id']],['state', 1]))->item();
			if(!$product){
				return array('code'=>400, 'text'=>'该商品已下架');
			}

			$specification = Db::table('product_specification')->where(array(['id', $value['specification_id']],['product_id', $value['product_id']]))->item();
			if($value['specification_id']>0 && !$specification){
				return array('code'=>400, 'text'=>'该商品规格已下架');
			}

			//检查库存
			if($specification){
				$quantity = $specification['quantity'];
				$name = $product['name'].' - '.$specification['name'];
			}else{
				$quantity = $product['quantity'];
				$name = $product['name'];
			}
			if($quantity <= 0){
				return array('code'=>400, 'text'=>'库存不足',array('name'=>$name));
			}
			if($quantity < $value['quantity']){
				return array('code'=>400, 'text'=>'库存不足，仅剩'.$quantity.'个',array('name'=>$name));
			}

			//设置参数
			if($specification){
				$list[$key]['name'] = $product['name'].' - '.$specification['name'];
				$list[$key]['picture'] = !empty($specification['picture'])?$specification['picture']:$product['picture'];
				$list[$key]['market'] = $specification['market'];
				$list[$key]['selling'] = $specification['selling'];
				$list[$key]['price'] = $this->getProductPrice($list[$key]['selling'], $discount);
				$list[$key]['vip_offer'] = number_format(floatval($list[$key]['selling']) - floatval($list[$key]['price']), 2, '.', '');
				$list[$key]['quantity'] = $value['quantity'];
				$list[$key]['subtotal'] = number_format(floatval($list[$key]['price']) * floatval($list[$key]['quantity']), 2, '.', '');
				$list[$key]['user_id'] = $user_id;
				$list[$key]['state'] = 1;				
			}else{
				$list[$key]['name'] = $product['name'];
				$list[$key]['picture'] = $product['picture'];
				$list[$key]['market'] = $product['market'];
				$list[$key]['selling'] = $product['selling'];
				$list[$key]['price'] = $this->getProductPrice($list[$key]['selling'], $discount);
				$list[$key]['vip_offer'] = number_format(floatval($list[$key]['selling']) - floatval($list[$key]['price']), 2, '.', '');
				$list[$key]['quantity'] = $value['quantity'];
				$list[$key]['subtotal'] = number_format(floatval($list[$key]['price']) * floatval($list[$key]['quantity']), 2, '.', '');
				$list[$key]['user_id'] = $user_id;
				$list[$key]['state'] = 1;
			}

			$data['quantity'] += floatval($list[$key]['quantity']);
			$data['market'] += number_format(floatval($list[$key]['market']) * floatval($list[$key]['quantity']), 2, '.', '');
			$data['selling'] += number_format(floatval($list[$key]['selling']) * floatval($list[$key]['quantity']), 2, '.', '');
			$data['vip_offer'] += number_format(floatval($list[$key]['vip_offer']) * floatval($list[$key]['quantity']), 2, '.', '');
			$data['total'] += number_format(floatval($list[$key]['subtotal']), 2, '.', '');
		}

		//获取用户默认地址
		$user_address = Db::table('user_address')->where(array(['user_id',$user_id],['default', 1]))->item();
		if($user_address){
			$address_id = $user_address['id'];
		}else{
			$address_id = 0;
		}
		
		$data['freight'] = 0;
		$data['money'] = number_format(floatval($data['total']) + floatval($data['freight']), 2, '.', '');
		$data['user_id'] = $user_id;
		$data['address_id'] = $address_id;
		$data['created'] = time();
		$data['modified'] = time();
		$data['state'] = 1;

		/*echo '<pre>';
    	print_r($data);
    	exit();*/

		//检查是否存在结算ID
		$has = Db::table('checkout')->where(array(['user_id',$user_id],['state', 1]))->item();
		if($has){
			//更新数据库
			Db::table('checkout')->where(array(['user_id', $user_id],['state', 1]))->update($data);
			$checkout = $has['id'];
		}else{
			//插入数据库
			$checkout = Db::table('checkout')->insertGetId($data);
		}

		if($checkout){
			$data_product['checkout_id'] = $checkout;
			Db::table('checkout_product')->where(array(['user_id', $user_id]))->delete();
		}

		foreach ($list as $value) {
			$data_product['name'] = $value['name'];
			$data_product['picture'] = $value['picture'];
			$data_product['market'] = $value['market'];
			$data_product['selling'] = $value['selling'];
			$data_product['price'] = $value['price'];
			$data_product['vip_offer'] = $value['vip_offer'];
			$data_product['quantity'] = $value['quantity'];
			$data_product['subtotal'] = $value['subtotal'];
			$data_product['user_id'] = $value['user_id'];
			$data_product['product_id'] = $value['product_id'];
			$data_product['specification_id'] = $value['specification_id'];
			$data_product['state'] = $value['state'];

			//插入数据库
			$checkout_product = Db::table('checkout_product')->insertGetId($data_product);
		}

		if(!$checkout_product){
			return array('code'=>400, 'text'=>'结算失败');
		}

		return array('code'=>200, 'text'=>'正在跳转');
	}

	public function address(Request $request){

	}

	/*public function create(Request $request){
		if(!auth()->user()){
            $this->returnMessage(400,'未登录');
        }

        $user_id = auth()->user()->id;

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

		//检查库存
		if($specification){
			$quantity = $specification['quantity'];
		}else{
			$quantity = $product['quantity'];
		}
		if($quantity <= 0){
			$this->returnMessage(400,'库存不足');
		}
		if($quantity < $data['quantity']){
			$this->returnMessage(400,'库存不足，仅剩'.$quantity.'个');
		}

		//获取用户默认地址
		$user_address = Db::table('user_address')->where(array(['user_id',$user_id],['default', 1]))->item();
		if($user_address){
			$address_id = $user_address['id'];
		}else{
			$address_id = 0;
		}

		//设置参数
		if($specification){
			$data_product['name'] = $product['name'].' - '.$specification['name'];
			$data_product['picture'] = !empty($specification['picture'])?$specification['picture']:$product['picture'];
			$data_product['market'] = $specification['market'];
			$data_product['selling'] = $specification['selling'];
			$data_product['price'] = $this->getProductPrice($data_product['selling']);
			$data_product['vip_offer'] = number_format(floatval($data_product['selling']) - floatval($data_product['price']), 2, '.', '');
			$data_product['quantity'] = $data['quantity'];
			$data_product['subtotal'] = number_format(floatval($data_product['price']) * floatval($data_product['quantity']), 2, '.', '');
			$data_product['user_id'] = $user_id;
			$data_product['product_id'] = $product_id;
			$data_product['specification_id'] = $specification_id;
			$data_product['state'] = 1;
		}else{
			$data_product['name'] = $product['name'];
			$data_product['picture'] = $product['picture'];
			$data_product['market'] = $product['market'];
			$data_product['selling'] = $product['selling'];
			$data_product['price'] = $this->getProductPrice($data_product['selling']);
			$data_product['vip_offer'] = number_format(floatval($data_product['selling']) - floatval($data_product['price']), 2, '.', '');
			$data_product['quantity'] = $data['quantity'];
			$data_product['subtotal'] = number_format(floatval($data_product['price']) * floatval($data_product['quantity']), 2, '.', '');
			$data_product['user_id'] = $user_id;
			$data_product['product_id'] = $product_id;
			$data_product['specification_id'] = $specification_id;
			$data_product['state'] = 1;
		}

		$data['market'] = number_format(floatval($data_product['market']) * floatval($data_product['quantity']), 2, '.', '');
		$data['selling'] = number_format(floatval($data_product['selling']) * floatval($data_product['quantity']), 2, '.', '');
		$data['vip_offer'] = number_format(floatval($data_product['vip_offer']) * floatval($data_product['quantity']), 2, '.', '');
		$data['total'] = $data_product['subtotal'];
		$data['freight'] = 0;
		$data['money'] = number_format(floatval($data['total']) + floatval($data['freight']), 2, '.', '');
		$data['user_id'] = $user_id;
		$data['address_id'] = $address_id;
		$data['created'] = time();
		$data['modified'] = time();
		$data['state'] = 1;

		//插入数据库
		$checkout = Db::table('checkout')->insertGetId($data);

		if($checkout){
			$data_product['checkout_id'] = $checkout;
			$checkout_product = Db::table('checkout_product')->insertGetId($data_product);
		}

		if(!$checkout_product){
			$this->returnMessage(400,'结算失败');
		}

		$this->returnMessage(200,'请您付款');
		
	}*/

}
