<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('forums', 'ForumController');
Route::apiResource('forums.topics', 'TopicController');
Route::get('forums/{forum}/topics/{topic}/follow', 'TopicController@follow')->name('topic.follow')->middleware('jwt.auth');
Route::apiResource('topics.posts', 'PostController');
