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
	var_dump($_SESSION);
        echo "SESSION = ".isset($_SESSION);
	echo "SESSION_HAS".$r->session()->has('AUTH');
	echo $r->session()->get('AUTH');
    	if ($r->session()->has('AUTH') && $r->session()->get('Auth') == true)
    		echo "true";
    	else
    		echo "false";
    }
}
