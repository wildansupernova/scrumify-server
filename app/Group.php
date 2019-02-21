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
class Group extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $fillable = ['group_name', 'description', 'created_at', 'updated_at'];
    public $timestamps = true;
}