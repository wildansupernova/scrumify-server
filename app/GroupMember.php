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
class GroupMember extends Model
{
    protected $table = 'group_member';
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

    public function group() {
        return $this->belongsTo('App\Group', 'group_id', 'group_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
