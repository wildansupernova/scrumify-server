<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tasks;
use App\Comment;
class CommentController extends Controller
{
    //

    public function getCommentsFromTaskId($taskId) {
        $task = Tasks::where('id', $taskId)->first();
        if (is_null($task)) {
            return response(json_encode([
                'statusMessage' => 'error'
            ]), 404);
        } else {
            $comments = $task->getCommentsAttribute();
            return response(json_encode([
                'data' => $comments->toArray(),
                'statusMessage' => 'success'
            ]), 200);
        }
    }

    public function createCommentInTaskId(Request $request, $userId, $taskId) {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'task_id' => $taskId,
            'user_id' => $userId          
        ]);

        return response(json_encode([
            'data' => NULL,
            'statusMessage' => 'success'
        ]), 200);
    }
}
