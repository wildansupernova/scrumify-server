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
Route::post('/tasks', 'TasksController@store');
Route::get('/tasks/{taskId}', 'TasksController@show');
Route::put('/tasks/{taskId}', 'TasksController@update');
Route::delete('/tasks/{taskId}', 'TasksController@delete');

//Task Member
Route::delete('/task_member', 'TasksMemberController@removeMember');
Route::post('/task_member', 'TasksMemberController@addMember');

//Get Group Task
Route::get('/group/{groupId}/tasks', 'TasksController@getTasksFromGroup');

//Group
Route::post('/group', 'GroupsController@store');
Route::get('/group/{groupId}', 'GroupsController@show');
Route::put('/group/{groupId}', 'GroupsController@update');
Route::delete('/group/{groupId}', 'GroupsController@delete');

//GroupMember
Route::post('/group/member', 'GroupsMemberController@store');
Route::get('/group/{groupId}/member', 'GroupsMemberController@show');
Route::get('/group/{groupId}/members', 'GroupsMemberController@showAll');
Route::put('/group/{groupId}/member/{userId}', 'GroupsMemberController@update');
Route::delete('/group/{groupId}/member/{userId}', 'GroupsMemberController@delete');


// Route::group(['middleware' => 'auth:api'], function()
// {
//     Route::resource('tasks','TaskController', ['except' => ['index', 'edit', 'create']]);
// });