<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class handleVmRequest extends Controller
{
    public function index(Request $request)
    {
    	$this->dispatchFrom('App\Jobs\handleVmRequest', $request);
    }

}
