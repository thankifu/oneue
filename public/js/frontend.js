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
	/*var width_side = $('.star-side').width();
	var width_foot = $(window).width() - width_side;

	$('.star-login').css({
		'margin-top': -$('.star-login').height()/2,
	});*/
	var star_product_width = $(".star-list-product .star-image").width();
	var star_article_width = $(".star-list-article .star-image").width();
	var star_special_width = $(".star-list-special .star-image").width();
	$(".star-list-product .star-image").height(star_product_width);
	$(".star-list-product .star-image img").height(star_product_width);
	$(".star-list-article .star-image").height(star_article_width/1.875);
	$(".star-list-article .star-image img").height(star_article_width/1.875);
	$(".star-list-special .star-image").height(star_special_width/2.5);
	$(".star-list-special .star-image img").height(star_special_width/2.5);

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
}

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