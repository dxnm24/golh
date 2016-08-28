<?php
Route::group(['middleware' => ['auth:admin']], function ($router) {
    // Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.index']);
    Route::get('/', 'GameController@index');
    //account
    Route::get('account/{id}/password', ['uses' => 'AccountController@password', 'as' => 'admin.account.password']);
    Route::post('account/{id}/password', ['uses' => 'AccountController@doPassword', 'as' => 'admin.account.password']);
    Route::resource('account', 'AccountController');
    //menu
    Route::post('menu/callupdate', 'MenuController@callupdate');
    Route::resource('menu', 'MenuController');
    //game tag
    Route::resource('gametag', 'GameTagController');
    //game type
    Route::post('gametype/callupdate', 'GameTypeController@callupdate');
    Route::resource('gametype', 'GameTypeController');
    //game
    Route::get('game/search', ['uses' => 'GameController@search', 'as' => 'admin.game.search']);
    Route::resource('game', 'GameController');
    //ads
    Route::resource('ad', 'AdController');
    //config
    Route::resource('config', 'ConfigController');
});
Route::get('login', ['uses' => 'AuthController@index', 'as' => 'admin.auth.index']);
Route::post('login', ['uses' => 'AuthController@login', 'as' => 'admin.auth.login']);
Route::get('logout', ['uses' => 'AuthController@logout', 'as' => 'admin.auth.logout']);
// Route::get('password/reset/{token?}', ['uses' => 'PasswordController@showResetForm', 'as' => 'admin.password.reset']);
// Route::post('password/reset', ['uses' => 'PasswordController@reset', 'as' => 'admin.password.reset']);
// Route::post('password/email', ['uses' => 'PasswordController@sendResetLinkEmail', 'as' => 'admin.password.email']);
