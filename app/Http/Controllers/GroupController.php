<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\GroupMember;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'group_name' => 'required',
            'description' => 'required',
            'user_id' => 'required',
        ]);
        $input = $request->all();

        
        DB::beginTransaction();

        $group = Group::create([
            'group_name' => $input['group_name'],
            'description' => $input['description'],
        ]);
        GroupMember::create([
            'group_id' => $group['id'],
            'user_id' => $input['user_id'],
            // 'role' => $input['role'],
            'high_score' => 0
        ]);

        DB::commit();

        
        return response(json_encode([
            'statusMessage' => 'success',
            'data' => NULL
        ]), 200);
    }

    public function show(Request $request, $groupId) {
        $isGroupExist = Group::find($groupId);

        if (is_null($isGroupExist)) {
            return response(json_encode([
                'statusMessage' => 'Not Found'
            ]), 404);
        } else {
            $group = $isGroupExist->toArray();

            return response(json_encode([
                'statusMessage' => 'Success',
                'data' => $group
            ]), 200);
        }
    }

    public function update(Request $request) {
        $validator = $this->validate2($request);

        if ($validator->fails()) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $input = $request->all();
            $isGroupExist = Group::find($input['group_id']);

            if (is_null($isGroupExist)) {
                return response(json_encode([
                    'statusMessage' => 'Bad Request'
                ]), 400);
            } else {
                $group = Group::create([
                    'group_name' => $input['group_name'],
                    'description' => $input['description']
                ]);
                $group->save();
    
                return response(json_encode([
                    'statusMessage' => 'Success',
                    'data' => $group->toArray()
                ]), 200);
            }
        }
    }

    public function destroy(Request $request, $groupId) {
        $group = Group::find($groupId);

        if (is_null($group)) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $group->delete;

            return response(json_encode([
                'statusMessage' => 'Success'
            ]), 200);
        }
    }

    public function validate2(Request $request) {
        $input = $request->all();
        return Validator::make($input, [
            'group_name' => 'required'
        ]);
    }

    public function tasks() {
        $this->hasMany('App\Task', 'group_id');
    }
}