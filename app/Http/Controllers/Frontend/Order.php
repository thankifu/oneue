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

class Order extends Common
{

	public function create(Request $request){
		if(!auth()->user()){
            $this->returnMessage(400,'未登录');
        }

        $user_id = auth()->user()->id;

        $payment_type = trim($request->payment);

        $checkout = Db::table('checkout')->where(array(['user_id', $user_id],['state', 1]))->item();
        $checkout_product = Db::table('checkout_product')->where(array(['checkout_id', $checkout['id']],['state', 1]))->lists();

        foreach ($checkout_product as $key => $value) {
        	//检查商品及规格
			$product = Db::table('product')->where(array(['id', $value['product_id']],['state', 1]))->item();
			if(!$product){
				$this->returnMessage(400,'该商品已下架');
			}

			$specification = Db::table('product_specification')->where(array(['id', $value['specification_id']],['product_id', $value['product_id']]))->item();
			if($value['specification_id']>0 && !$specification){
				$this->returnMessage(400,'该商品规格已下架');
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
				$this->returnMessage(400,'库存不足',array('name'=>$name));
			}
			if($quantity < $value['quantity']){
				$this->returnMessage(400,'库存不足，仅剩'.$quantity.'个',array('name'=>$name));
			}
        }

        //获取用户默认地址
		$user_address = Db::table('user_address')->where(array(['id',$checkout['address_id']]))->item();

        $data['no'] = $this->getNumber();
        $data['quantity'] = $checkout['quantity'];
        $data['market'] = $checkout['market'];
        $data['selling'] = $checkout['selling'];
        $data['vip_offer'] = $checkout['vip_offer'];
        $data['total'] = $checkout['total'];
        $data['freight'] = $checkout['freight'];
        $data['money'] = $checkout['money'];
        $data['user_id'] = $checkout['user_id'];
        $data['address_id'] = $checkout['address_id'];
        $data['address_name'] = $user_address['name'];
        $data['address_phone'] = $user_address['phone'];
        $data['address_content'] = $user_address['content'];
        $data['payment_type'] = $payment_type;
        $data['created'] = time();
        $data['modified'] = time();
        $data['state'] = 1;

        $order = Db::table('order')->insertGetId($data);

        if(!$order){
        	$this->returnMessage(400,'下单失败');
        }

        foreach ($checkout_product as $key => $value) {
        	$data_product['name'] = $value['name'];
        	$data_product['picture'] = $value['picture'];
        	$data_product['market'] = $value['market'];
        	$data_product['selling'] = $value['selling'];
        	$data_product['vip_offer'] = $value['vip_offer'];
        	$data_product['price'] = $value['price'];
        	$data_product['quantity'] = $value['quantity'];
        	$data_product['subtotal'] = $value['subtotal'];
        	$data_product['user_id'] = $value['user_id'];
        	$data_product['order_id'] = $order;
        	$data_product['product_id'] = $value['product_id'];
        	$data_product['specification_id'] = $value['specification_id'];
        	$data_product['state'] = $value['state'];

        	//插入数据库
			$order_product = Db::table('order_product')->insertGetId($data_product);

			//更新库存
			Db::table('product')->where('id',$value['product_id'])->decrement('quantity', $data_product['quantity']);
			if($data_product['specification_id']>0){
				Db::table('product_specification')->where('id',$value['specification_id'])->decrement('quantity', $data_product['quantity']);
			}

			//删除购物车
			Db::table('cart')->where(array(['user_id',$value['user_id']],['product_id',$value['product_id']],['specification_id',$value['specification_id']]))->delete();
        }

        if(!$order_product){
			$this->returnMessage(400,'下单商品失败');
		}

		//删除结算台
		Db::table('checkout')->where('id',$checkout['id'])->delete();
		Db::table('checkout_product')->where('checkout_id',$checkout['id'])->delete();

		$this->returnMessage(200,'下单成功');

        /*echo '<pre>';
        print_r($data);
        print_r($checkout_product);*/

	}

	private function getNumber() 
	{
		//生成16位订单编号
		$number = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		return $number;
	}

}
