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
Route::get('/wildan', 'UserController@testMasukAuthAPI');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', 'UserController@generateToken');
Route::post('/logout', 'UserController@logOut');


//Task
Route::post('/tasks', 'TaskController@store');
Route::get('/tasks/{taskId}', 'TaskController@show');
Route::put('/tasks/{taskId}', 'TaskController@update');
Route::delete('/tasks/{taskId}', 'TaskController@delete');

//Task Member
Route::delete('/task_member', 'TasksMemberController@removeMember');
Route::post('/task_member', 'TasksMemberController@addMember');
Route::get('/group/{groupId}/tasks', 'TaskController@getTasksFromGroup');

//Group
Route::post('/group', 'GroupController@store');
Route::get('/group/{groupId}', 'GroupController@show');
Route::put('/group', 'GroupController@update');
Route::delete('/group', 'GroupController@delete');

//GroupMember
Route::post('/group_member', 'GroupMemberController@store');
Route::get('/group_member/{groupId}', 'GroupMemberController@show');
Route::put('/group_member/{groupId}/{userId}', 'GroupMemberController@update');
Route::delete('/group_member/{groupId}/{userId}', 'GroupMemberController@delete');


// Route::group(['middleware' => 'auth:api'], function()
// {
//     Route::resource('tasks','TaskController', ['except' => ['index', 'edit', 'create']]);
// });