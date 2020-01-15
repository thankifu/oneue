<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>重置密码 - {{$_site['name']}}</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('frontend.common.head')
</head>
<body>
<div class="container">
	<div class="star-login">
        @if($reset_auth == 0)
        <div class="star-logo">重置密码</div>
        <form id="step_1">
            {{csrf_field()}}
            <div class="form-group">
                <label class="sr-only" for="email">邮箱</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input type="text" class="form-control" id="email" name="email" value="" placeholder="请输入邮箱" autocomplete="off" onkeyup="starCheckEmail(this.value);">
                </div>       
            </div>
            <div class="row">
                <div class="form-group col-xs-7">
                    <label class="sr-only" for="email_code">验证码</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                        <input type="text" class="form-control" id="email_code" name="email_code" value="" placeholder="请输入验证码" autocomplete="off">
                    </div>       
                </div>
                <div class="form-group col-xs-5">
                    <button type="button" class="btn btn-block" name="email_send" disabled onclick="starSendEmail(this, 'rest');">获取验证码</button>
                </div>
            </div>

            <button type="button" class="btn btn-block btn-primary" onclick="starReset()">验　证</button>
            <div class="form-group">
                <p class="help-block text-right"><a href="javascript:void(0);" onclick="starGotoLogin();">记得密码，去登录</a></p>
            </div>
        </form>
        @else
        <div class="star-logo">输入新密码</div>
        <form id="step_2">
            {{csrf_field()}}
            <div class="form-group">
                <label class="sr-only" for="password">密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="请输入密码">
                </div>
            </div>

            <div class="form-group">
                <label class="sr-only" for="password_confirmation">确认密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" placeholder="请再次输入密码">
                </div>
            </div>

            <button type="button" class="btn btn-block btn-primary" onclick="starResetStore()">提交重置</button>
        </form>
        @endif
        
	</div>
</div>
@include('frontend.common.foot')

</body>
</html>