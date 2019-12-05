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
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Config;

class Setting extends Common
{
    // 基础配置
	public function index(){
		$data = $this->_getSeting('site');
		return view('backend/setting/index',$data);
	}

	//附件配置
	public function annex(){
		$data = $this->_getSeting('annex');
		return view('backend/setting/annex',$data);
	}

	// seo设置
	public function seo(){
		$data = $this->_getSeting('site_seo');
		return view('backend/setting/seo',$data);
	}

	// 安全配置
	public function security(){
		$data = $this->_getSeting('set_security');
		return view('backend/setting/security',$data);
	}

	// 微信公众号配置
	public function wechat(){
		$data = $this->_getSeting('site_wechat');
		return view('backend/setting/wechat',$data);
	}

	// 邮箱配置
	public function email(){
		$data = $this->_getSeting('site_email');
		return view('backend/setting/email',$data);
	}

	//短信配置
	public function sms(Request $request){
		if($request->isMethod('post')){
			$data = $request->all();
			$keys = $data['__keys'];
			unset($data['__keys']);
			unset($data['_token']);
			Db::table('admin_setting')->where(array('keys'=>$keys))->delete();
			//处理数据
			$add = [];
			foreach($data as $v){
				if(!$v[0] || !$v[1]){
					exit(json_encode(array('code'=>1,'msg'=>'提交失败，表单有空值')));
				}
				$add[$v[0]] = $v[1];
			}
			Db::table('admin_setting')->insert(array('keys'=>$keys,'values'=>json_encode($add)));
			exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
		}else{
			$data = $this->_getSeting('site_sms');
			return view('backend/setting/sms',$data);
		}
	}

	

	//检测GD库
	public function checkGd(){
		if(function_exists('gd_info')) {
            $gd_info = @gd_info();
	        $msg = '<!--<font color="red">√</font> -->GD库已开启<br/>版本为：'.$gd_info["GD Version"];
	        $code = 0;
	    }else{
	    	$msg = '<!--<font color="red">×</font> -->GD库未开启';
	    	$code = 1;
	    }
	    exit(json_encode(array('code'=>$code,'msg'=>$msg)));
	}

	//检测邮件设置
	public function checkEmail(Request $request){
		$send_type = [1=>'SMTP',2=>'MAIL'];
		$encryption = [1=>'TLS',2=>'SSL'];
		if(!isset($send_type[$request->send_type])){
			exit(json_encode(array('code'=>1,'msg'=>'请选择邮件发送模式')));
		}
		if($request->send_type != 1){
			exit(json_encode(array('code'=>1,'msg'=>'当前测试模块只支持STMP模式')));
		}
		if(!$request->server_address){
			exit(json_encode(array('code'=>1,'msg'=>'邮件服务器不能为空')));
		}
		if(!$request->port){
			exit(json_encode(array('code'=>1,'msg'=>'请输入邮件发送端口号')));
		}
		if(!isset($encryption[$request->encryption])){
			exit(json_encode(array('code'=>1,'msg'=>'请选择加密方式')));
		}
		if(!$request->check_user){
			exit(json_encode(array('code'=>1,'msg'=>'请输入用户名')));
		}
		if(!$request->check_pwd){
			exit(json_encode(array('code'=>1,'msg'=>'请输入密码')));
		}
		if(!$request->name){
			exit(json_encode(array('code'=>1,'msg'=>'请输入发件人名称')));
		}
		if(!$request->from_address){
			exit(json_encode(array('code'=>1,'msg'=>'请输入发件人地址')));
		}
		if(!$request->subject){
			exit(json_encode(array('code'=>1,'msg'=>'请输入邮件标题')));
		}
		if(!$request->content){
			exit(json_encode(array('code'=>1,'msg'=>'请输入邮件内容')));
		}
		if(!$request->to){
			exit(json_encode(array('code'=>1,'msg'=>'请输入收件人地址')));
		}
		//邮件发送模式 smtp或mail模块
		Config::set('mail.driver', $send_type[$request->send_type]);
		//邮件服务器
		Config::set('mail.host', $request->server_address);
		//端口号
		Config::set('mail.port', $request->port);
		//加密方式 ssl或tls
		Config::set('mail.encryption', $encryption[$request->encryption]);
		//用户名
		Config::set('mail.username', $request->check_user);
		//密码
		Config::set('mail.password', $request->check_pwd);
		//发件人
		Config::set('mail.from.name', $request->name);
		//发件人邮箱地址
		Config::set('mail.from.address', $request->from_address);
		//邮箱测试标题
		$this->subject = $request->subject;
		//邮箱测试内容
		$this->content = $request->content;
		//邮箱收件人
		$this->to = $request->to;
        // Mail::send()的返回值为空，所以可以其他方法进行判断
        Mail::raw($this->content,function($message){
            $message ->to($this->to)->subject($this->subject);
        });
        // 返回的一个错误数组，利用此可以判断是否发送成功
        if(count(Mail::failures()) < 1){
            exit(json_encode(array('code'=>0,'msg'=>'邮件发送成功，请查收！')));
        }else{
            exit(json_encode(array('code'=>1,'msg'=>'邮件发送失败，请重试！')));
        }
	}

	// 根据key获取配置详情
	private function _getSeting($key){
		$data = Db::table('admin_setting')->where(array('key'=>$key))->item();
		/*echo '<pre>';
		print_r($data);
		die();*/
		$data['value'] && $data['value'] = json_decode($data['value'],true);
		!$data['value'] && $data['value'] = false;
		return $data;
	}

	// 保存设置
	public function save(Request $request){
		$data = $request->all();
		$key = $data['key'];
		unset($data['key']);
		unset($data['_token']);
		$is = Db::table('admin_setting')->where(array('key'=>$key))->item();
		if($is){
			Db::table('admin_setting')->where(array('key'=>$key))->update(array('value'=>json_encode($data)));
		}else{
			Db::table('admin_setting')->insert(array('key'=>$key,'value'=>json_encode($data)));
		}

		if($key === 'site'){
			$log = '修改网站设置。';
		}
		if($key === 'annex'){
			$log = '修改附件设置。';
		}

		//添加操作日志
		$this->log($log);

		$this->returnMessage(200,'保存成功');
	}	

}
