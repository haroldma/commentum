<?php
/*
* GET routes
*/
Route::get('/', 'PageController@index');
Route::get('/login', 'PageController@login');

Route::group(['middleware' => 'auth'], function()
{
	Route::get('/submit', 'PageController@submit');
	Route::get('/logout', 'UserController@logout');
});

/*
* POST routes
*/
Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::group(['middleware' => 'auth'], function()
{
	Route::post('/submit', 'QuestionController@submit');
});