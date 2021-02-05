<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::post('login', ['uses' => 'AuthController@login', 'name' => 'login']);
Route::get('me', 'AuthController@me')->name('me');
Route::get('logout', 'AuthController@logout');

Route::apiResource('users', 'UsersController');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return response()->json([], 200);
})->middleware(['auth:api'])->name('verification.verify');
