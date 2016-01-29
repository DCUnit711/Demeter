<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vm extends Model
{
    public function instances()
    {
	return $this->hasMany('App\instance', 'vmId');
    }

}
