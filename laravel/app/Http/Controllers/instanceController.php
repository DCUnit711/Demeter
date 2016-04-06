<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\instance;
use App\instanceUser;
use App\vm;
use App\demeterUser;

class instanceController extends Controller
{
	public function __construct()
        {
                $this->middleware('logger');
        }

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
	//get user
	$user = demeterUser::where('netId', $_SESSION['AUTH_USER'])->first();
	//check if we need to make a user
	if(!$user)
	{
		$user = new demeterUser();
                $user->id = \Uuid::generate(4);
		$user->netId = $_SESSION['AUTH_USER'];
		$user->role = 'client';
		$user->save();
	}

	if($user->role == 'admin')
		$instances = instance::with('vm', 'owner', 'users', 'instanceUsers')->get();
	else
		$instances = $user->ownedInstances()->where('inUse', '!=', '-1')->with('vm', 'owner', 'users', 'instanceUsers')->get();
		$instances->merge($user->instances()->where('inUse', '!=', '-1')->with('vm', 'owner', 'users', 'instanceUsers')->get());
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
        if($data['name'] != null && $data['organization'] != null && $data['maxSize'] != null && $data['description'] != null && $data['type'] != null && $data['username'] != null && $data['password'] != null)
        {
		//check if instance exists with the same name
	//	if(instance::where('name', $data['name'])->exists())
	//		die("Database name in use");
		$user = demeterUser::where('netId', $_SESSION['AUTH_USER'])->first();
		
	   //create a new instance (db). expects name, type, ownerId, organization, maxSize, and description  
	        $i = new instance();
		$i->id = \Uuid::generate(4);
	    	$i->name = $data['name'];
    		$i->type =  $data['type'];
	    	$i->ownerId =  $user->id;
    		$i->organization =  $data['organization'];
	        $i->maxSize = $data['maxSize'];
    		$i->description = $data['description'];
	    	//determine the VM for this instance
    		$vms = vm::where("type", "LIKE", "%".$i->type."%")->get();
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
			try
			{
				//emit request to make db
				$redis = \Redis::connection(); // Using the Redis extension provided client
				$redis->publish('demeter', json_encode(array('command' => 'createInstance', 'vm' => $i->vmId, 'instanceId' => $i->id->string, 'name' => $i->name, 'type'=>$i->type, 'maxSize'=>$i->maxSize, 'username'=>$data['username'], 'password'=>$data['password'], 'netId'=>$_SESSION['AUTH_USER'])));
		    		$i->inUse = 0;
				$iu = new instanceUser();
                                $iu->id = \Uuid::generate(4);
                                $iu->name = $data['username'];
                                $iu->instanceId = $i->id->string;

    				$i->save();
				
				$iu->save();
                		echo "success";
		    	        
				//else
        		        //    echo "fail";
			}
			catch(Exception $e)
			{
				echo "fail";
			}
	    	}
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
            die('fail');
        }
	$put = file_get_contents('php://input');
	$data = json_decode($put, true);
	if($data['name'] != null && $data['ownerId'] != null && $data['organization'] != null && $data['maxSize'] != null && $data['description'] != null)
	{
		$i = instance::find($id);
		$oldName = $i->name;
		//check if instance exists with the same name
                if($oldName != $data['name'] && instance::where('name', $data['name'])->exists())
                        die("fail");

		$i->name = $data['name'];
	        $i->ownerId =  $data['ownerId'];
        	$i->organization =  $data['organization'];
	        $i->maxSize = $data['maxSize'];
        	$i->description = $data['description'];

		try
                {
                        //emit request to make db
                        $redis = \Redis::connection(); // Using the Redis extension provided client
			$redis->publish('demeter', json_encode(array('command' => 'updateInstance', 'instanceId' => $i->id, 'vm' => $i->vmId, 'oldName'=>$oldName, 'name' => $i->name, 'maxSize'=>$i->maxSize, 'netId'=>$_SESSION['AUTH_USER'])));	
	        	if($i->save())
		            echo "success";
        		else
		            echo "fail";
		}
		catch(Exception $e)
		{
			echo "fail";
		}
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
	try
        {
                $i = instance::find($id);
                //emit request to delete db
                $redis = \Redis::connection(); // Using the Redis extension provided client
		$redis->publish('demeter', json_encode(array('command' => 'deleteInstance', 'instanceId' => $i->id, 'vm' => $i->vmId, 'name' => $i->name, 'netId'=>$_SESSION['AUTH_USER'])));
		if($i->instanceUsers())
                	$i->instanceUsers()->delete();
		$i->inUse = -1;
        	if($i->save())
	            echo "success";
        	else
	            echo "fail";

	}
	catch(Exception $e)
	{
		echo "fail";
	}

    }
}
