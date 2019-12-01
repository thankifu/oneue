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

//适配
function slScreen(){
	var width_side = $('.sl-side').width();
	var width_foot = $(window).width() - width_side;
	
	$(".sl-footer").width(width_foot);

	$('.sl-main').height( $(window).height() - 100 );

	$('.sl-login').css({
		'margin-top': -$('.sl-login').height()/2,
	});
}

//提示弹窗
function slToast(state, message, second){
	second=second||1000;
	$('<div class="sl-toast"><div class="sl-toast-icon '+state+'"><i class="fa fa-check-circle-o" aria-hidden="true"></i><i class="fa fa-times-circle-o" aria-hidden="true"></i><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div><div class="sl-toast-content">'+message+'</div></div><div class="sl-toast-mask"></div>').appendTo('body');
	$('.sl-toast').css('margin-top',-$('.sl-toast').height()/2);
	$('.sl-toast').fadeIn();
	$('.sl-toast-mask').fadeIn();
	setTimeout(function(){
		$('.sl-toast').fadeOut().remove();
		$('.sl-toast-mask').fadeOut().remove();
	},second);
};

//侧边栏
function slSide(){
	//$("body").toggleClass('side-mini');
	if($("body").hasClass('sl-side-mini')){
		$('.sl-side-state').removeClass('glyphicon-indent-right').addClass('glyphicon-indent-left');
		$("body").removeClass('sl-side-mini');
		clearCookie('_side', '/');
	}else{
		$('.sl-side-state').removeClass('glyphicon-indent-left').addClass('glyphicon-indent-right');
		$("body").addClass('sl-side-mini');
		setCookie('_side','sl-side-mini',365, '/');
	}

	setTimeout(function(){
		slScreen();
	},100);
}

//框架
function slIframe(iframe) {
	if (iframe) {
		var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
		if (iframeWin.document.body) {
			iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
		}
	}
};

//获取地址栏参数
function GetQueryString(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r!=null)return  unescape(r[2]); return null;
};
	
//获取url参数
var redirect_url = GetQueryString("redirect_url");

var backend_path = '/admin';

//菜单点击
function menuClick(_this){
	var controller = $.trim($(_this).attr('controller'));
	var action = $.trim($(_this).attr('action'));
	if(controller==''||action==''){
		return;
	}

	var src = '/admin/'+controller+'/'+action;
	$('.sl-main-iframe').attr('src',src);
	window.location.hash = '/'+controller+'/'+action;

	$('.sl-side li').removeClass('sl-current').removeClass('sl-open');
	$(_this).parent().addClass('sl-current');

	if($(_this).parent().parent().is('.dropdown-menu')){
		$('.sl-side .dropdown').removeClass('sl-open');
		$(_this).parent().parent().parent().addClass('sl-open');
	}
}
//菜单初始化
function menuInit(){
	var url = menuLink();
	if(url!=undefined && url!=''){
		var src = '/admin'+url;
		$('.sl-main-iframe').attr('src',src);
	}

	setTimeout(function(){
		var url = menuLink();
		var _this = $('.sl-side a[data="/admin'+url+'"]');
		_this.parent().addClass('sl-current');
		if(_this.parent().parent().is('.dropdown-menu')){
			_this.parent().parent().parent().addClass('sl-open');
		}
	},50);
}
//菜单连接
function menuLink(){
	var str =window.top.location.href.split("#");
	var url = str[1];
	return url==undefined?'':url;
}

//添加修改
function slAdd(type, id, parent){
	parent = parent || 0;
	$('.sl-dialog-add input[name="sl_id"]').val(id);
	$('.sl-dialog-add input[name="sl_type"]').val(type);
	$('.sl-dialog-add input[name="sl_parent"]').val(parent);
	$('.sl-dialog-add .modal-title').text(id>0?'编辑':'添加');
	$('.sl-dialog-add').modal('show');
}

//弹出
$('.sl-dialog-add').on('show.bs.modal', function (event) {
	var id = $('.sl-dialog-add input[name="sl_id"]').val();
	var type = $('.sl-dialog-add input[name="sl_type"]').val();
	var parent = $('.sl-dialog-add input[name="sl_parent"]').val();
	$(this).find('.modal-body iframe').attr("src", backend_path+'/'+type+'/add?id='+id+'&parent='+parent);
});

//添加修改退出
function slAddCancel(){
	parent.$('.sl-dialog-add').modal('hide');
}

//删除
function slDelete(type, id){
	$('.sl-dialog-delete input[name="sl_id"]').val(id);
	$('.sl-dialog-delete input[name="sl_type"]').val(type);
	$('.sl-dialog-delete').modal('show');
}
//执行删除
function slDoDelete(){
	$('.sl-dialog-delete').modal('hide');
	var id = $('.sl-dialog-delete input[name="sl_id"]').val();
	var type = $('.sl-dialog-delete input[name="sl_type"]').val();
	$.post(backend_path+'/'+type+'/delete',{id:id,_token:$('input[name="_token"]').val()},function(res){
        if(res.code === 200){
        	slToast('success', res.text);
        	setTimeout(function(){
        		window.location.reload();
        	},1000);

        }else{
        	slToast('fail', res.text);
        }
    },'json');
}

function addLabel(obj){
	var url = $(obj).attr('href');
	var name = $(obj).find('.text').text();
	$('.body-label li').append('<li><span class="title">'+name+'</span><span class="close"><i class="fa fa-window-close" aria-hidden="true"></i></span></li>');
	alert(name+','+url);
}

//管理员保存
function slAdminSave(){
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
		slToast('fail', '请输入用户名');
		return;
	}
	if(data.group_id==0){
		slToast('fail', '请选择管理组');
		return;
	}
	if(data.id == 0 && data.password == ''){
		slToast('fail', '请输入密码');
		return;
	}
	if(data.name==''){
		slToast('fail', '请输入真实姓名');
		return;
	}
	$.post(backend_path+'/admin/save',data,function(res){
		if(res.code === 200){
			slToast('success', res.text);
			setTimeout(function(){
				parent.window.location.reload();
			},1000);
		}else{
			slToast('fail', res.text);
		}
	},'json');
}

//管理组保存
function slGroupSave(){
	var name = $.trim($('input[name="name"]').val());
	if(name==''){
		toast('fail', '请输入管理组名');
		return;
	}
	/*console.log($('form').serialize());
	return;*/
	$.post(backend_path+'/group/save',$('form').serialize(),function(res){
		if(res.code === 200){
			slToast('success', res.text);
			setTimeout(function(){
				parent.window.location.reload();
			},1000);
		}else{
			slToast('fail', res.text);
		}
	},'json');
}

//子菜单/返回上级
function slMenuGo(id){
	window.location.href = backend_path+'/menu/index?parent='+id;
}
//菜单保存
function slMenuSave(){
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
			slToast('success', res.text);
			setTimeout(function(){
				parent.window.location.reload();
			},1000);

		}else{
			slToast('fail', res.text);
		}
	},'json');
}

$(document).ready(function() {
	slScreen();
	window.onresize = function(){
		slScreen();
	}
	$(".header li").hover(
		function(){$(this).find("dl").show();$(this).find('.arrow').removeClass('fa-angle-down').addClass('fa-angle-up')},
		function(){$(this).find("dl").hide();$(this).find('.arrow').removeClass('fa-angle-up').addClass('fa-angle-down')}
	);
});