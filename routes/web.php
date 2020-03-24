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

/* Admins routes */
Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/admin', 'HomeController@index');
    Route::resource('/admin/users', 'UserController', ['as' => 'admin']);
});

/* Visitors routes */
Route::group(['middleware' => 'visitors'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/login', 'LoginController@login');
        Route::post('/login', 'LoginController@postLogin')->name('login');
    });
});

/* Authenticated users */
Route::group(['middleware' => 'user'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });
    Route::group(['namespace' => 'User'], function () {
        Route::get('/', 'HomeController@index');
        Route::get('/edit-profile', 'ProfileController@edit');
        Route::post('/edit-profile', 'ProfileController@update');
    });
});

Route::get('/', 'SiteController@index');
Route::get('/contact', 'SiteController@contact');
/* Telegram routes */
//Route::get('me', 'TelegramController@me');
//Route::get('updates', 'TelegramController@updates');
//Route::get('respond', 'TelegramController@respond');
//Route::get('setWebHook', 'TelegramController@setWebHook');
//Route::get('removeWebHook', 'TelegramController@removeWebhook');
//Route::post(env('TELEGRAM_BOT_TOKEN').'/webhook', 'TelegramController@webhook');
//Route::get('/Telegram/{code}', 'TelegramController@telegram');


