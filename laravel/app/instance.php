<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class instance extends Model
{

    public function vm()
    {
	return $this->belongsTo('App\vm', 'vmId');
    }

    public function owner()
    {
        return $this->belongsTo('App\demeterUser', 'ownerId');
    }

    public function instanceUsers()
    {
	 return $this->hasMany('App\instanceUser', 'instanceId');
    }

    public function users()
    {
	return $this->belongsToMany('App\demeterUser', 'demeter_user_instance', 'instance_id', 'demeter_user_id');
    }

}
