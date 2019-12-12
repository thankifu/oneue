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


//加载屏幕
function starLoadScreen(){
	var width_side = $('.star-side').width();
	var width_foot = $(window).width() - width_side;

	$('.star-login').css({
		'margin-top': -$('.star-login').height()/2,
	});
}

$(document).ready(function() {
	starLoadScreen();
	window.onresize = function(){
		starLoadScreen();
	}
});