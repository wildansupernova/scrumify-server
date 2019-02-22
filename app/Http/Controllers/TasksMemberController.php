<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TasksMember;
class TasksMemberController extends Controller
{
    public function addMember(Request $request) {
        $result = $request->has([
            'task_id',
            'user_id'
        ]);
        if ($result) {
            $memberTask = TasksMember::where([
                'task_id' => $request->task_id,
                'user_id' => $request->user_id
            ])->first();
            if (is_null($memberTask)) {
                $memberTask = TasksMember::create([
                    'task_id' => $request->task_id,
                    'user_id' => $request->user_id
                ]);
            }
            return response(json_encode([
                'data' => $memberTask->toArray(),
                'statusMessage'=> 'success',
            ]), 200);
        } else {
            return response(json_encode([
                'data' => NULL,
                'statusMessage'=> 'error',
            ]), 400);
        }
    }


    public function removeMember(Request $request) {
        $result = $request->has([
            'task_id',
            'user_id'
        ]);
        if ($result) {
            $memberTask = TasksMember::where([
                'task_id' => $request->task_id,
                'user_id' => $request->user_id
            ])->first();
            if (!is_null($memberTask)) {
                $memberTask->delete();
            }
            return response(json_encode([
                'data' => NULL,
                'statusMessage'=> 'success',
            ]), 200);
        } else {
            return response(json_encode([
                'data' => NULL,
                'statusMessage'=> 'error',
            ]), 400);
        }
    }


}
