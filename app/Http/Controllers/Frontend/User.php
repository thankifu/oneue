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

}
