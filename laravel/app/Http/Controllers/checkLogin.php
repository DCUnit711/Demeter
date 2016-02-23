<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class checkLogin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "SESSION = ".isset($_SESSION);
	echo "SESSION_HAS".Session::has('AUTH');
	echo Session::get('AUTH');
    	if (Session::has('AUTH') && Session::get('Auth') == true)
    		echo "true";
    	else
    		echo "false";
    }
}
