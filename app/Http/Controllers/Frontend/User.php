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
    
    //用户中心
    public function index(Request $request){
    	$data['user'] = auth()->user();
		//$data = Db::table('article')->where('state', 1)->orderBy('id','desc')->pages('', 12);

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.index', $data);
	}

	//账户设置
	public function setting(Request $request){
    	$data['user'] = auth()->user();

    	//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.setting', $data);
	}

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

	//性别修改储存
	public function sexStore(Request $request){
    	$user_id = auth()->user()->id;
		$data['sex'] = (int)$request->sex;

		$data['modified'] = time();
		$res = Db::table('user')->where('id',$user_id)->update($data);

		if(!$res){
			$this->returnMessage(400,'保存失败');
		}
		$this->returnMessage(200,'保存成功');
	}

	//年龄修改储存
	public function ageStore(Request $request){
    	$user_id = auth()->user()->id;
		$data['age'] = (int)$request->age;

		$data['modified'] = time();
		$res = Db::table('user')->where('id',$user_id)->update($data);

		if(!$res){
			$this->returnMessage(400,'保存失败');
		}
		$this->returnMessage(200,'保存成功');
	}

	//收货地址列表
	public function address(Request $request){
		$data['user'] = auth()->user();
    	$data['address'] = Db::table('user_address')->where(array(['user_id', $data['user']['id']],['state', 1]))->orderBy('id','desc')->lists();

    	//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.address.index', $data);
	}
	
	//收获地址详情
	public function addressItem(Request $request){
		$id = (int)$request->id;

		$data['user'] = auth()->user();
		$data['address'] = Db::table('user_address')->where(array(['id', $id],['user_id', $data['user']['id']]))->orderBy('id','desc')->item();

		if($id!=0 && !$data['address']){
			return redirect('/user/address');
		}

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.address.item', $data);
	}

	//收获地址储存
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

	//订单列表
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

        //SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.order.index', $data);
	}

	//订单详情
	public function orderItem(Request $request){
		$id = (int)$request->id;

		$data['user'] = auth()->user();
		$data['order'] = Db::table('order')->where(array(['id', $id],['user_id', $data['user']['id']]))->orderBy('id','desc')->item();
		$data['products'] = Db::table('order_product')->where(array(['order_id', $data['order']['id']]))->orderBy('id','desc')->lists();

		if(!$data['order']){
			return redirect('/user/order');
		}

		//SEO优化
		$site = $this->getSeting('site')['value'];
		$data['page_title'] = '我的 - '.$site['name'];
		$data['page_keywords'] = '我的,'.$site['name'];
		$data['page_description'] = '';

		return view('frontend.user.order.item', $data);
	}

}
