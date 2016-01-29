<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class instanceUser extends Model
{
    public function instance()
    {
        return $this->belongsTo('App\instance', 'instanceId');
    }
}
