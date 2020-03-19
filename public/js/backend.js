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

var backend_path = '/admin';

$('.star-login #username').focus();
    
// 回车登录
$('.star-login input').keydown(function(e){
    if(e.keyCode==13){
       starLogin();
    }
});
    
function starLogin(){
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

//退出
function starLogout(){
	var data = new Object();
    data._token = $('input[name="_token"]').val();
	$.post(backend_path+'/logout',data,function(res){
		if(res.code === 200){
			starToast('success', res.text);
			setTimeout(function(){
				window.location.href = '/admin'
			},1000);
		}else{
			starToast('fail', res.text);
		}
	},'json');
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

//菜单点击
function starMenuClick(_this){
	var controller = $.trim($(_this).attr('controller'));
	var action = $.trim($(_this).attr('action'));
	if(controller==''||action==''){
		return;
	}
	/*
	var src = '/admin/'+controller+'/'+action;
	$('.star-main-iframe').attr('src',src);
	window.location.hash = '/'+controller+'/'+action;*/
 
	var src = $.trim($(_this).attr('data'));
	$('.star-main-iframe').attr('src',src);

	var url = src.replace("/admin","");;
	window.location.hash = url;

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
		var src = backend_path+url;
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
function starShow(type, id, parent){
	id = id || 0;
	parent = parent || 0;

	var title = '';
	if(type == 'order'){
		title = '订单详情';
	}else{
		title = id>0?'编辑':'添加';
	}

	bootbox.dialog({
		title: title,
	    message: '<iframe src="'+backend_path+'/'+type+'/show?id='+id+'&parent='+parent+'" width="100%" frameborder="0" scrolling="auto" onload="starSetIframeHeight(this)"></iframe>'
	});
}

//添加修改退出
function starCancel(){
	parent.bootbox.hideAll();
}

//添加修改跳转
function starShowJump(type, id){
	window.location.href = backend_path+'/'+type+'/show?id='+id;
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
function starAdminStore(){
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
	$.post(backend_path+'/admin/store',data,function(res){
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
function starGroupStore(){
	var name = $.trim($('input[name="name"]').val());
	if(name==''){
		starToast('fail', '请输入管理组名');
		return;
	}
	$.post(backend_path+'/group/store',$('form').serialize(),function(res){
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
function starMenuStore(){
	var name = $.trim($('input[name="name"]').val());
	if(name==''){
		starToast('fail', '请输入菜单名称');
		return;
	}

	var data = $('form').serialize();
	var hidden = $('#hidden').is(':checked')?1:0;
	var state = $('#state').is(':checked')?0:1;
	data += '&state=' + state;
	data += '&hidden=' + hidden;

	$.post(backend_path+'/menu/store',data,function(res){
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
function starSettingStore(){
	$.post(backend_path+'/setting/store',$('#form').serialize(),function(res){
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
function starArticleStore(){
	var data = $('#form').starSerializeJson();
	data.content = CKEDITOR.instances.content.getData();

	if(data.title == '' || data.title == undefined){
		starToast('fail', '请输入文章标题');
		return;
	}

	$.post(backend_path+'/article/store',data,function(res){
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
function starProductStore(){
	var data = $('#form').starSerializeJson();
	data.description = CKEDITOR.instances.description.getData();

	if(data.name == '' || data.name == undefined){
		starToast('fail', '请输入商品名称');
		return;
	}

	$.post(backend_path+'/product/store',data,function(res){
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

function starSpecificationAdd(){
	var i = $(".star-table-specification tbody tr").length;
	var html = '';
	html += '<tr>';
		html += '<td>';
			html += '<span class="star-picture star-picture-square star-mr-10" style="background-image:url(/images/star-upload-image.png);">';
				html += "<i class='star-picture-bd' onclick=starPicture('product','specifications["+i+"][picture]')></i>";
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
			html += '<button type="button" class="btn btn-secondary btn-sm" onclick="starSpecificationDelete(this);">删除规格</button>';
			html += '<input type="hidden" name="specifications['+i+'][id]" value="0">';
		html += '</td>';
	html += '</tr>';
	$(".star-table-specification tbody").append(html);
}
function starSpecificationDelete(object, id){
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

//分类保存
function starCategoryStore(type){
	var data = $('form').starSerializeJson();
	data.state = $('#state').is(':checked')?0:1;

	if(data.name == '' || data.name == undefined){
		starToast('fail', '请输入分类名称');
		return;
	}

	$.post(backend_path+'/'+type+'/category/store',data,function(res){
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

//用户保存
function starUserStore(){
	var id = $.trim($('input[name="id"]').val());
	var username = $.trim($('input[name="username"]').val());
	var password = $.trim($('input[name="password"]').val());
	if(username==''){
		starToast('fail', '请输入用户名');
		return;
	}
	if(id == 0 && password == ''){
		starToast('fail', '请输入密码');
		return;
	}

	var data = $('form').serialize();
	var state = $('#state').is(':checked')?0:1;
	data += '&state=' + state;

	$.post(backend_path+'/user/store',data,function(res){
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

//用户等级保存
function starUserLevelStore(){
	var id = $.trim($('input[name="id"]').val());
	var name = $.trim($('input[name="name"]').val());
	var discount = $.trim($('input[name="discount"]').val());
	if(name==''){
		starToast('fail', '请输入等级名称');
		return;
	}
	if(discount==''){
		starToast('fail', '请输入等级折扣');
		return;
	}

	var data = $('form').serialize();
	var state = $('#state').is(':checked')?0:1;
	data += '&state=' + state;

	$.post(backend_path+'/user/level/store',data,function(res){
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

//发货保存
function starShipmentStore(){
	var id = $.trim($('select[name="express_id"]').val());
	var name = $.trim($('input[name="express_no"]').val());
	if(id==''){
		starToast('fail', '请选择快递公司');
		return;
	}
	if(name==''){
		starToast('fail', '请输入快递单号');
		return;
	}

	var data = $('form').serialize();

	$.post(backend_path+'/order/shipment/store',data,function(res){
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

//帮助保存
function starHelpStore(){
	var data = $('#form').starSerializeJson();
	data.content = CKEDITOR.instances.content.getData();

	if(data.title == '' || data.title == undefined){
		starToast('fail', '请输入帮助标题');
		return;
	}

	$.post(backend_path+'/help/store',data,function(res){
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

//轮播保存
function starSlideStore(){
	var title = $.trim($('input[name="title"]').val());
	if(title==''){
		starToast('fail', '请输入轮播标题');
		return;
	}

	var data = $('#form').serialize();
	var state = $('#state').is(':checked')?0:1;
	data += '&state=' + state;

	$.post(backend_path+'/slide/store',data,function(res){
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

	$(document).on('blur','input[data-type="discount"]',function(){
		var value = $(this).val();
		var pattern = /^\d+(\.\d+)?$/;
		if (!pattern.test(value)) {
	        $(this).val('0.0');
	    }else{
	    	value = Number(value);
	    	$(this).val(value.toFixed(1));
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