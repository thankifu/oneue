<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>登录 - {{$_site['name']}}</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('frontend.common.head')
</head>
<body>
<div class="container">
	<div class="star-login">
		<div class="star-logo">{{$_site['name']}}</div>
        <form >
            <div class="form-group">
                <label class="sr-only" for="username">帐号</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" class="form-control" id="username" name="username" value="" placeholder="请输入帐号" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="password">密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="请输入密码">
                </div>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="remember" name="remember"> 记住我
                </label>
                <a class="pull-right" href="javascript:void(0);" onclick="starGotoReset();">忘记密码？</a>
            </div>

            <button type="button" class="btn btn-block btn-primary" onclick="starLogin()">登　录</button>
            {{csrf_field()}}
            <div class="form-group">
                <p class="help-block text-right"><a href="javascript:void(0);" onclick="starGotoRegister();">没有帐号？立即注册</a></p>
            </div>
        </form>
	</div>
</div>
@include('frontend.common.foot')

@if($_site['auth_wechat'] == 1)
<script type="text/javascript">
    $(window).load(function(){
        if(starIsMobile() && starIsWechat()){
            bootbox.confirm({
                size: "small", 
                message: "微信中可免注册登录，是否同意？",
                buttons: {
                    cancel: {
                        label: '取消',
                        className: 'btn-secondary'
                    },
                    confirm: {
                        label: '同意'
                    }
                },
                callback: function (result) {
                    if(result){
                        if( redirect_url !=null && redirect_url.toString().length>1 ) {
                            window.location.href = '/wechat/auth?redirect_url='+redirect_url;
                        }else{
                            window.location.href = '/wechat/auth';
                        }
                    }
                }
            });
        }
    });
</script>
@endif

</body>
</html>