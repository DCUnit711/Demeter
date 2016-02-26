<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\demeterUser;

class demeterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
            die('fail');
        }
        $users =  demeterUser::with('instances', 'ownedInstances')->get();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        session_start();
        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
            die('fail');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session_start();
        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
            die('fail');
        }
	$post = file_get_contents('php://input');
        $data = json_decode($post, true);
        if($data['netId'] != null && $data['email'] != null && $data['roll'] != null)
	{
	   //Creates a new demeterUser. Expects netId, email, and role ('admin' or 'client')
	        $u = new demeterUser();
    		$u->id = \Uuid::generate(4);
	    	$u->netId = $data['netId'];
    		$u->email = $data['email'];
	    	$u->role = $data['role'];
    		if($u->save())
	    	    echo "success";
    		else
	    	    echo "fail";
        }
	else
		echo "fail";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        session_start();
        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
            die('fail');
        }
        $u = demeterUser::find($id)->with('instances', 'ownedInstances')->first();
        print json_encode($u);
        //return response()->json($u);	
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        session_start();
        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
            die('fail');
        }
	$put = file_get_contents('php://input');
        $data = json_decode($put, true);
        if($data['netId'] != null && $data['email'] != null && $data['role'] != null)
	{
        	$u = demeterUser::find($id);
	    	$u->netId = $data['netId'];
    		$u->email = $data['email'];
	    	$u->role = $data['role'];
    		if($u->save())
	    	    echo "success";
    		else
	    	    echo "fail";
	}
	else
		echo "fail";
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        session_start();
        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
            die('fail');
        }
        $u = demeterUser::find($id);
    	if($u->delete())
    	    echo "success";
    	else
    	    echo "fail";
        }
}
