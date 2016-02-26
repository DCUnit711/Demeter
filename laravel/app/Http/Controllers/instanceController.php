<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\instance;
use App\vm;

class instanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        if(!isset($_SESSION['AUTH']) || $_SESSION['AUTH'] == false) {   
            die("fail");
        }  
        $instances = instance::with('vm', 'owner', 'users', 'instanceUsers')->get();
	    return response()->json($instances);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        if($data['name'] != null && $data['ownerId'] != null && $data['organization'] != null && $data['maxSize'] != null && $data['description'] != null && $data['type'] != null)
        {

	   //create a new instance (db). expects name, type, ownerId, organization, maxSize, and description  
	        $i = new instance();
    		$i->id = \Uuid::generate(4);
	    	$i->name = $data['name'];
    		$i->type =  $data['type'];
	    	$i->ownerId =  $data['ownerId'];
    		$i->organization =  $data['organization'];
	        $i->maxSize = $data['maxSize'];
    		$i->description = $data['description'];
	    	//determine the VM for this instance
    		$vms = vm::where("type", "LIKE", "%"+ $i->type +"%")->get();
	    	foreach ($vms as $vm)
    		{
    			if ($i->maxSize == $i->maxSize) //check if vm has space
	    		{
     			        $i->vmId =  $vm->id;
    				break;
	    		}
    		}
	    	if (!isset($i->vmId))
    		{
	    		echo "No VM available";
    		}
	    	else
    		{
	    		$i->inUse = true;
    			if($i->save())
                	    echo "success";
	    	        else
        	            echo "fail";
	    	}
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
        $i = instance::find($id)->with('vm', 'owner', 'users', 'instanceUsers')->get();
        return response()->json($i);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session_start();
        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
            die('fail');
        }
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
	if($data['name'] != null && $data['ownerId'] != null && $data['organization'] != null && $data['maxSize'] != null && $data['description'] != null)
	{
	        $i = instance::find($id);
		    $i->name = $data['name'];
	        $i->ownerId =  $data['ownerId'];
        	$i->organization =  $data['organization'];
	        $i->maxSize = $data['maxSize'];
        	$i->description = $data['description'];
	        $i->inUse = true;

        	if($i->save())
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
        $i = instance::find($id);
        if($i->delete())
            echo "success";
        else
            echo "fail";

    }
}
