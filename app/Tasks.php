<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
