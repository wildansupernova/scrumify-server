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
Route::get('/wildan', 'UserController@testMasukAuthAPI')->middleware('auth:api');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', 'UserController@generateToken');
Route::post('/logout', 'UserController@logOut')->middleware('auth:api');


//Task
Route::post('/tasks', 'TaskController@store')->middleware('auth:api');
Route::get('/tasks/{taskId}', 'TaskController@show')->middleware('auth:api');
Route::put('/tasks/{taskId}', 'TaskController@update')->middleware('auth:api');
Route::delete('/tasks/{taskId}', 'TaskController@delete')->middleware('auth:api');
Route::get('/group/{groupId}/tasks', 'TaskController@getTasksFromGroup')->middleware('auth:api');

//Task Member
Route::delete('/task_member', 'TasksMemberController@removeMember')->middleware('auth:api');
Route::post('/task_member', 'TasksMemberController@addMember')->middleware('auth:api');

//Group
Route::post('/group', 'GroupController@store')->middleware('auth:api');
Route::get('/group/{groupId}', 'GroupController@show')->middleware('auth:api');
Route::put('/group', 'GroupController@update')->middleware('auth:api');
Route::delete('/group', 'GroupController@delete')->middleware('auth:api');

//GroupMember
Route::post('/group_member', 'GroupMemberController@store')->middleware('auth:api');
Route::get('/group_member/{groupId}', 'GroupMemberController@show')->middleware('auth:api');
Route::put('/group_member/{groupId}/{userId}', 'GroupMemberController@update')->middleware('auth:api');
Route::delete('/group_member/{groupId}/{userId}', 'GroupMemberController@delete')->middleware('auth:api');


// Route::group(['middleware' => 'auth:api'], function()
// {
//     Route::resource('tasks','TaskController', ['except' => ['index', 'edit', 'create']]);
// });