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

class User extends Common{

	//密码确认，密码/邮箱/手机修改前需确认登录密码
	public function confirmation(Request $request){
    	$data['user'] = auth()->user();

    	//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.confirmation', $data);
	}

	//密码确认验证
	public function confirmationAuth(Request $request){
    	//获取指定值
    	$params = $request->only(['password']);
    	//验证数据格式
    	$this->validator($params);

    	//获取当前用户
    	$user = auth()->user();
    	$user_username = $user['username'];
    	$user_password = $user['password'];

    	//获取传入值
    	$input_password = trim($request->password);

    	//验证密码是否匹配
    	if(\Hash::check($input_password, $user_password)){
    		//开启SESSION
	   		if(!session_id()) session_start();

	   		//储存SESSION
	   		$_SESSION[$user_username.'_confirmation_auth'] = 1;
	   		$this->returnMessage(200,'验证成功');
    	}else{
    		$this->returnMessage(400,'密码错误');
    	}
    }

    //邮箱修改
	public function email(Request $request){
		//获取当前用户
    	$data['user'] = auth()->user();
    	$username = $data['user']['username'];

    	//获取页面Uri，用于回调
    	$redirect_url = $request->getUri();

    	//判断是否已经密码确认验证
    	if(!session_id()) session_start();
        if(!isset($_SESSION[$username.'_confirmation_auth']) || $_SESSION[$username.'_confirmation_auth'] != 1){
            return redirect('/user/confirmation?redirect_url='.urlencode($redirect_url));
        }

    	//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.email', $data);
	}

	//邮箱修改储存
	public function emailStore(Request $request){
		//验证数据格式
		$this->validator($request->all());

		//获取当前用户
    	$user = auth()->user();
    	$user_id = $user->id;
    	$user_username = $user->username;

    	//获取传入值
    	$email = trim($request->email);
		$email_code = trim($request->email_code);

		//验证验证码
    	$this->checkEmailCode($email, $email_code);

    	//设置更新数据库的值
		$data['email'] = $email;
		$data['modified'] = time();

		//更新数据库
		$res = Db::table('user')->where('id',$user_id)->update($data);

		//更新失败
		if(!$res){
			$this->returnMessage(400,'保存失败');
		}

		//开启SESSION
		if(!session_id()) session_start();

		//判断并删除SESSION
        if(isset($_SESSION[$user_username.'_confirmation_auth'])){
            unset($_SESSION[$user_username.'_confirmation_auth']);
        }
        if(isset($_SESSION[$email.'_email_code'])){
            unset($_SESSION[$email.'_email_code']);
        }

        //返回信息
		$this->returnMessage(200,'保存成功');
	}

	//修改密码
	public function password(Request $request){
		//获取当前用户信息
    	$data['user'] = auth()->user();
    	$username = $data['user']['username'];

    	//获取页面Uri，用于回调
    	$redirect_url = $request->getUri();

    	//判断是否已经密码确认验证
    	if(!session_id()) session_start();
        if(!isset($_SESSION[$username.'_confirmation_auth']) || $_SESSION[$username.'_confirmation_auth'] != 1){
            return redirect('/user/confirmation?redirect_url='.urlencode($redirect_url));
        }

    	//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.password', $data);
	}

	//密码修改储存
	public function passwordStore(Request $request){
		//验证数据格式
		$this->validator($request->all());

		//获取当前用户
    	$user = auth()->user();
    	$user_id = $user->id;
    	$user_username = $user->username;

    	//获取传入值
    	$password = trim($request->password);

    	//设置更新数据库的值
		$data['password'] = bcrypt($password);
		$data['modified'] = time();

		//更新数据库
		$res = Db::table('user')->where('id',$user_id)->update($data);

		//更新失败
		if(!$res){
			$this->returnMessage(400,'保存失败');
		}

		//开启SESSION
		if(!session_id()) session_start();

		//判断并删除SESSION
        if(isset($_SESSION[$user_username.'_confirmation_auth'])){
            unset($_SESSION[$user_username.'_confirmation_auth']);
        }

        //返回信息
		$this->returnMessage(200,'保存成功');
	}

	//头像修改
	public function avatar(Request $request){
		//获取当前用户
    	$data['user'] = auth()->user();

    	//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.avatar', $data);
	}

	//头像修改储存
	public function avatarStore(Request $request){
		//获取指定值
    	$params = $request->only(['avatar']);

		//验证数据格式
		$this->validator($params);

    	$user_id = auth()->user()->id;
		$data['avatar'] = trim($request->avatar);

		$data['modified'] = time();
		$res = Db::table('user')->where('id',$user_id)->update($data);

		if(!$res){
			$this->returnMessage(400,'保存失败');
		}
		$this->returnMessage(200,'保存成功');
	}

	//性别修改储存
	public function sexStore(Request $request){
    	//获取指定值
    	$params = $request->only(['sex']);
    	if(!$params){
    		$this->returnMessage(400,'参数错误');
    	}

		//验证数据格式
		$this->validator($params);

		//用户信息
    	$user = $this->getUser();
        $user_id = $user['id'];

        //参数设置
		$data['sex'] = (int)$request->sex;
		$data['modified'] = time();

		//更新信息
		$res = Db::table('user')->where('id',$user_id)->update($data);

		//返回信息
		if(!$res){
			$this->returnMessage(400,'保存失败');
		}
		$this->returnMessage(200,'保存成功');
	}

	//年龄修改储存
	public function ageStore(Request $request){
		//获取指定值
    	$params = $request->only(['age']);
    	if(!$params){
    		$this->returnMessage(400,'参数错误');
    	}

		//验证数据格式
		$this->validator($params);

		//用户信息
    	$user = $this->getUser();
        $user_id = $user['id'];

        //参数设置
		$data['age'] = (int)$request->age;
		$data['modified'] = time();

		//更新信息
		$res = Db::table('user')->where('id',$user_id)->update($data);

		//返回信息
		if(!$res){
			$this->returnMessage(400,'保存失败');
		}
		$this->returnMessage(200,'保存成功');
	}

	//收货地址列表
	public function address(Request $request){
		//用户信息
		$user = $this->getUser();
        $user_id = $user['id'];

        //获取列表
    	$data['address'] = Db::table('user_address')->where(array(['user_id', $user_id],['state', 1]))->orderBy('id','desc')->lists();

    	//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		//返回信息
		$this->returnMessage(200,'成功', $data);
	}
	
	//收获地址详情
	public function addressShow(Request $request){
		//获取参数
		$id = (int)$request->id;

		//用户信息
		$user = $this->getUser();
        $user_id = $user['id'];

        //获取详情
		$data['address'] = Db::table('user_address')->where(array(['id', $id],['user_id', $user_id]))->orderBy('id','desc')->item();

		//不存在
		if($id!=0 && !$data['address']){
			$this->returnMessage(400,'失败');
		}

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		//返回信息
		$this->returnMessage(200,'成功', $data);
	}

	//收获地址储存
	public function addressStore(Request $request){
		//获取参数
		$id = (int)$request->id;

		//用户信息
		$user = $this->getUser();
        $user_id = $user['id'];

        //参数设置
		$data['name'] = trim($request->name);
		$data['phone'] = trim($request->phone);
		$data['content'] = trim($request->content);
		$data['default'] = (int)$request->default;

		//是否默认
		if($data['default']){
			Db::table('user_address')->where('user_id',$user_id)->update(['default' => 0]);
		}

		//更新或插入
		if($id){
			$data['modified'] = time();
			$res = Db::table('user_address')->where('id',$id)->update($data);
		}else{
			$data['user_id'] = $user_id;
			$data['created'] = time();
			$data['state'] = 1;
			$res = Db::table('user_address')->insertGetId($data);
		}

		//返回信息
		$this->returnMessage(200,'保存成功');
	}

	//订单列表
	public function order(Request $request){
		//获取参数
		$state = (int)$request->state;

		//用户信息
		$user = $this->getUser();

		//查询参数
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

		//页码参数
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

		//获取列表
    	$data = Db::table('order')->where($where)->orderBy('id','desc')->pages();

    	//分拣订单ID
    	$order_id = array_column($data['lists'], 'id');
    	
    	//获取订单商品
    	$products = Db::table('order_product')->whereIn('order_id', $order_id)->lists();
    	foreach ($data['lists'] as &$value) {
            list($value['products']) = [[]];
            foreach ($products as $product) {
            	$product['picture'] = config('app.url').$product['picture'];
            	if ($product['order_id'] === $value['id']) {
            		array_push($value['products'], $product);
            	}
            }
        }

        //SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		//返回信息
		$this->returnMessage(200,'成功', $data);
	}

	//订单详情
	public function orderShow(Request $request){
		//获取参数
		$id = (int)$request->id;

		//用户信息
		$user = $this->getUser();
		$user_id = $user['id'];

		//获取详情
		$order = Db::table('order')->where(array(['id', $id],['user_id', $user_id]))->orderBy('id','desc')->item();

		//不存在
		if(!$order){
			$this->returnMessage(400,'失败');
		}

		//获取订单商品
		$order['products'] = Db::table('order_product')->where(array(['order_id', $order['id']]))->orderBy('id','desc')->lists();

		//格式化参数
		foreach ($order['products'] as $key => $value) {
			$order['products'][$key]['picture'] = config('app.url').$order['products'][$key]['picture'];
		}
		$order['created'] = date('Y-m-d H:i:s', $order['created']);
		$order['prepaid'] = $order['prepaid'] ? date('Y-m-d H:i:s', $order['prepaid']) : $order['prepaid'];
		$order['shipped'] = $order['shipped'] ? date('Y-m-d H:i:s', $order['shipped']) : $order['shipped'];
		$order['received'] = $order['received'] ? date('Y-m-d H:i:s', $order['received']) : $order['received'];

		//赋值
		$data['order'] = $order;

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		//返回信息
		$this->returnMessage(200,'成功', $data);
	}

	//订单确认收货
	public function orderStore(Request $request){
		$id = (int)$request->id;
		$user = auth()->user();
		$user_id = $user->id;

		//验证订单及状态
		$order = Db::table('order')->where(array(['id', $id],['user_id', $user_id],['state', 3]))->item();

		if(!$order){
			$this->returnMessage(400,'订单不存在或已确认收货，请刷新页面重试');
		}

		$data['state'] = 5;
		$data['received'] = time();

		Db::table('order')->where(array(['id', $id],['user_id', $user_id],['state', 3]))->update($data);
		$this->returnMessage(200,'确认成功，感谢您的惠顾');
	}

	//我喜欢的
	public function like(Request $request){
		
		$label = (int)$request->label;

		//用户信息
		$user = $this->getUser();
    	$user_id = $user['id'];

    	//用户折扣
    	$user_discount = $this->getUserDiscount();

    	//查询参数
		$where = [];
		$where[] = ['user_id', '=', $user_id];
		$where[] = ['state', '=', 1];
		if($label == 0 || $label == 2){
			$where[] = ['product_id', '>', 0];
		}else{
			$where[] = ['article_id', '>', 0];
		}

		//页码参数
		$appends = [];
		if($label == 0 || $label == 2){
			$appends['label'] = 2;
		}else{
			$appends['label'] = 1;
		}

		//获取列表
		$likes = Db::table('user_like')->where($where)->lists();

		if($label == 0 || $label == 2){
			$like_id = array_column($likes, 'product_id');
			$data = Db::table('product')->whereIn('id', $like_id)->orderBy('id','desc')->pages('', 12);
			foreach ($data['lists'] as $key => $value) {
				$data['lists'][$key]['picture'] = config('app.url').$data['lists'][$key]['picture'];
				$data['lists'][$key]['like'] = 1;
				$price  = $this->getProductPrice($data['lists'][$key]['selling'], $user_discount);
				$data['lists'][$key]['price'] = $price;
			}
		}else{
			$like_id = array_column($likes, 'article_id');
			$data = Db::table('article')->whereIn('id', $like_id)->orderBy('id','desc')->pages('', 12);
			foreach ($data['lists'] as $key => $value) {
				$data['lists'][$key]['picture'] = config('app.url').$data['lists'][$key]['picture'];
				$data['lists'][$key]['content'] = str_limit(strip_tags($data['lists'][$key]['content']), $limit = 120, $end = '...');
				$data['lists'][$key]['like'] = 1;
			}
		}
        //exit(print_r($data));	

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		$this->returnMessage(200, '成功', $data);
	}

	//我喜欢的
	public function likeStore(Request $request){
		//获取当前用户
    	$user = auth()->user();
    	$user_id = $user->id;

    	//获取传入值
    	$id = (int)$request->id;
    	$type = trim($request->type);

    	$like_id = 'article_id';

    	if($type == 'product'){
    		$like_id = 'product_id';
    	}

    	//已经喜欢了
		$has_like = Db::table('user_like')->where(array(['user_id', $user_id],[$like_id, $id],['state', 1]))->item();
		if($has_like){
			$data['state'] = 0;
			Db::table('user_like')->where(array(['user_id', $user_id],[$like_id, $id],['state', 1]))->update($data);
			$this->returnMessage(20000,'不喜欢了');
		}

		//已经不喜欢了
		$has_hate = Db::table('user_like')->where(array(['user_id', $user_id],[$like_id, $id],['state', 0]))->item();
		if($has_hate){
			$data['state'] = 1;
			Db::table('user_like')->where(array(['user_id', $user_id],[$like_id, $id],['state', 0]))->update($data);
			$this->returnMessage(20001,'喜欢了');
		}

		//两个都没有
		$data['user_id'] = $user_id;
		$data[$like_id] = $id;
		$data['state'] = 1;
		Db::table('user_like')->insertGetId($data);
		$this->returnMessage(20001,'喜欢了');

	}

}
