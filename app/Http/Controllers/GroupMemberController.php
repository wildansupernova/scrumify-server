<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\GroupMember;
use App\User;
use Validator;
use Illuminate\Support\Facades\DB;

class GroupMemberController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'email' => 'required'
        ]);;

        if ($validator->fails()) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $input = $request->all();
            $user = User::where('email', $input['email'])->first();
            if (is_null($user)) {
                return response(json_encode([
                    'statusMessage' => 'error',
                    'data' => NULL
                ]), 404);
            } 
            $groupMember = GroupMember::where([
                'user_id' => $user->id,
                'group_id' => $input['group_id']
            ])->first();


            $group = Group::find($input['group_id']);

            if (is_null($group)) {
                return response(json_encode([
                    'statusMessage' => 'Bad Request'
                ]), 400);
            } else {
                if (is_null($groupMember)) {
                    $groupMember = GroupMember::create([
                        'group_id' => $input['group_id'],
                        'user_id' => $user->id,
                        // 'role' => $input['role'],
                        'high_score' => 0
                    ]);
                }
                return response(json_encode([
                    'statusMessage' => 'success',
                    'data' => $groupMember->toArray()
                ]), 200);
            }
        }
    }

    public function show($groupId) {
        $group = Group::find($groupId);

        if (!is_null($group)) {
            $users = DB::table('group_member')->select('user_id','high_score','groups.created_at','groups.updated_at','group_id', 'group_name','description')->join('groups','group_member.group_id','=','groups.id')->where('group_id',$groupId)->get();
            return response(json_encode([
                'statusMessage' => 'success',
                'data' => $users->toArray()
            ]), 200);
        } else {
            return response(json_encode([
                'statusMessage' => 'error',
                'data' => null
            ]), 404);
        }
    }

    public function update(Request $request, $groupId, $userId) {
        $validator = $this->validate2($request);

        if ($validator->fails()) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $input = $request->all();
            $groupMember = GroupMember::create([
                'role' => $input['role'],
                'high_score' => $input['high_score']
            ]);

            $member = GroupMember::find($groupId)->find($userId);
            if ($member) {
                $member->fill($groupMember);
                $member->save();

                return response(json_encode([
                    'statusMessage' => 'Success',
                    'data' => $member->toArray()
                ]), 200);
            } else {
                return response(json_encode([
                    'statusMessage' => 'Not Found'
                ]), 404);
            }
        }
    }

    public function destroy(Request $request, $groupId, $userId) {        
        $groupMember = GroupMember::find($groupId);

        if (is_null($groupDetails)) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $groupMember->delete();

            return response(json_encode([
                'statusMessage' => 'Success'
            ]), 200);
        }
    }

    private function validate2(Request $request) {
        $input = $request->all();
        return Validator::make($input, [
            'role' => 'required',
            'high_score' => 'required'
        ]);
    }
}