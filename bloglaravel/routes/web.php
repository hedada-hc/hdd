<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::group(['middleware'=>['web']],function(){
		//前台首页模板
		Route::get('/','Home\IndexController@index');
		//前台列表模板
		Route::get('cate/{cate_id}','Home\IndexController@cate');
		//前台内容模板
		Route::get('article/{art_id}','Home\IndexController@article');

		
		//登录模块路由
		Route::any('admin/login',"Admin\LoginController@login");

		Route::get("admin/code",'Admin\LoginController@code');

		//邮箱发送
		Route::any('admin/mail',"Admin\MailController@index");
		//邮件接收
		Route::any('admin/mail_db',"Admin\MailController@mail");

});


//middleware 设置中间件 	prefix 设置前缀  namespace设置命名空间
Route::group(['middleware'=>['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){

		//本路由组已经继承了admin.login 中间件防止没有登录也能访问后台首页
		//后台首页路由
		Route::get("index",'IndexController@index');//首页路由
		Route::get("info",'IndexController@info');//系统基本信息路由
		Route::get('quit','LoginController@quit');//退出路由
		Route::any('pass','IndexController@pass');//修改密码路由
		

		//文章分类资源路由，想要一条路由控制全部那么就需要用到资源路由了
		Route::resource('category',"CategoryController");
		//文章资源路由
		Route::resource('article','ArticleController');
		//友情链接资源路由
		Route::resource('links','LinksController');
		Route::post('links/changeOrder','LinksController@changeOrder');

		//自定义导航资源路由
		Route::resource('navs','NavsController');
		//网站配置路由
		Route::resource('config','ConfigController');
		//配置项排序s
		Route::any('config/changeOrder','ConfigController@changeOrder');
		//修改配置项内容
		Route::post('config/content','ConfigController@content');
		//写入配置项到文件
		Route::any('putfile','ConfigController@putfile');

		//修改分类排序
		Route::post('cate/changeOrder','CategoryController@changeOrder');

		Route::any('upload','CommonController@upload');//图片上传路由

});
