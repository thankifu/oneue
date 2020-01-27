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

    public function index(Request $request)
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

}