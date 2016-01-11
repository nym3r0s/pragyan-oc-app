<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

$api = app('Dingo\Api\Routing\Router');

// The open and unauth routes

$api->version('v1', function ($api) {
	$api->post('/login', 'App\Http\Controllers\UserController@login');
});

// The routes which will need authentication in the form of client secret

$api->version('v1', ['middleware' => 'userauth'], function ($api) {

	$api->get('/gcm/register', 'App\Http\Controllers\GcmController@register');

});