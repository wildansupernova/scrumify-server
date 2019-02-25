<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'group_id' => 'required',
            'time' => 'required'
        ]);
        $input = $request->all();

        DB::beginTransaction();

        $event = Events::create([
            'group_id' => $input['group_id'],
            'time' => $input['time'],
        ]);

        DB::commit();

        return response(json_encode([
            'statusMessage' => 'success',
            'data' => $event->toArray()
        ]), 200);
    }

    public function show(Request $request, $groupId) {
        $isGroupExist = Events::find($groupId);

        if (is_null($isGroupExist)) {
            return response(json_encode([
                'statusMessage' => 'Not Found'
            ]), 404);
        } else {
            $events = $isGroupExist->toArray();

            return response(json_encode([
                'statusMessage' => 'Success',
                'data' => $events
            ]), 200);
        }
    }

    public function destroy(Request $request, $groupId) {
        $event = Events::find($groupId);

        if (is_null($group)) {
            return response(json_encode([
                'statusMessage' => 'Bad Request'
            ]), 400);
        } else {
            $event->delete;

            return response(json_encode([
                'statusMessage' => 'Success'
            ]), 200);
        }
    }
}