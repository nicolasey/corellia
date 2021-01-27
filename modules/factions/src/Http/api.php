<?php
Route::apiResource('groups', 'GroupsController');
Route::post('groups/{group}/join', 'AssignationController@join')->name('groups.join');
Route::post('groups/{group}/leave', 'AssignationController@join')->name('groups.leave');
Route::post('groups/{group}/find', 'AssignationController@find')->name('groups.find');