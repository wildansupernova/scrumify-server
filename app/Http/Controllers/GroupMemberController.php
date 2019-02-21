<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\GroupMember;
use Validator;

class GroupMemberController extends Controller
{
    public function store(Request $request) {
        $validator = $this->validate($request);

        if ($validator->fails()) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $input = $request->all();
            $isGroupMemberExist = GroupMember::find($input['group_id'])::find($input['user_id']);
            $groupMember = GroupMember::create([
                'group_id' => $input['group_id'],
                'user_id' => $input['user_id'],
                'role' => $input['role'],
                'high_score' => $input['high_score']
            ]);

            $group = Group::find($groupId);

            if (is_null($group)) {
                return response(json_encode([
                    'statusMessage' => 'Bad Request'
                ]), 400);
            } else {
                $groupMember->save();

                return response(json_encode([
                    'statusMessage' => ['Success'],
                    'data' => $groupMember->toArray()
                ]), 200);
            }
        }
    }

    public function show(Request $request, $groupId) {
        $isGroupMemberExist = GroupMember::find($groupId);

        if (is_null($groupMember)) {
            return response(json_decode([
                'statusMessage' => 'Not Found'
            ]), 404);
        } else {
            $member = $group->toArray();

            return response(json_encode([
                'statusMessage' => 'Success',
                'data' => $member
            ]), 200);
        }
    }

    public function update(Request $request, $groupId, $userId) {
        $validator = $this->validate($request);

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

    private function validate(Request $request) {
        $input = $request->all();
        return Validator::make($input, [
            'role' => 'required',
            'high_score' => 'required'
        ]);
    }
}