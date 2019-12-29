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
use Log;

class Wechat extends Common
{

    public function index(Request $request)
    {
        //Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $result = $app->oauth->scopes(['snsapi_userinfo'])->redirect($request->fullUrl());
        $result = config('wechat.payment.default.notify_url');
        print_r($result);

    }

    public function auth()
    {
        //Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $result = $app->oauth->scopes(['snsapi_userinfo'])->redirect();

    }

    public function payment(Request $request)
    {
        //Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
        
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

        //重新生成订单号，防止不同支付类型导致支付失败
        $order['no'] = $this->getNumber();

        //更新订单号
        Db::table('order')->where('id',$id)->update($order);

        $app = app('wechat.payment');
        $result = $app->order->unify([
            'body' => '购买商品',
            'out_trade_no' => $order['no'],
            'total_fee' => intval($order['money'] * 100),
            //'notify_url' => '/wechat/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'NATIVE',
            'spbill_create_ip' => request()->ip(),
            //'openid' => 'ouqpV1kn4pF4Zpzp_J2ledMRfaB8',
        ]);
        //echo '<pre>';
        //print_r($result);
        if ($result['result_code'] == 'SUCCESS') {
            // 如果请求成功, 微信会返回一个 'code_url' 用于生成二维码
            $code_url = $result['code_url'];
            $data['money'] = $order['money'];
            $data['qrcode'] = \QrCode::size(200)->generate($code_url);

            $this->returnMessage(200,'请您支付',$data);

        }else{
            $this->returnMessage(400,$result['err_code_des']);
        }
    }

    public function notify()
    {
        $app = app('wechat.payment');
        $response = $app->handlePaidNotify(function ($message, $fail) {
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $no = $message['out_trade_no'];

            //获取订单信息
            $order = Db::table('order')->where(['no' => $no,'state' => 1])->item();
            if (!$order || $order['prepaid']) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            $result = $app->order->queryByOutTradeNumber($no);
            if ($result['trade_state'] === 'SUCCESS') {
                return true;
            }

            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    $order['prepaid'] = time(); // 更新支付时间为当前时间
                    $order['state'] = 2;
                    //更新订单
                    Db::table('order')->where('no',$no)->update($order);
                // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            $order->save(); // 保存订单

            return true;
            // 或者错误消息
            $fail('Order not exists.');
        });

        return $response;
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = $this->getSeting('wechat')['value'];
        $config = [
            // 必要配置, 这些都是之前在 .env 里配置好的
            'app_id' => $wechat['official_account_app_id'],
            'secret' => $wechat['official_account_app_secret'],
        ];

        //$app = app('wechat.official_account');
        $app = \EasyWeChat::officialAccount($config);
        $app->server->push(function($message){
            $message['FromUserName'] = 'oV80DwvbIJqtad0ALPC-Ms6EvPik';
            $message['MsgType'] = 'text';
            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            //return "欢迎关注 overtrue！";
        });

        return $app->server->serve();
    }
}