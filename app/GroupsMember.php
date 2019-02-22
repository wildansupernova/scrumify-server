<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * @property int $group_id
 * @property int $user_id
 * @property string $role
 * @property int $score
 * @property string $created_at
 * @property string $updated_at
 * @property Group $group
 * @property User $user
 */
class GroupsMember extends Model
{
    protected $table = 'groups_member';
    public $incrementing = false;
    protected $primaryKey = ['group_id', 'user_id'];
    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

    public function groups() {
        return $this->belongsTo('App\Groups', 'group_id');
    }

    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tasks() {
        return $this->hasMany('App\Tasks', 'id', 'task_id');
    }
}
