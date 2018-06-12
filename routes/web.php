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
| このコントローラーは、新規ユーザーとそのユーザーの登録を処理します。
| 検証と作成。 デフォルトでは、このコントローラは特性を使用して
| 追加のコードを必要とせずにこの機能を提供します。
*/

Route::get('/', function () {
    return view('welcome');
});

/*
Lesson12　6.2　ユーザ登録のルーティング追加

->name() はこのルーティングに名前を付けているだけです。
Form や link_to_route() で使用します。
*/

Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
