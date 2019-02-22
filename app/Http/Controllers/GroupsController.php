<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groups;

class GroupsController extends Controller
{
    public function store(Request $request) {
        $validator = $this->validate($request);

        if ($validator->fails()) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $input = $request->all();
            $isGroupExist = Groups::find($input['group_id']);

            if (is_null($isGroupExist)) {
                $group = Groups::create([
                    'group_id' => $input['group_id'],
                    'group_name' => $input['group_name'],
                    'description' => $input['description']
                ]);
                $group->save();
                
                return response(json_encode([
                    'statusMessage' => 'Success',
                    'data' => $group->toArray()
                ]), 200);
            } else {
                return response(json_encode([
                    'statusMessage' => 'Bad Request'
                ]), 400);
            }
        }
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

    public function update(Request $request) {
        $validator = $this->validate($request);

        if ($validator->fails()) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $input = $request->all();
            $isGroupExist = Groups::find($input['group_id']);

            if (is_null($isGroupExist)) {
                return response(json_encode([
                    'statusMessage' => 'Bad Request'
                ]), 400);
            } else {
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

    private function validate(Request $request) {
        $input = $request->all();
        return Validator::make($input, [
            'group_name' => 'required'
        ]);
    }

    public function tasks() {
        $this->hasMany('App\Task', 'group_id');
    }
}