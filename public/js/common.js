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

function numAdd(num1, num2) {
	var baseNum, baseNum1, baseNum2;
	try {
		baseNum1 = num1.toString().split(".")[1].length;
	} catch (e) {
		baseNum1 = 0;
	};
	try {
		baseNum2 = num2.toString().split(".")[1].length;
	} catch (e) {
		baseNum2 = 0;
	};
	baseNum = Math.pow(10, Math.max(baseNum1, baseNum2));
	return (num1 * baseNum + num2 * baseNum) / baseNum;
};
/**
 * 加法运算，避免数据相减小数点后产生多位数和计算精度损失。
 *
 * @param num1被减数  |  num2减数
 */
function numSub(num1, num2) {
	var baseNum, baseNum1, baseNum2;
	var precision;// 精度
	try {
		baseNum1 = num1.toString().split(".")[1].length;
	} catch (e) {
		baseNum1 = 0;
	};
	try {
		baseNum2 = num2.toString().split(".")[1].length;
	} catch (e) {
		baseNum2 = 0;
	};
	baseNum = Math.pow(10, Math.max(baseNum1, baseNum2));
	precision = (baseNum1 >= baseNum2) ? baseNum1 : baseNum2;
	return ((num1 * baseNum - num2 * baseNum) / baseNum).toFixed(precision);
};
/**
 * 乘法运算，避免数据相乘小数点后产生多位数和计算精度损失。
 *
 * @param num1被乘数 | num2乘数
 */
function numMulti(num1, num2) {
	var baseNum = 0;
	try {
		baseNum += num1.toString().split(".")[1].length;
	} catch (e) {

	};
	try {
		baseNum += num2.toString().split(".")[1].length;
	} catch (e) {

	};
	var baseNum5 = Number(num1.toString().replace(".", "")) * Number(num2.toString().replace(".", "")) / Math.pow(10, baseNum);
	return baseNum5.toFixed(2);//四舍五入保留小数点2位数
};
/**
 * 除法运算，避免数据相除小数点后产生多位数和计算精度损失。
 *
 * @param num1被除数 | num2除数
 */
function numDiv(num1, num2) {
	var baseNum1 = 0, baseNum2 = 0;
	var baseNum3, baseNum4;
	try {
		baseNum1 = num1.toString().split(".")[1].length;
	} catch (e) {
		baseNum1 = 0;
	};
	try {
		baseNum2 = num2.toString().split(".")[1].length;
	} catch (e) {
		baseNum2 = 0;
	};
	with (Math) {
		baseNum3 = Number(num1.toString().replace(".", ""));
		baseNum4 = Number(num2.toString().replace(".", ""));
		//return (baseNum3 / baseNum4) * pow(10, baseNum2 - baseNum1);
		var baseNum5 = (baseNum3 / baseNum4) * pow(10, baseNum2 - baseNum1);
		return baseNum5.toFixed(2);//四舍五入保留小数点2位数
	};
};

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

//框架
function starSetIframeHeight(iframe) {
	if (iframe) {
		var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
		if (iframeWin.document.body) {
			iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
		}
	}
};

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

//获取地址栏参数
function starGetQueryString(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r!=null)return  unescape(r[2]); return null;
};
	
//获取url参数
var redirect_url = starGetQueryString("redirect_url");