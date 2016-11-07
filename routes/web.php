<?php
Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@doLogin');

Route::get('/logout', 'AuthController@logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'AuthController@index');
});


