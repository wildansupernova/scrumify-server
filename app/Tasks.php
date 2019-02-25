<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GroupHistory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
class Tasks extends Model
{

    protected $fillable = [
        'group_id', 'task_name',
        'description', 'kanban_status', 'work_hour'
    ];

    public function groups()
    {
        return $this->belongsTo('App\Groups', 'group_id');
    }
    
    public function pic() {
        return $this->hasOne('App\TasksMember', 'task_id');
    }


    public static function boot() {
        parent::boot();
        static::created(function (Tasks $item) {
            if ($item->kanban_status !== Config::get('constants.KANBAN_STATUS.PRODUCT_BACKLOG') && $item->kanban_status !== Config::get('constants.KANBAN_STATUS.DONE')) {
                $groupHistory = GroupHistory::where([
                    'group_id' => $item->group_id,
                    'tanggal' => date("Y-m-d")
                ])->first();
                if (is_null($groupHistory)) {
                    $groupWorkHour = DB::table('tasks')
                    ->select('group_id', DB::raw('SUM(work_hour) as total_work_hour'))
                    ->where([
                        ['group_id' , '=', $item->group_id],
                        ['kanban_status', '<>', Config::get('constants.KANBAN_STATUS.PRODUCT_BACKLOG')],
                        ['kanban_status', '<>', Config::get('constants.KANBAN_STATUS.DONE')]
                    ])
                    ->groupBy('group_id')->get()->first();
                    $score_sisa = 0;
                    if (!is_null($groupWorkHour)) {
                        $score_sisa = $groupWorkHour->total_work_hour;
                    }
                    $score_sisa = $score_sisa < 0 ? 0 : $score_sisa;
                    GroupHistory::create([
                        'group_id' => $item->group_id,
                        'tanggal' => date("Y-m-d"),
                        'score_sisa' => $score_sisa 
                    ]);
                } else {
                    $score_sisa = $groupHistory->score_sisa + $item->work_hour;
                    $score_sisa = $score_sisa < 0 ? 0 : $score_sisa;
                    $groupHistory->score_sisa = $score_sisa;
                    $groupHistory->save();
                }
            }
        });
        static::updating(function (Tasks $item) {
            $taskNow = Tasks::where([
                'id' => $item->id
            ])->first();
            if ( !is_null($taskNow) && $taskNow->kanban_status != Config::get('constants.KANBAN_STATUS.DONE') && $item->kanban_status == Config::get('constants.KANBAN_STATUS.DONE')) {
                $groupHistory = GroupHistory::where([
                    'group_id' => $item->group_id,
                    'tanggal' => '2019-03-24'
                ])->first();
                if (is_null($groupHistory)) {
                    $groupWorkHour = DB::table('tasks')
                    ->select('group_id', DB::raw('SUM(work_hour) as total_work_hour'))
                    ->where([
                        ['group_id' , '=', $item->group_id],
                        ['kanban_status', '<>', Config::get('constants.KANBAN_STATUS.PRODUCT_BACKLOG')],
                        ['kanban_status', '<>', Config::get('constants.KANBAN_STATUS.DONE')]
                    ])
                    ->groupBy('group_id')->get()->first();
                    $score_sisa = 0;
                    if (!is_null($groupWorkHour)) {
                        $score_sisa = $groupWorkHour->total_work_hour - $item->work_hour;
                    }
                    $score_sisa = $score_sisa < 0 ? 0 : $score_sisa;
                    GroupHistory::create([
                        'group_id' => $item->group_id,
                        'tanggal' => '2019-03-24',
                        'score_sisa' => $score_sisa
                    ]);
                } else {
                    $score_sisa = $groupHistory->score_sisa - $item->work_hour;
                    $score_sisa = $score_sisa < 0 ? 0 : $score_sisa;
                    $groupHistory->score_sisa = $score_sisa;
                    $groupHistory->save();
                }
            }
        });
    }

    // public function loggingInsertHistory(Tasks $item){
        
    // }


    public function comments()
    {
        return $this->hasMany('App\Comment', 'task_id');
    }

    public function getCommentsAttribute()
    {
        $comments = $this->comments()->getQuery()->orderBy('created_at', 'desc')->get();
        return $comments;
    }
}
