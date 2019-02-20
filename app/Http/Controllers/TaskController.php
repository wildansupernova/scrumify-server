<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\TasksMember;
class TaskController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();
        $result = $request->has([
            'group_id',
            'taskname',
            'description'
        ]);
        if ($result) {
            $form = [
                'group_id' => $request->group_id,
                'taskname' => $request->taskname,
                'description' => $request->description,
                'status_kanban' => Config::get('constants.STATUS_KANBAN.PRODUCT_BACKLOG')
            ];
            $task = Task::create($form);
            return response(json_encode([
                'data' => $task->toArray(),
                'msg' => ['Success']
            ]), 200);
        } else {
            return response(json_encode([
                'err' => ['Bad Request']
            ]), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $taskId)
    {
        //
        $user = $request->user();
        
        $task = Task::find($taskId)->first();

        if ($task) {
            $taskArr = $task->toArray();
            $taskArr['members'] = $task->toArray();
            return response(json_encode([
                'data' => $taskArr,
                'msg' => ['success']
            ]), 200);
        } else {
            return response(json_encode([
                'err' => ['Not Found']
            ]), 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $taskId)
    {
        $user = $request->user();
        $result = $request->has([
            'taskname',
            'description',
            'status_kanban'
        ]);
        if ($result) {
            $form = [
                'taskname' => $request->taskname,
                'description' => $request->description,
                'status_kanban' => $request->status_kanban
            ];
            $task = Task::find($taskId)->first();
            if ($task) {
                $task->fill($form);
                $task->save();
                return response(json_encode([
                    'data' => $task->toArray(),
                    'msg' => ['Success']
                ]), 200);
            } else {
                return response(json_encode([
                    'err' => ['Not Found']
                ]), 404);
            }
        } else {
            return response(json_encode([
                'err' => ['Bad Request']
            ]), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskId)
    {
        Task::destroy($taskId);
        return response(json_encode([
            'msg' => ['deleted']
        ]), 200);
    }
}
