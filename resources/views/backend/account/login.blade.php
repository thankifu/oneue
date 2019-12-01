<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>登录</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/packages/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
</head>
<body id="sl-login">

<main class="container">
	<div class="sl-login">
		<div class="sl-login-logo">ONEUE</div>
        <form >
            <div class="form-group">
                <label class="sr-only" for="username">用户名</label>
                <input type="text" class="form-control" id="username" name="username" value="" placeholder="用户名">
            </div>
            <div class="form-group">
                <label class="sr-only" for="password">密码</label>
                <input type="password" class="form-control" id="password" name="password" value="" placeholder="密码">
            </div>
            <button type="button" class="btn btn-block sl-button-primary" onclick="login()">登　录</button>
            {{csrf_field()}}
        </form>
	</div>
</main>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript">
    $('.sl-login #username').focus();
    
    // 回车登录
    $('.sl-login input').keydown(function(e){
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
            slToast('fail', '用户名不能为空');
            return false;
        }
        if(data.password == ''){
            slToast('fail', '密码不能为空');
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
                    slToast("success", data.text);
                    setTimeout(function(){
                        window.location.href = '/admin/home/index#/home/welcome';
                    },1000);

                }else{
                    slToast("fail", data.text);
                }
            },
            error:function(XMLHttpRequest,textStatus,errorThrown){
                if(textStatus==='timeout'){
                    toast("fail", '請求超時');
                    setTimeout(function(){
                        slToast("fail", '重新请求');
                    },2000);
                }
                if(errorThrown==='Too Many Requests'){
                    slToast("fail", '尝试次数太多，请稍后再试');
                }
            }
        })
    }
</script>

</body>
</html>