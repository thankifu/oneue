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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;
use Log;

class Wechat extends Common
{

    //认证-小程序
    public function authMiniProgram(Request $request)
    {
        $code = $request->code;
        $user = $request->userInfo;

        $app = app('wechat.mini_program');
        $wechat = $app->auth->session($code);
        $wechat_openid = $wechat['openid'];
        
        //查询用户
        $has = User::where('wechat_openid', $wechat_openid)->first();

        //校验用户是否存在，不存在则创建新用户
        if (!$has) {
            $result = User::create([
                'username' => $user['nickName'],
                'password' => bcrypt(Str::random(60)),
                'avatar' => $user['avatarUrl'],
                'wechat_openid' => $wechat_openid,
                'logined_ip' => $request->getClientIp(),
                'logined' => time(),
                'created' => time(),
                'state' => 1,
            ]);
        }else{
            User::where('wechat_openid', $wechat_openid)->update([
                'avatar' => $user['avatarUrl'],
                'wechat_openid' => $wechat_openid,
                'logined_ip' => $request->getClientIp(),
                'modified' => time(),
            ]);
            $result = $has;
        }

        $token = auth('api')->login($result);
        //exit(var_dump($token));

        if (!$token) {
            $this->returnMessage(400,'登录失败');
        }
        $data['user'] = $result->only('id', 'username', 'avatar', 'sex', 'age', 'level', 'wechat_openid');
        $level = Db::table('user_level')->select(['name'])->where('id', $data['user']['id'])->item();
        if($level){
            $data['user']['level_name'] = $level['name'];
        }
        $data['user']['token'] = $token;
        $this->returnMessage(200,'登录成功',$data);

    }

    //支付-小程序
    public function paymentMiniProgram(Request $request)
    {
        //判断ID
        $id = (int)$request->id;
        if($id<=0){
            $this->returnMessage(400,'订单参数错误');
        }

        //获取订单信息
        $order = Db::table('order')->where(['id' => $id,'state' => 1])->item();
        if(!$order){
            $this->returnMessage(400,'订单参数错误');
        }

        //支付类型
        $order['payment_type'] = 'wechat-jsapi';

        //JSAPI支付方式需要OPENID，判断是否存在，这里不判断的话，easyWechat后面也会进行判断
        $user = Db::table('user')->where(['id' => $order['user_id']])->item();
        if(!$user['wechat_openid']){
            $this->returnMessage(202,'OPENID为空，请使用微信登录或者先绑定微信');
        }
        $openid = $user['wechat_openid'];

        //重新生成订单号，防止不同支付类型导致支付失败
        $order['no'] = $this->getNumber();

        //更新订单号
        Db::table('order')->where('id',$id)->update($order);

        $app = app('wechat.payment.mini_program');
        $result = $app->order->unify([
            'body' => '购买商品',
            'out_trade_no' => $order['no'],
            'total_fee' => intval($order['money'] * 100),
            'trade_type' => 'JSAPI',
            'spbill_create_ip' => request()->ip(),
            'openid' => $openid,
        ]);

        /*echo '<pre>';print_r($result);exit();*/

        if ($result['result_code'] == 'SUCCESS') {
            //如果请求成功，微信会返回'prepay_id'，预支付订单号, 用于生成支付 JS 配置
            $prepayId = $result['prepay_id'];

            //通过jssdk生成JSAPI支付必备的参数，格式为 json 字符串
            $data = $app->jssdk->bridgeConfig($prepayId);

            $this->returnMessage(200,'请您支付',$data);
        }else{
            $this->returnMessage(400,$result['err_code_des']);
        }

    }

    //回调-小程序
    public function notifyMiniProgram()
    {
        $app = app('wechat.payment.mini_program');
        $response = $app->handlePaidNotify(function ($message, $fail) {
            //Log::info($message);
            //获取订单号
            $no = $message['out_trade_no'];

            //获取订单信息
            $order = Db::table('order')->where(['no' => $no,'state' => 1])->item();
            if (!$order || $order['prepaid']) { //如果订单不存在 或者 订单已经支付过了
                return true; //告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            if ($message['return_code'] === 'SUCCESS') { //return_code 表示通信状态，不代表支付状态
                //支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    //更新参数
                    $update['prepaid'] = time();
                    $update['state'] = 2;

                    //更新订单
                    Db::table('order')->where('no',$no)->update($update);
                //支付失败
                } else if (array_get($message, 'result_code') === 'FAIL') {
                    
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            //保存订单
            $order->save(); 

            return true;

            //或者错误消息
            $fail('Order not exists.');
        });

        return $response;
    }

}