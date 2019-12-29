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

/*Route::get('/', function () {
    return view('frontend/home/index');
});*/
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

Route::any('wechat', 'Frontend\Wechat@serve');

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

	Route::post('payment', 'Payment@index');

	Route::get('user', 'User@index');
	Route::get('user/setting', 'User@setting');
	Route::get('user/username', 'User@username');
	Route::get('user/password', 'User@password');
	Route::get('user/phone', 'User@phone');
	Route::post('user/password/store', 'User@passwordStore');
	Route::post('user/phone/check', 'User@phoneStore');
	Route::post('user/phone/store', 'User@phoneStore');

	Route::get('user/address', 'User@address');
	Route::get('user/address/{id}', 'User@addressItem');
	Route::post('user/address/store', 'User@addressStore');

	Route::get('user/favorite', 'User@favorite');

	Route::get('user/order', 'User@order');
	Route::get('user/order/{id}', 'User@orderItem');
	Route::get('user/order/queren', 'User@orderQueren');

	
	/*Route::post('favorite', 'Action@favorite');
	Route::post('cart', 'Action@cart');
	Route::post('checkout', 'Action@checkout');
	Route::post('order', 'Action@order');
	Route::post('payment', 'Action@payment');*/

});

// 后台登录
Route::get('admin', 'Backend\Account@showLogin')->name('admin.login');
Route::post('admin/login', 'Backend\Account@Login')->middleware('throttle:5,1');
Route::post('admin/logout', 'Backend\Account@logout')->name('admin.logout');

// 后台管理
Route::namespace('Backend')->middleware(['auth.admin:admin','auth.menus'])->group(function () {

	//后台首页
	Route::get('admin/home/index', 'Home@index');
	Route::get('admin/home/welcome', 'Home@welcome');

	//管理员管理
	Route::get('admin/admin/index','Admin@index');
	Route::get('admin/admin/add','Admin@add');
	Route::post('admin/admin/save','Admin@save');
	Route::post('admin/admin/delete','Admin@delete');

	// 角色管理
	Route::get('admin/group/index','Group@index');
	Route::get('admin/group/add','Group@add');
	Route::post('admin/group/save','Group@save');

	//菜单管理
	Route::get('admin/menu/index','Menu@index');
	Route::get('admin/menu/add','Menu@add');
	Route::post('admin/menu/save','Menu@save');
	Route::post('admin/menu/delete','Menu@delete');

	//设置管理
	Route::get('admin/setting/index','Setting@index');
	Route::get('admin/setting/annex','Setting@annex');
	Route::get('admin/setting/wechat','Setting@wechat');
	Route::post('admin/setting/save','Setting@save');

	//文章管理
	Route::get('admin/article/index','Article@index');
	Route::get('admin/article/add','Article@add');
	Route::post('admin/article/save','Article@save');
	Route::post('admin/article/delete','Article@delete');

	Route::get('admin/article/category/index','Article@category');
	Route::get('admin/article/category/add','Article@categoryAdd');
	Route::post('admin/article/category/save','Article@categorySave');
	Route::post('admin/article/category/delete','Article@categoryDelete');

	//商品管理
	Route::get('admin/product/index','Product@index');
	Route::get('admin/product/add','Product@add');
	Route::post('admin/product/save','Product@save');
	Route::post('admin/product/delete','Product@delete');

	Route::get('admin/product/category/index','Product@category');
	Route::get('admin/product/category/add','Product@categoryAdd');
	Route::post('admin/product/category/save','Product@categorySave');
	Route::post('admin/product/category/delete','Product@categoryDelete');

	Route::post('admin/product/specification/delete','Product@specificationDelete');

	//用户管理
	Route::get('admin/user/index','User@index');
	Route::get('admin/user/add','User@add');
	Route::post('admin/user/save','User@save');
	Route::post('admin/user/delete','User@delete');
	Route::get('admin/user/level/index','User@levelIndex');
	Route::get('admin/user/level/add','User@levelAdd');
	Route::post('admin/user/level/save','User@levelSave');
	Route::post('admin/user/level/delete','User@levelDelete');

	//订单管理
	Route::get('admin/order/index','Order@index');
	Route::get('admin/order/add','Order@add');
	Route::post('admin/order/save','Order@save');
	Route::post('admin/order/delete','Order@delete');
	Route::get('admin/order/product','Order@product');

	//上传
	Route::post('admin/upload/index','Upload@index');

});
