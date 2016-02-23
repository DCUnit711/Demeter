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
    public function index(Request $r)
    {
	    session_start();
        echo " SESSION = ".isset($_SESSION);
	    echo " SESSION_HAS = ".$_SESSION['AUTH'];
	    //echo " GET AUTH = "$r->session()->get('AUTH');
    	if ($_SESSION['AUTH'] == true)
    		echo "true";
    	else
    		echo "false";
    }
}
