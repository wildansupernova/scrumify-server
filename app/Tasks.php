<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{

    protected $fillable = [
        'group_id', 'taskname',
        'description', 'status_kanban'
    ];

    public function groups()
    {
        return $this->belongsTo('App\Groups', 'group_id');
    }
    
    public function pic() {
        return $this->hasOne('App\TasksMember', 'task_id');
    }
}
