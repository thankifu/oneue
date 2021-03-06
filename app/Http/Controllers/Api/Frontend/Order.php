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

class Order extends Common
{

	public function create(Request $request){
        $user = $this->getUser();
        $user_id = $user['id'];

        $payment_type = trim($request->payment_type);

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
        if(!$user_address){
            $this->returnMessage(400,'请填写收获地址');
        }

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
            //如果存在规格，更新规格库存
			if($data_product['specification_id']>0){
				Db::table('product_specification')->where('id',$value['specification_id'])->decrement('quantity', $data_product['quantity']);
			}

            //更新销量
            DB::table('product')->where('id',$value['product_id'])->increment('volume', $data_product['quantity']);

			//删除购物车
			Db::table('cart')->where(array(['user_id',$value['user_id']],['product_id',$value['product_id']],['specification_id',$value['specification_id']]))->delete();
        }

        if(!$order_product){
			$this->returnMessage(400,'下单商品失败');
		}

		//删除结算台
		Db::table('checkout')->where('id',$checkout['id'])->delete();
		Db::table('checkout_product')->where('checkout_id',$checkout['id'])->delete();

        $return_data['id'] = $order;
		$this->returnMessage(200,'下单成功',$return_data);

        /*echo '<pre>';
        print_r($data);
        print_r($checkout_product);*/

	}

    public function paid(Request $request){
        $id = (int)$request->id;
        $user_id = auth()->user()->id;
        $order = Db::table('order')->where(['id' => $id,'user_id' => $user_id])->item();
        if(!$order){
            $this->returnMessage(400,'订单参数错误');
        }
        if($order['state'] !== 2){
            $this->returnMessage(400,'支付失败');
        }
        $this->returnMessage(200,'支付成功');
    }

}
