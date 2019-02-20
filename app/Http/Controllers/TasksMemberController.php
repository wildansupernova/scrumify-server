<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TasksMember;
class TasksMemberController extends Controller
{
    public function add(Request $req) {
        $user = $request->user();
        $result = $request->has([
            'task_id',
            'user_id'
        ]);
        if ($result) {
            $memberTask = TasksMember::create([
                'task_id' => $req->task_id,
                'user_id' => $req->user_id
            ]);
            return response(json_encode([
                'data' => $memberTask->toArray(),
                'msg' => ['success']
            ]), 200);
        } else {
            return response(json_encode([
                'err' => ['Bad Request']
            ]), 400);
        }
    }
}
