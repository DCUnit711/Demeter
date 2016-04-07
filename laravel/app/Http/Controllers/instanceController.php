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
	    \App::abort(500, 'User not authenticated');
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

	foreach ($instances as $i)
	{
		$i->ownerName = demeterUser::find($i->ownerId)->netId;
	}
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
		\App::abort(500, 'User not authenticated');

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
                \App::abort(500, 'User not authenticated');

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
		/////FOR DEMO
		if($data['name'] == 'map')
		{
			$i->port = 3306;
			$i->ipAddr = "53.0.0.0";
		}
		////END

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
				$redis->publish('demeter', json_encode(array('command' => 'createInstance', 'vm' => $i->vmId, 'instanceId' => $i->id->string, 'instanceName' => $i->name, 'type'=>$i->type, 'maxSize'=>$i->maxSize, 'username'=>$data['username'], 'password'=>$data['password'], 'netId'=>$_SESSION['AUTH_USER'])));
		    		$i->inUse = 0;
				$iu = new instanceUser();
                                $iu->id = \Uuid::generate(4);
                                $iu->name = $data['username'];
                                $iu->instanceId = $i->id->string;

    				$i->save();
				
				$iu->save();
				$i->users()->save($user);
                		echo "success";
		    	        
				//else
        		        //    echo "fail";
			}
			catch(Exception $e)
			{
			        \App::abort(500, 'Database could not be created, please contact an Administrator');
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
                \App::abort(500, 'User not authenticated');

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
                \App::abort(500, 'User not authenticated');

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
                \App::abort(500, 'User not authenticated');

        }
	$put = file_get_contents('php://input');
	$data = json_decode($put, true);
	if($data['name'] != null && $data['ownerName'] != null && $data['organization'] != null && $data['maxSize'] != null && $data['description'] != null)
	{
		$i = instance::find($id);
		$oldName = $i->name;
		//check if instance exists with the same name
                //if($oldName != $data['name'] && instance::where('name', $data['name'])->exists())
                //        die("fail");

		$i->name = $data['name'];
		if(!demeterUser::where('netId', $data['ownerName'])->exists())
			//die('user does not exist');
	                \App::abort(500, "NetId does not exist");

		$i->ownerId =  demeterUser::where('netId', $data['ownerName'])->first()->id;
        	$i->organization =  $data['organization'];
	        $i->maxSize = $data['maxSize'];
        	$i->description = $data['description'];

		try
                {
                        //emit request to make db
                        $redis = \Redis::connection(); // Using the Redis extension provided client
			$redis->publish('demeter', json_encode(array('command' => 'updateInstance', 'instanceId' => $i->id, 'vm' => $i->vmId, 'oldInstanceName'=>$oldName, 'instanceName' => $i->name, 'maxSize'=>$i->maxSize, 'netId'=>$_SESSION['AUTH_USER'])));	
	        	if($i->save())
		            echo "success";
        		else
                                \App::abort(500, 'Database could not be updated, please contact an Administrator');

		}
		catch(Exception $e)
		{
                           \App::abort(500, 'Database could not be updated, please contact an Administrator');
		}
	}
	else
                 \App::abort(500, 'Database could not be updated, did you fill all fields?');
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
                \App::abort(500, 'User not authenticated');

        }
	try
        {
                $i = instance::find($id);
                //emit request to delete db
                $redis = \Redis::connection(); // Using the Redis extension provided client
		$redis->publish('demeter', json_encode(array('command' => 'deleteInstance', 'instanceId' => $i->id, 'vm' => $i->vmId, 'instanceName' => $i->name, 'netId'=>$_SESSION['AUTH_USER'])));
		if($i->instanceUsers())
                	$i->instanceUsers()->delete();
		$i->inUse = -1;
        	if($i->save())
	            echo "success";
        	else
                                \App::abort(500, 'Database could not be deleted, please contact an Administrator');

	}
	catch(Exception $e)
	{
                                \App::abort(500, 'Database could not be deleted, please contact an Administrator');
	}

    }

	public function backup()
	{
		session_start();
	        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
	                \App::abort(500, 'User not authenticated');
	        }
	        $put = file_get_contents('php://input');
	        $data = json_decode($put, true);
        	if($data['instanceId'] != null && $data['vmId'] != null && $data['type'] != null)
	        {
	                try
	                {
	                        //emit request to make db
	                        $redis = \Redis::connection(); // Using the Redis extension provided client
	                        $redis->publish('demeter', json_encode(array('command' => 'backupInstance', 'instanceId' => $data['instanceId'], 'vm' => $data['vmId'], 'type' => $data['type'], 'netId'=>$_SESSION['AUTH_USER'])));
				print "success";
	                }
	                catch(Exception $e)
	                {
                                \App::abort(500, 'Database could not be backed up, please contact an Administrator');
	                }
	        }
	        else
                                \App::abort(500, 'Database could not be backed up, did you fill all fields?');

	}

	public function addUser()
	{
		session_start();
                if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
                        \App::abort(500, 'User not authenticated');
                }
                $put = file_get_contents('php://input');
                $data = json_decode($put, true);
                if($data['instanceId'] != null && $data['netId'] != null)
                {
			if(!demeterUser::where('netId', $data['netId'])->exists())
				\App::abort(500, 'No Demeter user exists with this NetId');
			$user = demeterUser::where('netId', $data['netId'])->first();
			$i = instance::find($data['instanceId']);
			$i->users()->save($user);
		}        
                else
                	\App::abort(500, 'Could not add user, did you fill all fields?');


	}
}
