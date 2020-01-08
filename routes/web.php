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

Route::get('/', 'Frontend\Home@index');

Route::get('login', 'Frontend\Account@showLogin')->name('login');
Route::post('login', 'Frontend\Account@login')->middleware('throttle:5,1');
Route::post('logout', 'Frontend\Account@logout')->name('logout');
Route::get('register', 'Frontend\Account@showRegister')->name('register');
Route::post('register', 'Frontend\Account@register')->middleware('throttle:5,1');

Route::get('article', 'Frontend\Article@index')->name('article');
Route::get('article/category/{id}', 'Frontend\Article@category')->name('article.category');
Route::get('article/{id}', 'Frontend\Article@item')->name('article.item');

Route::get('product', 'Frontend\Product@index')->name('product');
Route::get('product/category/{id}', 'Frontend\Product@category')->name('product.category');
Route::get('product/{id}', 'Frontend\Product@item')->name('product.item');

Route::get('help', 'Frontend\Help@index');
Route::get('help/{id}', 'Frontend\Help@item');

Route::any('wechat', 'Frontend\Wechat@index');
Route::any('wechat/auth', 'Frontend\Wechat@auth')->middleware(['web','auth.wechat']);
Route::any('wechat/payment', 'Frontend\Wechat@payment');
Route::any('wechat/notify', 'Frontend\Wechat@notify');

/*Route::get('wechat/auth', function(){
    $user = session('wechat.oauth_user.default'); //一句话， 拿到授权用户资料
    dd($user);
})->middleware('auth.wechat');*/

Route::get('auth/wechat', 'Frontend\Account@wechat');


Route::namespace('Frontend')->middleware('auth')->group(function () {
	Route::get('cart', 'Cart@index');
	Route::post('cart/create', 'Cart@create');
	Route::post('cart/increment', 'Cart@increment');
	Route::post('cart/decrement', 'Cart@decrement');
	Route::post('cart/delete', 'Cart@delete');

	Route::get('checkout', 'Checkout@index');
	Route::post('checkout/create', 'Checkout@create');
	Route::post('checkout/address', 'Checkout@address');
	Route::post('checkout/store', 'Checkout@store');

	Route::post('order/create', 'Order@create'); //创建
	Route::get('order/paid', 'Order@paid'); //付款状态

	Route::get('user', 'User@index');
	Route::get('user/setting', 'User@setting');
	Route::get('user/username', 'User@username');
	Route::get('user/address', 'User@address');
	Route::get('user/address/{id}', 'User@addressItem');
	Route::post('user/address/store', 'User@addressStore');

	Route::get('user/favorite', 'User@favorite');

	Route::get('user/order', 'User@order');
	Route::get('user/order/{id}', 'User@orderItem');

});

// 后台登录
Route::get('admin', 'Backend\Account@showLogin')->name('admin.login');
Route::post('admin/login', 'Backend\Account@Login')->middleware('throttle:5,1');
Route::post('admin/logout', 'Backend\Account@logout')->name('admin.logout');

// 后台管理
Route::prefix('admin')->namespace('Backend')->middleware(['auth.admin:admin','auth.menus'])->group(function () {

	//后台首页
	Route::get('home/index', 'Home@index');
	Route::get('home/welcome', 'Home@welcome');

	//管理员管理
	Route::get('admin/index','Admin@index');
	Route::get('admin/item','Admin@item');
	Route::post('admin/save','Admin@save');
	Route::post('admin/delete','Admin@delete');

	//角色管理
	Route::get('group/index','Group@index');
	Route::get('group/item','Group@item');
	Route::post('group/save','Group@save');

	//菜单管理
	Route::get('menu/index','Menu@index');
	Route::get('menu/item','Menu@item');
	Route::post('menu/save','Menu@save');
	Route::post('menu/delete','Menu@delete');

	//设置管理
	Route::get('setting/index','Setting@index');
	Route::get('setting/annex','Setting@annex');
	Route::post('setting/save','Setting@save');

	//文章管理
	Route::get('article/index','Article@index');
	Route::get('article/item','Article@item');
	Route::post('article/save','Article@save');
	Route::post('article/delete','Article@delete');
	Route::get('article/category/index','Article@categoryIndex');
	Route::get('article/category/item','Article@categoryItem');
	Route::post('article/category/save','Article@categorySave');
	Route::post('article/category/delete','Article@categoryDelete');

	//商品管理
	Route::get('product/index','Product@index');
	Route::get('product/item','Product@item');
	Route::post('product/save','Product@save');
	Route::post('product/delete','Product@delete');
	Route::get('product/category/index','Product@categoryIndex');
	Route::get('product/category/item','Product@categoryItem');
	Route::post('product/category/save','Product@categorySave');
	Route::post('product/category/delete','Product@categoryDelete');
	Route::post('product/specification/delete','Product@specificationDelete');

	//用户管理
	Route::get('user/index','User@index');
	Route::get('user/item','User@item');
	Route::post('user/save','User@save');
	Route::post('user/delete','User@delete');
	Route::get('user/level/index','User@levelIndex');
	Route::get('user/level/item','User@levelItem');
	Route::post('user/level/save','User@levelSave');
	Route::post('user/level/delete','User@levelDelete');

	//订单管理
	Route::get('order/index','Order@index');
	Route::get('order/item','Order@item');
	Route::post('order/save','Order@save');
	Route::post('order/delete','Order@delete');
	Route::get('order/product','Order@product');

	//帮助管理
	Route::get('help/index','Help@index');
	Route::get('help/item','Help@item');
	Route::post('help/save','Help@save');
	Route::post('help/delete','Help@delete');
	Route::get('help/category/index','Help@categoryIndex');
	Route::get('help/category/item','Help@categoryItem');
	Route::post('help/category/save','Help@categorySave');
	Route::post('help/category/delete','Help@categoryDelete');

	//轮播管理
	Route::get('slide/index','Slide@index');
	Route::get('slide/item','Slide@item');
	Route::post('slide/save','Slide@save');
	Route::post('slide/delete','Slide@delete');

	//上传
	Route::post('upload/index','Upload@index');

});
