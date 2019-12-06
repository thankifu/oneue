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

function starAddSpecification(){
	var i = $(".star-table-specification tbody tr").length;
	var html = '';
	html += '<tr>';
		html += '<td>';
			html += '<span class="star-picture star-picture-square star-mr-10" style="background-image:url(/images/upload-image.png);">';
				html += '<i class="star-picture-bd" onclick=starPicture("specifications['+i+'][picture]")></i>';
				html += '<i class="star-picture-ft"></i>';
				html += '<input class="form-control" type="hidden" name="specifications['+i+'][picture]" value="" placeholder="" autocomplete="off">';
			html += '</span>';
		html += '</td>';
		html += '<td><input class="form-control input-sm text-center" type="text" name="specifications['+i+'][name]" value="规格" placeholder="" autocomplete="off"></td>';
		html += '<td><input class="form-control input-sm text-center" type="text" name="specifications['+i+'][sku]" value="0" placeholder="" autocomplete="off"></td>';
		html += '<td><input class="form-control input-sm text-center" type="text" name="specifications['+i+'][market]" value="0.00" placeholder="" autocomplete="off" data-type="price"></td>';
		html += '<td><input class="form-control input-sm text-center" type="text" name="specifications['+i+'][selling]" value="0.00" placeholder="" autocomplete="off" data-type="price"></td>';
		html += '<td><input class="form-control input-sm text-center" type="text" name="specifications['+i+'][cost]" value="0.00" placeholder="" autocomplete="off" data-type="price"></td>';
		html += '<td><input class="form-control input-sm text-center" type="text" name="specifications['+i+'][quantity]" value="0" placeholder="" autocomplete="off" data-type="number"></td>';
		html += '<td><input class="form-control input-sm text-center" type="text" name="specifications['+i+'][position]" value="0" placeholder="" autocomplete="off" data-type="number"></td>';
		html += '<td>';
			html += '<button type="button" class="btn btn-secondary btn-sm" onclick="starDeleteSpecification(this);">删除规格</button>';
			html += '<input type="hidden" name="specifications['+i+'][id]" value="0">';
		html += '</td>';
	html += '</tr>';
	$(".star-table-specification tbody").append(html);
}
function starDeleteSpecification(object, id){
	if (id>0) {
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
		    		$.post(backend_path+'/product/specification/delete',{id:id,_token:$('input[name="_token"]').val()},function(res){
				        if(res.code === 200){
				        	starToast('success', res.text);
				        	setTimeout(function(){
				        		$(object).parent().parent().remove();
				        	},1000);
				        }else{
				        	starToast('fail', res.text);
				        }
				    },'json');
		    	}
		    }
		});
		return;
    }
	$(object).parent().parent().remove();
}

//加载屏幕
function starLoadScreen(){
	var width_side = $('.star-side').width();
	var width_foot = $(window).width() - width_side;
	
	$(".star-footer").width(width_foot);
	$('.star-side').height( $(window).height() - 50 );
	$('.star-main').height( $(window).height() - 100 );

	$('.star-login').css({
		'margin-top': -$('.star-login').height()/2,
	});
}

//提示弹窗
function starToast(state, message, timeout){
	
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
	var toast = bootbox.dialog({ 
		size: 'small', 
	    message: '<div class="star-toast">'+i+' <span>'+message+'</span></div>', 
	    closeButton: false
	});
	if(timeout == 0){
		return;
	}
	timeout=timeout||1000;
	setTimeout(function(){
		toast.modal('hide');
	},timeout);
};

//设置侧边栏
function starSetSide(){
	//$("body").toggleClass('side-mini');
	if($("body").hasClass('star-side-mini')){
		$('.star-side-state').removeClass('glyphicon-indent-left').addClass('glyphicon-indent-right');
		$("body").removeClass('star-side-mini');
		clearCookie('_side', '/');
	}else{
		$('.star-side-state').removeClass('glyphicon-indent-right').addClass('glyphicon-indent-left');
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

//添加修改跳转
function starAddJump(type, id){
	window.location.href = backend_path+'/'+type+'/add?id='+id;
}

//添加修改跳转退出
function starCancelJump(){
	history.go(-1);
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

//子级/返回上级
function starGoto(type, id){
	window.location.href = backend_path+'/'+type+'/index?parent='+id;
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

	if(data.name==''){
		starToast('fail', '请输入菜单名称');
		return;
	}

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

//设置保存
function starSettingSave(){
	$.post(backend_path+'/setting/save',$('form').serialize(),function(res){
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

//文章保存
function starArticleSave(){
	var data = new Object();
	data._token = $('input[name="_token"]').val();
	data.id = parseInt($('input[name="id"]').val());
	data.title = $.trim($('input[name="title"]').val());
	data.content = CKEDITOR.instances.content.getData();
	data.author = $.trim($('input[name="author"]').val());
	data.picture = $.trim($('input[name="picture"]').val());
	data.seo_title = $.trim($('input[name="seo_title"]').val());
	data.seo_description = $.trim($('input[name="seo_description"]').val());
	data.seo_keywords = $.trim($('input[name="seo_keywords"]').val());
	data.category_id = parseInt($('[name="category_id"]').val());
	data.state = parseInt($('[name="state"]').val());

	if(data.title==''){
		starToast('fail', '请输入文章标题');
		return;
	}

	$.post(backend_path+'/article/save',data,function(res){
		if(res.code === 200){
			starToast('success', res.text);
			setTimeout(function(){
				window.location.href = document.referrer;
			},1000);
		}else{
			starToast('fail', res.text);
		}
	},'json');
}

//商品保存
function starProductSave(){
	var data = new Object();
	data.name = $.trim($('input[name="name"]').val());
	/*console.log($('form').serialize());
	return;*/

	if(data.name==''){
		starToast('fail', '请输入商品名称');
		return;
	}

	$.post(backend_path+'/product/save',$('form').serialize(),function(res){
		if(res.code === 200){
			starToast('success', res.text);
			setTimeout(function(){
				window.location.href = document.referrer;
			},1000);
		}else{
			starToast('fail', res.text);
		}
	},'json');
}

//分类保存
function starCategorySave(type){
	var data = new Object();
	data._token = $('input[name="_token"]').val();
	data.parent = parseInt($('input[name="parent"]').val());
	data.id = parseInt($('input[name="id"]').val());
	data.name = $.trim($('input[name="name"]').val());
	data.position = parseInt($('input[name="position"]').val());
	data.state = $('#state').is(':checked')?0:1;

	if(data.name==''){
		starToast('fail', '请输入分类名称');
		return;
	}

	$.post(backend_path+'/'+type+'/category/save',data,function(res){
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

//图片上传
function starPicture(place){
	$('#upload_file').click();
	$('#upload_place').val(place);
}
//原生上传方式
function starUpload(){
	starToast('loading', '上传中...', 0);
	$('#upload_form').submit();
}
//原生上传成功
function starUploadSuccess(place, url){
	bootbox.hideAll();
	starToast('success', '上传成功');
	$('#upload_file').val('');
	$('input[name="'+place+'"]').val(url).trigger('change');
}
//原生上传失败
function starUploadFail(message){
	bootbox.hideAll();
	starToast('fail', message);
}

$(document).ready(function() {
	starLoadScreen();
	window.onresize = function(){
		starLoadScreen();
	}

	$('input[name^="editor"]').on('change',function(){
		var url = $(this).val();
		editor.insertElement(CKEDITOR.dom.element.createFromHtml('<img style="max-width:100%" src="' + url + '" border="0" title="image">'));
	});

	$(document).on('change','input[name*="picture"]',function(){
		var url = $(this).val();
		$(this).parent().css({
			'background-image':'url('+url+')',
		});
	});

	$(document).on('blur','input[data-type="price"]',function(){
		var value = $(this).val();
		var pattern = /^\d+(\.\d+)?$/;
		if (!pattern.test(value)) {
	        $(this).val('0.00');
	    }else{
	    	value = Number(value);
	    	$(this).val(value.toFixed(2));
	    }
	});

	$(document).on('blur','input[data-type="number"]',function(){
		var value = $(this).val();
		var pattern = /^\d+$/;
		if (!pattern.test(value)) {
	        $(this).val('0');
	        return;
	    }
	});

	/*$('input[data-type="price"]').blur(function() {
		var value = $(this).val();
		var pattern = /^\d+(\.\d+)?$/;
		if (!pattern.test(value)) {
	        $(this).val('0.00');
	    }else{
	    	value = Number(value);
	    	$(this).val(value.toFixed(2));
	    }
	});

	$('input[data-type="number"]').blur(function() {
		var value = $(this).val();
		var pattern = /^\d+$/;
		if (!pattern.test(value)) {
	        $(this).val('0');
	    }
	});*/

});