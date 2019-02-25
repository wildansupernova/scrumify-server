<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = ['group_id', 'time'];
    public $timestamps = true;
}