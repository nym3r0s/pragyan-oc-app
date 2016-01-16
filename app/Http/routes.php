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
	$api->get('/debugGCMn00b', 'App\Http\Controllers\ChatController@debug');
});

// The routes which will need authentication in the form of client secret

$api->version('v1', ['middleware' => 'userauth'], function ($api) {

	$api->post('/gcm/register', 'App\Http\Controllers\GcmController@register');

	$api->post('/profile/getdetails', 'App\Http\Controllers\UserController@profileGetDetails');
	$api->post('/profile/getalldetails', 'App\Http\Controllers\UserController@profileGetAllDetails');

	$api->post('/task/chat/read','App\Http\Controllers\ChatController@getTaskMessages');
	$api->post('/task/chat/create','App\Http\Controllers\ChatController@createTaskMessages');

	$api->post('/task/create','App\Http\Controllers\TaskController@createTask');
	$api->post('/task/update','App\Http\Controllers\TaskController@updateTask');
	$api->post('/task/all','App\Http\Controllers\TaskController@getAllTasks');
	$api->post('/task/status/update','App\Http\Controllers\TaskController@updateTaskStatus');
	
	$api->post('/task/assign','App\Http\Controllers\TaskController@assignPeople');
	$api->post('/task/getassigned','App\Http\Controllers\TaskController@getAssignedForTask');
	
	$api->post('/task/delete','App\Http\Controllers\TaskController@deleteTask');
	$api->post('/task/target/all','App\Http\Controllers\TaskController@getUsersTasks');

});