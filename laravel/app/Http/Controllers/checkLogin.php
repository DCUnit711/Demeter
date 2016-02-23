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
        echo isset($_SESSION);
    	if (isset($_SESSION) && $_SESSION['AUTH'] == true)
    		echo "true";
    	else
    		echo "false";
    }
}
