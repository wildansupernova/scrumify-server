<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $group_name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Groups extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $fillable = ['group_name', 'description'];
    public $timestamps = true;

    public function members()
    {
        return $this->hasMany('App\GroupsMember', 'group_id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Tasks', 'group_id');
    }
}