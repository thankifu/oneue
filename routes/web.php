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

Route::get('/', function () {
    return view('frontend/home/index');
});

// 后台登录
Route::get('admin', 'Backend\Account@showLogin')->name('admin.login');
Route::post('admin/login', 'Backend\Account@Login')->middleware('throttle:5,1');
Route::get('admin/logout', 'Backend\Account@logout')->name('admin.logout');

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

	Route::get('admin/setting/index','Setting@index');
	Route::get('admin/setting/annex','Setting@annex');
	Route::post('admin/setting/save','Setting@save');

	// 后台首页
	Route::get('admin/test/index', 'Test@index');
	Route::get('admin/test/admin','Test2@index');

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
