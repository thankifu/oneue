<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>注册</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('frontend.common.head')
</head>
<body>
<div class="container">
	<div class="star-login">
		<div class="star-logo">ONEUE</div>
        <form >
            <div class="form-group">
                <label class="sr-only" for="username">帐号</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" class="form-control" id="username" name="username" value="" placeholder="请输入帐号">
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="password">密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="请输入密码">
                </div>
            </div>
            <button type="button" class="btn btn-block btn-primary" onclick="starRegister()">注　册</button>
            {{csrf_field()}}
            <div class="form-group">
                <p class="help-block text-right"><a href="javascript:void(0);" onclick="starGotoLogin();">已有账号，立即登录</a></p>
            </div>
        </form>
	</div>
</div>
@include('frontend.common.foot')
</body>
</html>