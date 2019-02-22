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


//User
Route::get('/user/{userId}/groups', 'UserController@getGroups'); //Bisa //Ambil Group yang dipunyai user


//Task
Route::post('/tasks', 'TaskController@store'); //Bisa Menambah task
Route::get('/tasks/{taskId}', 'TaskController@show');
Route::put('/tasks/{taskId}', 'TaskController@update');
Route::delete('/tasks/{taskId}', 'TaskController@destroy'); //Bisa //Hapus Task

//Task Member
Route::delete('/task_member', 'TasksMemberController@removeMember'); //Bisa //delete member di task
Route::post('/task_member', 'TasksMemberController@addMember'); //Bisa //Tambah member task

//Get Group Task
Route::get('/group/{groupId}/tasks', 'TaskController@getTasksFromGroupId'); //Bisa , ambil tasks dari suatu group

//Group
Route::post('/group', 'GroupController@store'); //Bisa //Bikin Group 
Route::get('/group/{groupId}', 'GroupController@show'); // Bisa , ambil detail group
Route::put('/group', 'GroupController@update');
Route::delete('/group', 'GroupController@delete');

//GroupMember
Route::post('/group_member', 'GroupMemberController@store'); //Bisa //Nambah Group Member
Route::get('/group_member/group/{groupId}', 'GroupMemberController@show'); //Bisa //Ambil member dari suatu group
Route::put('/group_member/{groupId}/{userId}', 'GroupMemberController@update');
Route::delete('/group_member/{groupId}/{userId}', 'GroupMemberController@delete');


// Route::group(['middleware' => 'auth:api'], function()
// {
//     Route::resource('tasks','TaskController', ['except' => ['index', 'edit', 'create']]);
// });