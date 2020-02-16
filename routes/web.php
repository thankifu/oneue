<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//首页
Route::get('/', 'Frontend\Home@index');

//登录
Route::get('login', 'Frontend\Account@showLogin')->name('login');
Route::post('login', 'Frontend\Account@login')->middleware('throttle:5,1');
Route::post('logout', 'Frontend\Account@logout')->name('logout');

//注册
Route::get('register', 'Frontend\Account@showRegister')->name('register');
Route::post('register', 'Frontend\Account@register');

//重置密码
Route::get('reset', 'Frontend\Account@reset');
Route::post('reset/auth', 'Frontend\Account@resetAuth');
Route::post('reset/store', 'Frontend\Account@resetStore');

//邮件发送
Route::post('email', 'Frontend\Email@index')->middleware('throttle:5,1');
Route::post('email/reset', 'Frontend\Email@reset')->middleware('throttle:5,1');

//文章
Route::get('article', 'Frontend\Article@index');
Route::get('article/category/{id}', 'Frontend\Article@category');
Route::get('article/{id}', 'Frontend\Article@show');

//商品
Route::get('product', 'Frontend\Product@index');
Route::get('product/category/{id}', 'Frontend\Product@category');
Route::get('product/{id}', 'Frontend\Product@show');

//帮助
Route::get('help', 'Frontend\Help@index');
Route::get('help/{id}', 'Frontend\Help@show');

//微信
Route::any('wechat/auth', 'Frontend\Wechat@auth')->middleware(['auth.wechat']);
Route::any('wechat/payment', 'Frontend\Wechat@payment');
Route::any('wechat/notify', 'Frontend\Wechat@notify');

//搜索
Route::get('search/{type?}', 'Frontend\Search@index');

//前台登录后
Route::namespace('Frontend')->middleware('auth')->group(function () {

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
	Route::post('order/create', 'Order@create'); //创建
	Route::get('order/paid', 'Order@paid'); //付款状态

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
	Route::get('user/like/{type?}', 'User@like');
	Route::post('user/like/store', 'User@likeStore');
	Route::get('user/order', 'User@order');
	Route::get('user/order/{id}', 'User@orderShow');
	Route::post('user/order/store', 'User@orderStore');

	//上传
	Route::post('upload/index','Upload@index');

});

// 后台登录
Route::prefix('admin')->namespace('Backend')->group(function () {
	Route::get('', 'Account@showLogin')->name('admin.login');
	Route::post('login', 'Account@Login')->middleware('throttle:5,1');
	Route::post('logout', 'Account@logout')->name('admin.logout');
});

// 后台管理
Route::prefix('admin')->namespace('Backend')->middleware(['auth.admin:admin','auth.menus'])->group(function () {

	//后台首页
	Route::get('home/index', 'Home@index');
	Route::get('home/welcome', 'Home@welcome');

	//管理员管理
	Route::get('admin/index','Admin@index');
	Route::get('admin/show','Admin@show');
	Route::post('admin/store','Admin@store');
	Route::post('admin/delete','Admin@delete');

	//角色管理
	Route::get('group/index','Group@index');
	Route::get('group/show','Group@show');
	Route::post('group/store','Group@store');

	//菜单管理
	Route::get('menu/index','Menu@index');
	Route::get('menu/show','Menu@show');
	Route::post('menu/store','Menu@store');
	Route::post('menu/delete','Menu@delete');

	//设置管理
	Route::get('setting/index','Setting@index');
	Route::get('setting/annex','Setting@annex');
	Route::post('setting/store','Setting@store');

	//操作日志
	Route::get('log/index','Log@index');

	//文章管理
	Route::get('article/index','Article@index');
	Route::get('article/show','Article@show');
	Route::post('article/store','Article@store');
	Route::post('article/delete','Article@delete');
	Route::get('article/category/index','Article@categoryIndex');
	Route::get('article/category/show','Article@categoryShow');
	Route::post('article/category/store','Article@categoryStore');
	Route::post('article/category/delete','Article@categoryDelete');

	//商品管理
	Route::get('product/index','Product@index');
	Route::get('product/show','Product@show');
	Route::post('product/store','Product@store');
	Route::post('product/delete','Product@delete');
	Route::get('product/category/index','Product@categoryIndex');
	Route::get('product/category/show','Product@categoryShow');
	Route::post('product/category/store','Product@categoryStore');
	Route::post('product/category/delete','Product@categoryDelete');
	Route::post('product/specification/delete','Product@specificationDelete');

	//用户管理
	Route::get('user/index','User@index');
	Route::get('user/show','User@show');
	Route::post('user/store','User@store');
	Route::post('user/delete','User@delete');
	Route::get('user/level/index','User@levelIndex');
	Route::get('user/level/show','User@levelShow');
	Route::post('user/level/store','User@levelStore');
	Route::post('user/level/delete','User@levelDelete');

	//订单管理
	Route::get('order/index','Order@index');
	Route::get('order/show','Order@show');
	Route::post('order/store','Order@store');
	Route::post('order/delete','Order@delete');
	Route::get('order/shipment/show','Order@shipmentShow');
	Route::post('order/shipment/store','Order@shipmentStore');

	//帮助管理
	Route::get('help/index','Help@index');
	Route::get('help/show','Help@show');
	Route::post('help/store','Help@store');
	Route::post('help/delete','Help@delete');
	Route::get('help/category/index','Help@categoryIndex');
	Route::get('help/category/show','Help@categoryShow');
	Route::post('help/category/store','Help@categoryStore');
	Route::post('help/category/delete','Help@categoryDelete');

	//轮播管理
	Route::get('slide/index','Slide@index');
	Route::get('slide/show','Slide@show');
	Route::post('slide/store','Slide@store');
	Route::post('slide/delete','Slide@delete');

	//上传
	Route::post('upload/index','Upload@index');

});
