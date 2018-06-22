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
Lesson12 9.2 ログイン認証を必要とするルーティンググループ内に
             Microposts（投稿）のルーティングを設定
*/
Route::get('/', 'MicropostsController@index');

/*
Lesson12 6.2 ユーザ登録のルーティング追加

->name() はこのルーティングに名前を付けているだけです。
Form や link_to_route() で使用します。
*/

Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

/*
Lesson12 7.1 ログイン機能のルーティング追加
*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

/*
Lesson12 8.2 ログイン認証付きのルーティング追加
*/
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);

    /* Lesson12 10.2 フォロー機能*/
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        Route::get('favoriteMicroposts', 'FavoritesController@index')->name('favorites.favoriteMicroposts');
    });

    /* 課題：お気に入り機能 */
    Route::group(['prefix' => 'microposts/{micropost_id}'], function () {
        Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('favorites.unfavorite');
    });

    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]); /*Lesson12 9.2*/
});