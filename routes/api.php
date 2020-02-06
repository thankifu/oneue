<?php

//use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::prefix('v1')->get('/user', function() {
    Route::get('/t', function () {
    	return 'ok';
  	});
});*/

Route::prefix('v1')->group(function () {
	Route::namespace('Api\Frontend')->group(function () {
	  	Route::post('login', 'Account@login');
	  	Route::post('register', 'Account@register');

	  	//首页
		Route::get('home', 'Home@index');

	  	//文章
		Route::get('article', 'Article@index');
		Route::get('article/category/{id}', 'Article@category');
		Route::get('article/{id}', 'Article@show');

		//商品
		Route::get('product', 'Product@index');
		Route::get('product/category/{id}', 'Product@category');
		Route::get('product/{id}', 'Product@show');

		//帮助
		Route::get('help', 'Frontend\Help@index');
		Route::get('help/{id}', 'Frontend\Help@show');

		//微信
		Route::any('wechat/auth/mini-program', 'Wechat@authMiniProgram');
		Route::any('wechat/payment/mini-program', 'Wechat@paymentMiniProgram');
		Route::any('wechat/notify/mini-program', 'Wechat@notifyMiniProgram');

		//搜索
		Route::get('search/{type?}', 'Frontend\Search@index');
	  	
	  	Route::group(['middleware' => 'auth.api'], function () {
	  		Route::post('logout', 'Account@logout');

	  		//购物车
			Route::get('cart', 'Cart@index');
			Route::post('cart/create', 'Cart@create');
			Route::post('cart/increment', 'Cart@increment');
			Route::post('cart/decrement', 'Cart@decrement');
			Route::post('cart/delete', 'Cart@delete');

			//结算台
			Route::get('checkout', 'Checkout@index');
			Route::post('checkout/create', 'Checkout@create');
			Route::post('checkout/address', 'Checkout@address');
			Route::post('checkout/store', 'Checkout@store');

			//订单
			Route::post('order/create', 'Order@create');
			Route::get('order/paid', 'Order@paid');

			//用户中心
			Route::get('user', 'User@index');
			Route::get('user/setting', 'User@setting');
			Route::get('user/avatar', 'User@avatar');
			Route::post('user/avatar/store', 'User@avatarStore');
			Route::post('user/sex/store', 'User@sexStore');
			Route::post('user/age/store', 'User@ageStore');
			Route::get('user/confirmation', 'User@confirmation');
			Route::post('user/confirmation/auth', 'User@confirmationAuth');
			Route::get('user/email', 'User@email');
			Route::post('user/email/store', 'User@emailStore');
			Route::get('user/password', 'User@password');
			Route::post('user/password/store', 'User@passwordStore');
			Route::get('user/address', 'User@address');
			Route::get('user/address/{id}', 'User@addressShow');
			Route::post('user/address/store', 'User@addressStore');
			Route::get('user/like', 'User@like');
			Route::post('user/like/store', 'User@likeStore');
			Route::get('user/order', 'User@order');
			Route::get('user/order/{id}', 'User@orderShow');
			Route::post('user/order/store', 'User@orderStore');

			//上传
			Route::post('upload/index','Upload@index');
		});
	});
});
