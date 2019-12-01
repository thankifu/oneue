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
    return view('welcome');
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
	Route::post('admin/setting/save','Setting@save');

	// 后台首页
	Route::get('admin/test/index', 'Test@index');
	Route::get('admin/test/admin','Test2@index');

	//文章管理
	Route::get('admin/article/index','Article@index');
	Route::get('admin/article/add','Article@add');
	Route::post('admin/article/save','Article@save');
	Route::post('admin/article/delete','Article@delete');

	Route::get('admin/article/category','Article@category');

});
