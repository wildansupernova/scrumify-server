<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GroupHistoryController extends Controller
{
    //
    public function getHistory($groupId) {
        $history = DB::table('group_history')
        ->select('score_sisa','tanggal')
        ->where([
            'group_id' => $groupId
        ])
        ->orderBy('tanggal', 'asc')
        ->get();

        return response(json_encode([
            'data' => $history->toArray(),
            'statusMessage' => 'success'
        ]), 200);
    }
}
