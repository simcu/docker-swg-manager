<?php
Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@doLogin');

Route::get('/logout', 'AuthController@logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'AuthController@index');
    Route::group(['prefix' => 'admin','middleware' => 'permission'], function () {
        Route::get('/', 'AdminController@acls');
        Route::get('/acls', 'AdminController@acls');
        Route::get('/users', 'AdminController@users');
        Route::get('/roles', 'AdminController@roles');
        Route::get('/hosts', 'AdminController@hosts');
        Route::get('/config', 'AdminController@config');
        Route::post('/config', 'AdminController@saveConfig');
    });
});


