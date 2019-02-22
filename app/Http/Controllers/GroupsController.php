<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groups;
use App\GroupsMember;
use Illuminate\Support\Facades\DB;

class GroupsController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'group_name' => 'required',
            'description' => 'required',
            'user_id' => 'required',
        ]);
        $input = $request->all();

        
        DB::beginTransaction();

        $group = Groups::create([
            'group_name' => $input['group_name'],
            'description' => $input['description'],
        ]);
        GroupsMember::create([
            'group_id' => $group['id'],
            'user_id' => $input['user_id'],
            'role' => $input['role'],
            'high_score' => 0
        ]);

        DB::commit();

        return response(json_encode([
            'statusMessage' => 'success',
            'data' => NULL
        ]), 200);
    }

    public function show(Request $request, $groupId) {
        $isGroupExist = Groups::find($groupId);

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

    public function update(Request $request, $groupId) {
        $validator = $this->validate2($request);

        if ($validator->fails()) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $isGroupExist = Groups::find($groupId);

            if (is_null($isGroupExist)) {
                return response(json_encode([
                    'statusMessage' => 'Bad Request'
                ]), 400);
            } else {
                $input = $request->all();
                $group = Groups::create([
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
        $group = Groups::find($groupId);

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
        return $this->hasMany('App\Task', 'group_id');
    }
}