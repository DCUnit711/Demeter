<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class demeterUser extends Model
{

	public function ownedInstances()
	{
		return $this->hasMany('App\instance', 'ownerId');
	}

	public function instances()
	{
		return $this->belongsToMany('App\instance');
	}
}
