<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'group_id', 'taskname',
        'description', 'status_kanban'
    ];
    //
    public function members() {
        return $this->hasMany('App\TasksMember', 'task_id');
    }
}
