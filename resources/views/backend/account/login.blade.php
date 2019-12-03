<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>登录</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body id="star-login">
<main class="container">
	<div class="star-login">
		<div class="star-login-logo">ONEUE</div>
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
            <button type="button" class="btn btn-block star-button-primary" onclick="login()">登　录</button>
            {{csrf_field()}}
        </form>
	</div>
</main>
@include('backend.common.foot')
<script type="text/javascript">
    $('.star-login #username').focus();
    
    // 回车登录
    $('.star-login input').keydown(function(e){
        if(e.keyCode==13){
           login();
        }
    });

    function login(){
        var data = new Object();
        data._token = $('input[name="_token"]').val();
        data.username = $.trim($('input[name="username"]').val());
        data.password = $.trim($('input[name="password"]').val());
        if(data.username == ''){
            starToast('fail', '用户名不能为空');
            return false;
        }
        if(data.password == ''){
            starToast('fail', '密码不能为空');
            return;
        }

        $.ajax({
            type:'POST',
            url:'/admin/login',
            data:data, 
            dataType:'json',
            timeout:2000,
            success:function(data,status){
                if(data.code === 200){
                    starToast("success", data.text);
                    setTimeout(function(){
                        window.location.href = '/admin/home/index#/home/welcome';
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
        })
    }
</script>

</body>
</html>