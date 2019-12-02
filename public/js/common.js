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

//设置cookie  
function setCookie(cname, cvalue, exdays, cpath) {  
    var d = new Date();  
    d.setTime(d.getTime() + (exdays*24*60*60*1000));  
    var expires = "expires="+d.toUTCString();
    var path = "path="+cpath;  
    //document.cookie = cname + "=" + cvalue + "; " + expires;
    document.cookie = cname + "=" + cvalue + "; " + expires + "; " + path;
}  
//获取cookie  
function getCookie(cname) {  
    var name = cname + "=";  
    var ca = document.cookie.split(';');  
    for(var i=0; i<ca.length; i++) {  
        var c = ca[i];  
        while (c.charAt(0)==' ') c = c.substring(1);  
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);  
    }  
    return "";  
}  
//清除cookie    
function clearCookie(name,path) {    
    setCookie(name, "", -1, path);
}

//加载屏幕
function starLoadScreen(){
	var width_side = $('.star-side').width();
	var width_foot = $(window).width() - width_side;
	
	$(".star-footer").width(width_foot);

	$('.star-main').height( $(window).height() - 100 );

	$('.star-login').css({
		'margin-top': -$('.star-login').height()/2,
	});
}

//提示弹窗
function starToast(state, message, timeout){
	timeout=timeout||1000;
	var i = '';
	if(state=='loading'){
		i = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';
	}
	if(state=='success'){
		i = '<i class="fa fa-check-circle-o" aria-hidden="true"></i>';
	}
	if(state=='fail'){
		i = '<i class="fa fa-times-circle-o" aria-hidden="true"></i>';
	}
	var dialog = bootbox.dialog({ 
		size: 'small', 
	    message: '<div class="text-center">'+i+' '+message+'</div>', 
	    closeButton: false 
	});
	setTimeout(function(){
		dialog.modal('hide');
	},timeout);
};

//设置侧边栏
function starSetSide(){
	//$("body").toggleClass('side-mini');
	if($("body").hasClass('star-side-mini')){
		$('.star-side-state').removeClass('glyphicon-indent-right').addClass('glyphicon-indent-left');
		$("body").removeClass('star-side-mini');
		clearCookie('_side', '/');
	}else{
		$('.star-side-state').removeClass('glyphicon-indent-left').addClass('glyphicon-indent-right');
		$("body").addClass('star-side-mini');
		setCookie('_side','star-side-mini',365, '/');
	}

	setTimeout(function(){
		starLoadScreen();
	},100);
}

//框架
function starSetIframeHeight(iframe) {
	if (iframe) {
		var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
		if (iframeWin.document.body) {
			iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
		}
	}
};

//获取地址栏参数
function starGetQueryString(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r!=null)return  unescape(r[2]); return null;
};
	
//获取url参数
var redirect_url = starGetQueryString("redirect_url");

var backend_path = '/admin';

//菜单点击
function starMenuClick(_this){
	var controller = $.trim($(_this).attr('controller'));
	var action = $.trim($(_this).attr('action'));
	if(controller==''||action==''){
		return;
	}

	var src = '/admin/'+controller+'/'+action;
	$('.star-main-iframe').attr('src',src);
	window.location.hash = '/'+controller+'/'+action;

	$('.star-side li').removeClass('star-current').removeClass('star-open');
	$(_this).parent().addClass('star-current');

	if($(_this).parent().parent().is('.dropdown-menu')){
		$('.star-side .dropdown').removeClass('star-open');
		$(_this).parent().parent().parent().addClass('star-open');
	}
}
//菜单连接
function starMenuLink(){
	var str =window.top.location.href.split("#");
	var url = str[1];
	return url==undefined?'':url;
}
//菜单初始化
function starMenuInit(){
	var url = starMenuLink();
	if(url!=undefined && url!=''){
		var src = '/admin'+url;
		$('.star-main-iframe').attr('src',src);
	}

	setTimeout(function(){
		var url = starMenuLink();
		var _this = $('.star-side a[data="/admin'+url+'"]');
		_this.parent().addClass('star-current');
		if(_this.parent().parent().is('.dropdown-menu')){
			_this.parent().parent().parent().addClass('star-open');
		}
	},50);
}

//添加修改
function starAdd(type, id, parent){
	id = id || 0;
	parent = parent || 0;
	bootbox.dialog({
	    title: id>0?'编辑':'添加',
	    message: '<iframe src="'+backend_path+'/'+type+'/add?id='+id+'&parent='+parent+'" width="100%" frameborder="0" scrolling="auto" onload="starSetIframeHeight(this)"></iframe>'
	});
}

//添加修改退出
function starCancel(){
	parent.bootbox.hideAll();
}

//删除
function starDelete(type, id){
	bootbox.confirm({
		size: "small", 
	    message: "确认要删除吗？",
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
	    		$.post(backend_path+'/'+type+'/delete',{id:id,_token:$('input[name="_token"]').val()},function(res){
			        if(res.code === 200){
			        	starToast('success', res.text);
			        	setTimeout(function(){
			        		window.location.reload();
			        	},1000);

			        }else{
			        	starToast('fail', res.text);
			        }
			    },'json');
	    	}
	        console.log('This was logged in the callback: ' + result);
	    }
	});
}

//管理员保存
function starAdminSave(){
	var data = new Object();
	data._token = $('input[name="_token"]').val();
	data.id = $('#id').val();
	data.group_id = $('#group_id').val();
	data.username = $.trim($('#username').val());
	data.password = $.trim($('#password').val());
	data.name = $.trim($('#name').val());
	data.phone = $.trim($('#phone').val());
	data.state = $('#state').is(':checked')?0:1;
  
	if(data.username == ''){
		starToast('fail', '请输入用户名');
		return;
	}
	if(data.group_id==0){
		starToast('fail', '请选择管理组');
		return;
	}
	if(data.id == 0 && data.password == ''){
		starToast('fail', '请输入密码');
		return;
	}
	if(data.name==''){
		starToast('fail', '请输入真实姓名');
		return;
	}
	$.post(backend_path+'/admin/save',data,function(res){
		if(res.code === 200){
			starToast('success', res.text);
			setTimeout(function(){
				parent.window.location.reload();
			},1000);
		}else{
			starToast('fail', res.text);
		}
	},'json');
}

//管理组保存
function starGroupSave(){
	var name = $.trim($('input[name="name"]').val());
	if(name==''){
		toast('fail', '请输入管理组名');
		return;
	}
	$.post(backend_path+'/group/save',$('form').serialize(),function(res){
		if(res.code === 200){
			starToast('success', res.text);
			setTimeout(function(){
				parent.window.location.reload();
			},1000);
		}else{
			starToast('fail', res.text);
		}
	},'json');
}

//子菜单/返回上级
function starMenuGoto(id){
	window.location.href = backend_path+'/menu/index?parent='+id;
}
//菜单保存
function starMenuSave(){
	var data = new Object();
	data._token = $('input[name="_token"]').val();
	data.parent = parseInt($('input[name="parent"]').val());
	data.id = parseInt($('input[name="id"]').val());
	data.name = $.trim($('input[name="name"]').val());
	data.controller = $.trim($('input[name="controller"]').val());
	data.action = $.trim($('input[name="action"]').val());
	data.position = parseInt($('input[name="position"]').val());
	data.hidden = $('#hidden').is(':checked')?1:0;
	data.state = $('#state').is(':checked')?0:1;

	/*console.log(data);
	return;*/

	if(data.title==''){
		toast('fail', '请输入菜单名称');
		return;
	}
  
	/*if(data.pid>0 && data.controller==''){
		toast('fail', '请输入控制器');
		return;
	}

	if(data.pid>0 && data.action==''){
		toast('fail', '请输入方法名称');
		return;
	}*/

	$.post(backend_path+'/menu/save',data,function(res){
		if(res.code === 200){
			starToast('success', res.text);
			setTimeout(function(){
				parent.window.location.reload();
			},1000);

		}else{
			starToast('fail', res.text);
		}
	},'json');
}

$(document).ready(function() {
	starLoadScreen();
	window.onresize = function(){
		starLoadScreen();
	}
	$(".header li").hover(
		function(){$(this).find("dl").show();$(this).find('.arrow').removeClass('fa-angle-down').addClass('fa-angle-up')},
		function(){$(this).find("dl").hide();$(this).find('.arrow').removeClass('fa-angle-up').addClass('fa-angle-down')}
	);
});