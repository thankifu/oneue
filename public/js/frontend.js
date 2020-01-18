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

//加载屏幕
function starLoadScreen(){
	/*var width_side = $('.star-side').width();
	var width_foot = $(window).width() - width_side;

	$('.star-login').css({
		'margin-top': -$('.star-login').height()/2,
	});*/
	var star_product_width = $(".star-list-product .star-image").width();
	var star_article_width = $(".star-list-article .star-image").width();
	var star_special_width = $(".star-list-special .star-image").width();
	var star_side_width = $(".star-side").width();
	$(".star-list-product .star-image").height(star_product_width);
	$(".star-list-product .star-image img").height(star_product_width);
	$(".star-list-article .star-image").height(star_article_width/1.875);
	$(".star-list-article .star-image img").height(star_article_width/1.875);
	$(".star-list-special .star-image").height(star_special_width/2.5);
	$(".star-list-special .star-image img").height(star_special_width/2.5);

	$(".star-side .star-list-product .star-title").width(star_side_width-100);
	$(".star-side .star-list-product .star-price").width(star_side_width-100);

	/*if ( $(window).width() > 950 ) {
		$(".scroll .wechat").hover(
			function() {
				$(".scroll .qrcode").stop(true, true).fadeIn(0);
			},
			function() {
				$(".scroll .qrcode").stop(true, true).fadeOut(0);
				$(".scroll .mask").stop(true, true).fadeOut(0);
				$(".scroll .close").stop(true, true).fadeOut(0);
			}
		);
	} else {
		$(".scroll .wechat").click(
			function() {
				$(".scroll .qrcode").fadeIn(0);
				$(".scroll .mask").fadeIn(0);
				$(".scroll .close").fadeIn(0);
			}
		);
		$(".scroll .close").click(
			function() {
				$(".scroll .qrcode").fadeOut(0);
				$(".scroll .mask").fadeOut(0);
				$(".scroll .close").fadeOut(0);
			}
		);
	}*/

	$('.star-login').css({
		'margin-top': -$('.star-login').height()/2,
	});
};

//跳转登录
function starGotoLogin(){
	if( redirect_url !=null && redirect_url.toString().length>1 ) {
		window.location.href = '/login?redirect_url='+redirect_url;
	}else{
		window.location.href = '/login?redirect_url='+encodeURI(window.location.href);
	}
};

//跳转注册
function starGotoRegister(){
	if( redirect_url !=null && redirect_url.toString().length>1 ) {
		window.location.href = '/register?redirect_url='+redirect_url;
	}else{
		window.location.href = '/register?redirect_url='+encodeURI(window.location.href);
	}
};

//跳转重置
function starGotoReset(){
    window.location.href = '/reset';
}

//跳转购物车
function starGotoCart(){
	window.location.href = '/cart';
};

//登录自动焦点
$('.star-login #username').focus();
    
//回车登录
$('.star-login input').keydown(function(e){
    if(e.keyCode==13){
       starLogin();
    }
});

//登录
function starLogin(){
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

	var data = $('form').serialize();

    /*console.log(data);
    return;*/

    $.ajax({
        type:'POST',
        url:'/login',
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

//退出
function starLogout(){
	var data = new Object();
    data._token = $('input[name="_token"]').val();
	$.post('/logout',data,function(res){
		if(res.code === 200){
			starToast('success', res.text);
			setTimeout(function(){
				parent.window.location.reload();
			},1000);
		}else{
			starToast('fail', res.text);
		}
	},'json');
};

function starReset(){
    /*alert();
    return;*/
    var email = $.trim($('input[name="email"]').val());
    var email_code = $.trim($('input[name="email_code"]').val());
    if(email == ''){
        starToast('fail', '请输入邮箱');
        return;
    }

    var data = $('#step_1').serialize();

    $.ajax({
        type:'POST',
        url:'/reset/auth',
        data:data, 
        dataType:'json',
        timeout:10000,
        success:function(data,status){
            if(data.code === 200){
                starToast("success", data.text);
                setTimeout(function(){
                    window.location.reload();
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
}

function starResetStore(){
    var password = $.trim($('input[name="password"]').val());
    var password_confirmation = $.trim($('input[name="password_confirmation"]').val());
    if(password == ''){
        starToast('fail', '请输入密码');
        return;
    }
    if(password !== password_confirmation){
        starToast('fail', '两次密码输入不一致');
        return;
    }

    var data = $('#step_2').serialize();

    $.ajax({
        type:'POST',
        url:'/reset/store',
        data:data, 
        dataType:'json',
        timeout:10000,
        success:function(data,status){
            if(data.code === 200){
                starToast("success", data.text);
                setTimeout(function(){
                    window.location.href = '/login';
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
}

//搜索
function starSearch(){
    var keyword = $.trim($('input[name="keyword"]').val());
    if(keyword == ''){
        starToast('fail', '请输入关键字');
        return false;
    }

    window.location.href = '/search?keyword='+keyword;

}

//喜欢
function starLike(object){
	var data = new Object();
	data.id = $(object).attr('data-id');
	data.type = $(object).attr('data-type');
	data._token = $('input[name="_token"]').val();
	/*$.post('/user/like/store',data,function(res){
		if(res.code === 200){
			starToast('success', res.text);
		}else{
			starToast('fail', res.text);
		}
	},'json');*/

	if(data.type != 'article' && data.type != 'product'){
		starToast("fail", '参数错误');
		return;
	}

	$.ajax({
        type:'POST',
        url:'/user/like/store',
        data:data, 
        dataType:'json',
        timeout:10000,
        success:function(data,status){
            if(data.code === 200){
                starToast("success", data.text);
                if(data.text == '喜欢了'){
                	$(object).addClass('star-active');
                	$(object).find('.glyphicon').removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
                }else{
                	$(object).removeClass('star-active');
                	$(object).find('.glyphicon').removeClass('glyphicon-heart').addClass('glyphicon-heart-empty');
                }
            }else{
                starToast("fail", data.text);
            }
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){
        	//console.log(errorThrown);
            if(textStatus==='timeout'){
                starToast("fail", '请求超时');
                setTimeout(function(){
                    starToast("fail", '重新请求');
                },2000);
            }
            if(errorThrown==='Too Many Requests'){
                starToast("fail", '尝试次数太多，请稍后再试');
            }
            if(errorThrown==='Unauthorized'){
            	starToast("fail", '请先登录');
                setTimeout(function(){
                    window.location.href = '/login';
                },1000);
            }
        }
    });
}

//支付验证
function starPaid(id){
	//clearInterval(timer);
	var timer = setInterval(function(){
		var data = new Object();
		data.id = id;
		$.get('/order/paid',data,function(res){
			if(res.code === 200){
				clearInterval(timer);
				bootbox.hideAll();
				starToast('success', res.text);
				setTimeout(function(){
	    			parent.window.location.href = '/user/order';
	    		},1000);
			}
		},'json');
	},3000);
};

//定义
var jsApiParameters = '';

//发起支付
function starPayment(id){
    starToast('loading', '请稍后...', 0);
    if(!starIsMobile() && !starIsWechat()){
    	var data = new Object();
    	data.id = id;
    	data.type = 'NATIVE';
    	data._token = $('input[name="_token"]').val();
    	$.post('/wechat/payment',data,function(res){
			if(res.code === 200){
				starPaid(id);
				bootbox.hideAll();
				bootbox.confirm({
					size: "small", 
					title: res.text,
				    message: '<p><center>支付金额：'+res.data.money+'</center></p><p><center>'+res.data.qrcode+'</center></p>',
				    buttons: {
				        cancel: {
				            label: '取消',
				            className: 'btn-secondary'
				        },
				        confirm: {
				            label: '支付成功'
				        }
				    },
				    callback: function (result) {
				    	if(result){
				    		window.location.href = '/user/order';
				    		return;
				    	}else{
				    		window.location.href = '/user/order';
				    	}
				    }
				});
			}else{
				bootbox.hideAll();
				starToast('fail', res.text);
				setTimeout(function(){
	    			//window.location.reload();
	    			window.location.href = '/user/order';
	    		},1000);
			}
		},'json');

    }
    if(starIsMobile() && !starIsWechat()){
    	var data = new Object();
    	data.id = id;
    	data.type = 'MWEB';
    	data._token = $('input[name="_token"]').val();
    	$.post('/wechat/payment',data,function(res){
			if(res.code === 200){
				window.location.href = res.data.url;
			}else{
				bootbox.hideAll();
				starToast('fail', res.text);
				setTimeout(function(){
	    			window.location.href = '/user/order';
	    		},1000);
			}
		},'json');
    }
    if(starIsMobile() && starIsWechat()){
    	var data = new Object();
    	data.id = id;
    	data.type = 'JSAPI';
    	data._token = $('input[name="_token"]').val();
    	$.post('/wechat/payment',data,function(res){
			if(res.code === 200){
				bootbox.hideAll();
				jsApiParameters = JSON.parse(res.data);
				callPay();
			}else if(res.code === 202){
				bootbox.hideAll();
				bootbox.alert({
				    size: "small",
				    message: res.text,
				    callback: function(){

				    }
				});
			}else{
				bootbox.hideAll();
				starToast('fail', res.text);
				setTimeout(function(){
	    			window.location.href = '/user/order';
	    		},1000);
			}
		},'json');
    }
    
};

//微信JSAPI支付
function callPay() {
	if (typeof WeixinJSBridge == "undefined"){
	    if( document.addEventListener ){
	        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
	    }else if (document.attachEvent){
	        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
	        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
	    }
	}else{
	    jsApiCall();
	}
};
//微信JSAPI支付
function jsApiCall(){ 
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',jsApiParameters,
		function(res){
			//WeixinJSBridge.log(res.err_msg);
			if (res.err_msg == "get_brand_wcpay_request:ok") {
				//alert('支付成功')
				//可以进行查看订单，等操作
				window.location.href = '/user/order';
			} else {
				//alert('支付失败！');
				window.location.href = '/user/order';
			}
			//alert(res.err_code+res.err_desc+res.err_msg);
		}
	);
};

//订单确认收货
function starOrderReceive(id){
    var data = new Object();
    data.id = id;
    data._token = $('input[name="_token"]').val();

    bootbox.confirm({
        size: "small", 
        title: '提示',
        message: '<center>是否确认收货？</center>',
        buttons: {
            cancel: {
                label: '取消',
                className: 'btn-secondary'
            },
            confirm: {
                label: '确认'
            }
        },
        callback: function (result) {
            if(result){
                $.post('/user/order/store',data,function(res){
                    if(res.code === 200){
                        starToast('success', res.text);
                        setTimeout(function(){
                            window.location.reload();
                        },1000);
                        return;
                    }else{
                        starToast('fail', res.text);
                    }
                },'json');
            }else{
                
            }
        }
    });
}

//倒计时
function starCountDown(object, timeout){
    // 如果秒数还是大于0，则表示倒计时还没结束
    if(timeout>=0){
        // 按钮置为不可点击状态
        $(object).attr('disabled', true);
        // 按钮里的内容呈现倒计时状态
        $(object).text('获取验证码('+timeout+')');
        // 时间减一
        timeout--;
        // 一秒后重复执行
        setTimeout(function(){starCountDown(object,timeout);},1000);
        // 否则，按钮重置为初始状态
    }else{
    	// 按钮置未可点击状态
    	$(object).attr('disabled', false);
    	// 按钮里的内容恢复初始状态
    	$(object).text('获取验证码');
    }
};

//联系
function starContact(type){
    type = type || '';
    var title = '';
    var message = '';
    var phone = starSitePhone != '' ? '<p>手机：'+starSitePhone+'</p>' : '';
    var wechat = starSiteWechat != '' ? '<p>微信：'+starSiteWechat+'</p>' : '';
    var qrcode = starSiteQrcode != '' ? '<p><img src='+starSiteQrcode+' width="200"/></p>' : '';
    console.log(phone);
    //return;
    if(type == 'shopping'){
        title = '购买';
        message = '<center><p>感谢您的光临，如需购买请联系</p>'+qrcode+wechat+phone+'</center>';
    }else if(type == 'refund'){
        title = '退款';
        message = '<center><p>如需退款请联系</p>'+qrcode+wechat+phone+'</center>';
    }else{
        title = '联系方式';
        message = '<center>'+qrcode+wechat+phone+'</center>';
    }
    bootbox.alert({
        size: "small",
        title: title,
        message: message,
        callback: function(){ /* your callback code */ }
    })
}

//头像储存
function starAvatarStore(){
    var avatar = $.trim($('input[name="avatar"]').val());
    if(avatar == ''){
        starToast('fail', '请上传头像');
        return;
    }
    var data = $('#form').serialize();
    $.post('/user/avatar/store',data,function(res){
        if(res.code === 200){
            starToast('success', res.text);
            setTimeout(function(){
                window.location.href = '/user/setting';
            },1000);
        }else{
            starToast('fail', res.text);
        }
    },'json');
};

//邮箱格式验证
function starCheckEmail(email){
    //console.log(email);
    if (starRegexMail.test(email)) {
        $('button[name="email_send"]').attr('disabled', false);
        return;
    }else{
        //starToast('fail', '邮箱格式错误');
        $('button[name="email_send"]').attr('disabled', true);
        return;
    }
};

//邮箱发送
function starSendEmail(object, type){
    var url = '/email';
    if(type == 'rest'){
        url = '/email/reset';
    }
    var email = $.trim($('input[name="email"]').val());
    starCheckEmail(email);
    var data = $('form').serialize();
    $.ajax({
        type:'POST',
        url:url,
        data:data, 
        dataType:'json',
        timeout:10000,
        success:function(data,status){
            if(data.code === 200){
                starToast("success", data.text);
                starCountDown(object, 60);
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

//安全验证
function starConfirmation(){
	var password = $.trim($('input[name="password"]').val());
	if(password == ''){
        starToast('fail', '请输入密码');
        return;
    }
    var data = $('#form').serialize();
    $.post('/user/confirmation/auth',data,function(res){
        if(res.code === 200){
        	starToast('success', res.text);
        	setTimeout(function(){
        		if( redirect_url !=null && redirect_url.toString().length>1 ) {
			        window.location.href = decodeURI(redirect_url);
			    }else{
			        window.location.href = '/user/email';
			    }
        	},1000);
        }else{
        	starToast('fail', res.text);
        }
    },'json');
};

//邮箱修改储存
function starEmailStore(){
	var email = $.trim($('input[name="email"]').val());
    var email_code = $.trim($('input[name="email_code"]').val());
    if(email == ''){
        starToast('fail', '请输入邮箱');
        return;
    }
    var data = $('#form').serialize();
    $.post('/user/email/store',data,function(res){
        if(res.code === 200){
        	starToast('success', res.text);
        	setTimeout(function(){
        		window.location.href = '/user/setting';
        	},1000);
        }else{
        	starToast('fail', res.text);
        }
    },'json');
};

//密码修改储存
function starPasswordStore(){
	var password = $.trim($('input[name="password"]').val());
    var password_confirmation = $.trim($('input[name="password_confirmation"]').val());
    if(password !== password_confirmation){
        starToast('fail', '两次密码输入不一致');
        return;
    }
    var data = $('#form').serialize();
    $.post('/user/password/store',data,function(res){
        if(res.code === 200){
        	starToast('success', res.text);
        	setTimeout(function(){
        		window.location.href = '/user/setting';
        	},1000);
        }else{
        	starToast('fail', res.text);
        }
    },'json');
};

$(document).ready(function() {
	starLoadScreen();
	window.onresize = function(){
		starLoadScreen();
	}

	$(".star-main img").addClass("lazy");
    $("img.lazy").lazyload({
        effect:"fadeIn",
        threshold:0,
    });

	$('.pagination').removeClass('pagination-sm');

    $(document).on('change','input[name="avatar"]',function(){
        var url = $(this).val();
        $(this).parent().find('img').attr('src', url);
    });
});