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
	   //create a new instance (db). expects name, type, ownerId, organization, maxSize, and description  
        $i = new instance();
    	$i->id = \Uuid::generate(4);
    	$i->name = $request->input('name');
    	$i->type =  $request->input('type');
    	$i->ownerId =  $request->input('ownerId');
    	$i->organization =  $request->input('organization');
        $i->maxSize = $request->input('maxSize');
    	$i->description = $request->input('description');
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
            die('fail - not authenticated');
        }
        echo 'here';
        echo $request['name'];
        echo "------------------DONE----------------";
	if($request->has('name') && $request->has('ownerId') && $request->has('organization') && $request->has('maxSize') && $request->has('description'))
	{
	        $i = instance::find($id);
		    $i->name = $request->input('name');
	        $i->ownerId =  $request->input('ownerId');
        	$i->organization =  $request->input('organization');
	        $d->maxSize = $request->input('maxSize');
        	$d->description = $request->input('description');
	        $i->inUse = true;

        	if($i->save())
	            echo "success";
        	else
	            echo "fail - couldn't save";
	}
	else
		echo "fail - variable not set";
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
