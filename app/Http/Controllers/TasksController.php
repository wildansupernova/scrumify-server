<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tasks;
use App\Groups;
use App\TasksMember;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_encode;
class TasksController extends Controller
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
            'task_name',
            'description',
            'kanban_status'
        ]);
        if ($result) {
            $form = [
                'group_id' => $request->group_id,
                'task_name' => $request->task_name,
                'description' => $request->description,
                'kanban_status' => $request->kanban_status
            ];
            $task = Tasks::create($form);
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
        
        $task = Tasks::find($taskId)->first();

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
            'task_name',
            'description',
            'kanban_status',
            'work_hour'
        ]);
        if ($result) {
            $form = [
                'task_name' => $request->task_name,
                'description' => $request->description,
                'kanban_status' => $request->kanban_status,
                'work_hour' => $request->work_hour
            ];
            $task = Tasks::find($taskId)->first();
            if ($task) {
                $task->fill($form);
                $task->save();
                return response(json_encode([
                    'data' => $task->toArray(),
                    'statusMessage'=> "success",
                ]), 200);
            } else {
                return response(json_encode([
                    'data' => NULL,
                    'statusMessage'=> "error",
                ]), 404);
            }
        } else {
            return response(json_encode([
                'data' => NULL,
                'statusMessage'=> 'error',
            ]), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $taskId)
    {
        Tasks::destroy($taskId);
        return response(json_encode([
            'data' => NULL,
            'statusMessage'=> 'success',
        ]), 200);
    }

    public function getTasksFromGroupId(Request $req, $groupId) {
        if ($req->has(['kanban_status'])) {
            $idTaskMember = TasksMember::all();
            $idTaskMemberArr = array();
            foreach($idTaskMember as $element){
                array_push($idTaskMemberArr,$element['task_id']);
            }
            // echo(json_encode($idTaskMemberArr));
            $taskNotIn = DB::table('tasks')
            ->select('tasks.id','tasks.group_id','task_name','description', 'kanban_status', 'work_hour','tasks.created_at','tasks.updated_at', DB::raw('"-" as assignee'))
            ->where([
                'kanban_status' => $req->kanban_status,
                'tasks.group_id'=> $groupId,
            ])->whereNotIn('id', $idTaskMemberArr);

            $tasksWithName = DB::table('tasks')
            ->select('tasks.id','tasks.group_id','task_name','description', 'kanban_status', 'work_hour','tasks.created_at','tasks.updated_at','users.name as assignee')
            ->join('tasks_member','tasks.id','=','task_id')
            ->join('users','users.id','=','tasks_member.user_id')->where([
                'kanban_status' => $req->kanban_status,
                'tasks.group_id'=> $groupId,
            ])->union($taskNotIn)->get();
            return response(json_encode([
                'data' => $tasksWithName->toArray(),
                'statusMessage' => 'success'
            ]), 200); 
        } else {
            $tasks = DB::table('tasks')
            ->select('users.id','tasks.group_id','task_name','description', 'kanban_status', 'work_hour','tasks.created_at','tasks.updated_at','users.name')
            ->join('tasks_member','tasks.id','=','task_id')
            ->join('users','users.id','=','tasks_member.user_id')->get();            
            return response(json_encode([
                'data' => $tasks->toArray(),
                'statusMessage' => 'success'
            ]), 200);
        }
    }
}
