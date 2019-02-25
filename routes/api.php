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
Route::get('/user/email/{email}', 'UserController@getUserByEmail'); //Bisa //Ambil user dengan param email


//Task
Route::post('/tasks', 'TasksController@store'); //Bisa Menambah task
Route::get('/tasks/{taskId}', 'TasksController@show');
Route::put('/tasks/{taskId}', 'TasksController@update');
Route::delete('/tasks/{taskId}', 'TasksController@destroy'); //Bisa //Hapus Task

Route::put('/task/move/{taskId}', 'TasksController@moveTask'); 

//Task Member
Route::delete('/task_member', 'TasksMemberController@removeMember'); //Bisa //delete member di task
Route::post('/task_member', 'TasksMemberController@addMember'); //Bisa //Tambah member task

//Get Group Task
Route::get('/group/{groupId}/tasks', 'TasksController@getTasksFromGroupId'); //Bisa , ambil tasks dari suatu group

//Group
Route::post('/group', 'GroupsController@store'); //Bisa //Bikin Group 
Route::get('/group/{groupId}', 'GroupsController@show'); // Bisa , ambil detail group
Route::put('/group/{groupId}', 'GroupsController@update');
Route::delete('/group/{groupId}', 'GroupsController@delete');

//GroupMember
Route::post('/group/member', 'GroupsMemberController@store'); //Bisa nambah Group Member
Route::get('/group/{groupId}/members', 'GroupsMemberController@show'); //Bisa ambil seluruh member dari suatu group
Route::put('/group/{groupId}/member/{userId}', 'GroupsMemberController@update');
Route::delete('/group/{groupId}/member/{userId}', 'GroupsMemberController@delete');

//Get History Group
Route::get('/group/{groupId}/history', 'GroupHistoryController@getHistory'); //Bisa ambil seluruh member dari suatu group

//Event
Route::post('/group/events', 'EventsController@store');
Route::get('/group/{groupId}/events', 'EventsController@show');
Route::delete('/group/{groupId}/events', 'EventsController@destroy');


Route::post('/user/{userId}/task/{taskId}/comment', 'CommentController@createCommentInTaskId');
Route::get('/task/{taskId}/comment', 'CommentController@getCommentsFromTaskId');

// Route::group(['middleware' => 'auth:api'], function()
// {
//     Route::resource('tasks','TasksController', ['except' => ['index', 'edit', 'create']]);
// });