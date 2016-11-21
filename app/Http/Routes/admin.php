<?php
Route::group(['middleware' => ['auth:admin']], function ($router) {
    // Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.index']);
    Route::get('/', 'GameController@index');
    //account
    Route::get('account/{id}/password', ['uses' => 'AccountController@password', 'as' => 'admin.account.password']);
    Route::post('account/{id}/password', ['uses' => 'AccountController@doPassword', 'as' => 'admin.account.password']);
    Route::resource('account', 'AccountController');
    //menu
    Route::post('menu/updateStatus', 'MenuController@updateStatus');
    Route::post('menu/callupdate', 'MenuController@callupdate');
    Route::resource('menu', 'MenuController');
    //game tag
    Route::post('gametag/updateStatus', 'GameTagController@updateStatus');
    Route::resource('gametag', 'GameTagController');
    //game type
    Route::post('gametype/updateStatus', 'GameTypeController@updateStatus');
    Route::post('gametype/callupdate', 'GameTypeController@callupdate');
    Route::resource('gametype', 'GameTypeController');
    //game
    Route::post('game/updateStatus', 'GameController@updateStatus');
    Route::get('game/search', ['uses' => 'GameController@search', 'as' => 'admin.game.search']);
    Route::resource('game', 'GameController');
    //ads
    Route::post('ad/updateStatus', 'AdController@updateStatus');
    Route::resource('ad', 'AdController');
    //config
    Route::resource('config', 'ConfigController');
    //clear all cache & views
    Route::get('clearallstorage', 'AdminController@clearallstorage');
    //page
    Route::post('page/updateStatus', 'PageController@updateStatus');
    Route::resource('page', 'PageController');
});
Route::get('login', ['uses' => 'AuthController@index', 'as' => 'admin.auth.index']);
Route::post('login', ['uses' => 'AuthController@login', 'as' => 'admin.auth.login']);
Route::get('logout', ['uses' => 'AuthController@logout', 'as' => 'admin.auth.logout']);
// Route::get('password/reset/{token?}', ['uses' => 'PasswordController@showResetForm', 'as' => 'admin.password.reset']);
// Route::post('password/reset', ['uses' => 'PasswordController@reset', 'as' => 'admin.password.reset']);
// Route::post('password/email', ['uses' => 'PasswordController@sendResetLinkEmail', 'as' => 'admin.password.email']);
