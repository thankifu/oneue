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
function starGotoLogin(){
	if( redirect_url !=null && redirect_url.toString().length>1 ) {
		window.location.href = '/login?redirect_url='+redirect_url;
	}else{
		window.location.href = '/login?redirect_url='+encodeURI(window.location.href);
	}
};
function starGotoRegister(){
	if( redirect_url !=null && redirect_url.toString().length>1 ) {
		window.location.href = '/register?redirect_url='+redirect_url;
	}else{
		window.location.href = '/register?redirect_url='+encodeURI(window.location.href);
	}
};
function starGotoCart(){
	window.location.href = '/cart';
};
$('.star-login #username').focus();
    
// 回车登录
$('.star-login input').keydown(function(e){
    if(e.keyCode==13){
       login();
    }
});

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

//注册
function starRegister(){
	var username = $.trim($('input[name="username"]').val());
	var password = $.trim($('input[name="password"]').val());
	var confirm = $.trim($('input[name="confirm"]').val());
	if(username == ''){
        starToast('fail', '请输入用户名');
        return false;
    }
    if(password == ''){
        starToast('fail', '请输入密码');
        return;
    }
    if(password !== confirm){
        starToast('fail', '两次密码输入不一致');
        return;
    }

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
});