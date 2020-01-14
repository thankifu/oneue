<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>注册 - {{$_site['name']}}</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('frontend.common.head')
</head>
<body>
<div class="container">
	<div class="star-login">
		<div class="star-logo">ONEUE</div>
        <form >
            {{csrf_field()}}
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

            @if(!$_site['auth_email'] && !$_site['auth_phone'])
            <div class="form-group">
                <label class="sr-only" for="password_confirmation">确认密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" placeholder="请再次输入密码">
                </div>
            </div>
            @endif

            @if($_site['auth_email'])
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
                    <button type="button" class="btn btn-block" name="email_send" disabled onclick="starSendEmail(this);">获取验证码</button>
                </div>
            </div>
            @endif

            @if($_site['auth_phone'])
            <div class="form-group">
                <label class="sr-only" for="phone">手机</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                    <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="请输入手机" autocomplete="off">
                </div>       
            </div>
            <div class="row">
                <div class="form-group col-xs-7">
                    <label class="sr-only" for="phone_code">验证码</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                        <input type="text" class="form-control" id="phone_code" name="phone_code" value="" placeholder="请输入验证码" autocomplete="off">
                    </div>       
                </div>
                <div class="form-group col-xs-5">
                    <button type="button" class="btn btn-block btn-" disabled onclick="">获取验证码</button>
                </div>
            </div>
            @endif

            <button type="button" class="btn btn-block btn-primary" onclick="starRegister()">注　册</button>
            <div class="form-group">
                <p class="help-block text-right"><a href="javascript:void(0);" onclick="starGotoLogin();">已有账号，立即登录</a></p>
            </div>
        </form>
	</div>
</div>
@include('frontend.common.foot')


<script type="text/javascript">
@if($_site['auth_wechat'] == 1)
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
@endif

//注册
function starRegister(){
    var username = $.trim($('input[name="username"]').val());
    var password = $.trim($('input[name="password"]').val());
    
    if(username == ''){
        starToast('fail', '请输入用户名');
        return false;
    }
    if(password == ''){
        starToast('fail', '请输入密码');
        return;
    }

    @if(!$_site['auth_email'] && !$_site['auth_phone'])
    var password_confirmation = $.trim($('input[name="password_confirmation"]').val());
    if(password !== password_confirmation){
        starToast('fail', '两次密码输入不一致');
        return;
    }
    @endif

    @if($_site['auth_email'])
    var email = $.trim($('input[name="email"]').val());
    var email_code = $.trim($('input[name="email_code"]').val());
    if(email == ''){
        starToast('fail', '请输入邮箱');
        return;
    }
    @endif

    @if($_site['auth_phone'])
    var phone = $.trim($('input[name="phone"]').val());
    var phone_code = $.trim($('input[name="phone_code"]').val());
    if(phone == ''){
        starToast('fail', '请输入手机');
        return;
    }
    @endif

    var data = $('form').serialize();

    /*console.log(data);
    return;*/

    $.ajax({
        type:'POST',
        url:'/register',
        data:data, 
        dataType:'json',
        timeout:10000,
        success:function(data,status){
            if(data.code === 200){
                starToast("success", data.text);
                setTimeout(function(){
                    if( redirect_url !=null && redirect_url.toString().length>1 ) {
                        window.location.href = decodeURI(redirect_url);
                    }else{
                        window.location.href = '/user';
                    }
                },1000);

            }else{
                starToast("fail", data.text);
            }
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){
            if(textStatus==='timeout'){
                starToast("fail", '请求超时');
                setTimeout(function(){
                    starToast("fail", '重新请求');
                },2000);
            }
            if(errorThrown==='Too Many Requests'){
                starToast("fail", '尝试次数太多，请稍后再试');
            }
        }
    });
};
</script>
</body>
</html>