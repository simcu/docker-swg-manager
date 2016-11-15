<?php
Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@doLogin');
Route::get('/captcha/{tmp}', 'AuthController@captcha');

Route::get('/logout', 'AuthController@logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'AuthController@index');
    Route::get('/password', 'AuthController@password');
    Route::post('/password', 'AuthController@changepass');
    Route::group(['prefix' => 'admin', 'middleware' => 'permission'], function () {
        Route::get('/', 'AdminController@roles');

        Route::get('/users', 'AdminController@users');
        Route::get('/users/add', 'AdminController@addUser');
        Route::post('/users/add', 'AdminController@doAddUser');
        Route::get('/users/del', 'AdminController@delUser');


        Route::get('/roles', 'AdminController@roles');
        Route::get('/roles/add', 'AdminController@addRole');
        Route::post('/roles/add', 'AdminController@doAddRole');
        Route::get('/roles/del', 'AdminController@delRole');
        Route::get('/roles/detail', 'AdminController@detailRole');
        Route::get('/roles/detail/host/del', 'AdminController@detailRoleDelHost');
        Route::get('/roles/detail/user/del', 'AdminController@detailRoleDelUser');
        Route::post('/roles/detail/host/add', 'AdminController@detailRoleAddHost');
        Route::post('/roles/detail/user/add', 'AdminController@detailRoleAddUser');


        Route::get('/hosts', 'AdminController@hosts');
        Route::get('/hosts/add', 'AdminController@addHost');
        Route::post('/hosts/add', 'AdminController@doAddHost');
        Route::get('/hosts/del', 'AdminController@delHost');


        Route::get('/config', 'AdminController@config');
        Route::post('/config', 'AdminController@saveConfig');
        Route::get('/sync', 'AdminController@sync');
    });
});


