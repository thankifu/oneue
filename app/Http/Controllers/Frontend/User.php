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

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class User extends Common
{
	public function __construct(Request $request){
        
    }
    //
    public function index(Request $request){
    	$data['user'] = auth()->user();
		//$data = Db::table('article')->where('state', 1)->orderBy('id','desc')->pages('', 12);
		return view('frontend.user.index', $data);
	}

	public function center(Request $request){
    	$data = [];
		return view('frontend.user.center', $data);
	}

	public function setting(Request $request){
    	$data = [];
    	$data['user'] = auth()->user();
		return view('frontend.user.setting', $data);
	}

	public function address(Request $request){
		$data['user'] = auth()->user();
    	$data['address'] = Db::table('user_address')->where(array(['user_id', $data['user']['id']],['state', 1]))->orderBy('id','desc')->lists();
		return view('frontend.user.address.index', $data);
	}
	
	public function addressItem(Request $request){
		$id = (int)$request->id;

		$data['user'] = auth()->user();
		$data['address'] = Db::table('user_address')->where(array(['id', $id],['user_id', $data['user']['id']]))->orderBy('id','desc')->item();

		if($id!=0 && !$data['address']){
			return redirect('/user/address');
		}

		return view('frontend.user.address.item', $data);
	}

	public function addressStore(Request $request){
		$user_id = auth()->user()->id;
		$id = (int)$request->id;
		$data['name'] = trim($request->name);
		$data['phone'] = trim($request->phone);
		$data['content'] = trim($request->content);
		$data['default'] = (int)$request->default;

		if($data['default']){
			Db::table('user_address')->where('user_id',$user_id)->update(['default' => 0]);
		}

		if($id){
			$data['modified'] = time();
			$res = Db::table('user_address')->where('id',$id)->update($data);
		}else{
			$data['user_id'] = $user_id;
			$data['created'] = time();
			$data['state'] = 1;
			$res = Db::table('user_address')->insertGetId($data);
		}
		$this->returnMessage(200,'保存成功');
	}

	public function order(Request $request){
		$user = auth()->user();
		$state = (int)$request->state;

		$where = [];
		$where[] = ['user_id', '=', $user['id']];
		if(isset($request->state) && $state == 1){
			$where[] = ['state', '=', 1];
		}
		if(isset($request->state) && $state == 2){
			$where[] = ['state', '=', 2];
		}
		if(isset($request->state) && $state == 3){
			$where[] = ['state', '=', 3];
		}
		if(isset($request->state) && $state == 4){
			$where[] = ['state', '=', 4];
		}
		if(isset($request->state) && $state == 5){
			$where[] = ['state', '=', 5];
		}

		$appends = [];
		if(isset($request->state) && $state == 1){
			$appends['state'] = 1;
		}
		if(isset($request->state) && $state == 2){
			$appends['state'] = 2;
		}
		if(isset($request->state) && $state == 3){
			$appends['state'] = 3;
		}
		if(isset($request->state) && $state == 4){
			$appends['state'] = 4;
		}
		if(isset($request->state) && $state == 5){
			$appends['state'] = 5;
		}

    	$data = Db::table('order')->where($where)->orderBy('id','desc')->pages();

    	$order_id = array_column($data['lists'], 'id');
    	$products = Db::table('order_product')->whereIn('order_id', $order_id)->lists();

    	foreach ($data['lists'] as &$value) {
            list($value['products']) = [[]];
            foreach ($products as $product) {
            	if ($product['order_id'] === $value['id']) {
            		array_push($value['products'], $product);
            	}
            }
        }
        $data['user'] = $user;
        
        /*print_r($orders);
        exit();*/
		return view('frontend.user.order.index', $data);
	}

	public function orderItem(Request $request){
		$id = (int)$request->id;

		$data['user'] = auth()->user();
		$data['order'] = Db::table('order')->where(array(['id', $id],['user_id', $data['user']['id']]))->orderBy('id','desc')->item();
		$data['products'] = Db::table('order_product')->where(array(['order_id', $data['order']['id']]))->orderBy('id','desc')->lists();

		if(!$data['order']){
			return redirect('/user/order');
		}

		return view('frontend.user.order.item', $data);
	}

}
