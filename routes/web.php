<?php
Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@doLogin');

Route::get('/logout', 'AuthController@logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'AuthController@index');
    Route::get('/password', 'AuthController@password');
    Route::post('/password', 'AuthController@changepass');
    Route::group(['prefix' => 'admin', 'middleware' => 'permission'], function () {
        Route::get('/', 'AdminController@acls');
        Route::get('/acls', 'AdminController@acls');
        Route::get('/acls/add', 'AdminController@addAcl');
        Route::post('/acls/add', 'AdminController@doAddAcl');
        Route::get('/users', 'AdminController@users');
        Route::get('/users/add', 'AdminController@addUser');
        Route::post('/users/add', 'AdminController@doAddUser');
        Route::get('/roles', 'AdminController@roles');
        Route::get('/roles/add', 'AdminController@addRole');
        Route::post('/roles/add', 'AdminController@doAddRole');
        Route::get('/hosts', 'AdminController@hosts');
        Route::get('/hosts/add', 'AdminController@addHost');
        Route::post('/hosts/add', 'AdminController@doAddHost');
        Route::get('/hosts/del', 'AdminController@delHost');
        Route::get('/config', 'AdminController@config');
        Route::post('/config', 'AdminController@saveConfig');
    });
});


