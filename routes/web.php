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

/*Route::get('/',function (){
   return view('index');
});*/
Route::get('/','PageController@index');

Auth::routes();
Route::group(['prefix'=>'admin','middleware'=>'checkstatus'],function(){
	Route::get('/list',['as'=>'admin.list','uses'=>'AdminController@list']);
	Route::get('/page',['as'=>'admin.page','uses'=>'AdminController@index']);
	Route::post('/add',['as'=>'admin.add','uses'=>'AdminController@create']);
	Route::get('/edit/{id}',['as'=>'admin.edit','uses'=>'AdminController@store']);
	Route::post('/edit/{id}',['as'=>'admin.edit','uses'=>'AdminController@update']);
	Route::get('/delete/{id}',['as'=>'admin.delete','uses'=>'AdminController@destroy']);
});