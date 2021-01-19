<?php
Route::post('login', ['uses' => 'AuthController@login', 'name' => 'login']);
Route::get('me', 'AuthController@me')->name('me');
Route::get('logout', 'AuthController@logout');