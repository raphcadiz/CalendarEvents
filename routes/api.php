<?php

use Illuminate\Http\Request;

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

//Route::post('/event/save', 'EventController@postEvent')->name('post.event');

Route::group(['middleware' => 'api'], function() {
	Route::get('/events', 'EventController@getEvents')->name('get.events');
	Route::post('/event/save', 'EventController@postEvent')->name('post.event');
	Route::post('/events/clear', 'EventController@deleteEvents')->name('post.events.clear');
});