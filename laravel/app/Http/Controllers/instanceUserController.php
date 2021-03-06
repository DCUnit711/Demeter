<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\instanceUser;
use App\instance;
use Illuminate\Http\Response;

class instanceUserController extends Controller
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
        if(!isset($_SESSION['AUTH']) ||  $_SESSION['AUTH'] == false) {
            \App::abort(500, 'User not authenticated');

        }
        $i = instanceUser::with('instance')->get();
	   return response()->json($i);
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
        if($data['name'] != null && $data['password'] != null && $data['instanceId'] != null)
	{
		//check if user with same name exists in that instance
		if(instanceUser::where('name', $data['name'])->where('instanceId', $data['instanceId'])->exists())
	                \App::abort(500, 'Username already exists');

		   //create a new instance user, expects name and instanceId
		$i = new instanceUser();
	        $i->id = \Uuid::generate(4);
        	$i->name = $data['name'];
	        $i->instanceId = $data['instanceId'];
		try
                {
			$inst = Instance::find($i->instanceId);
                        //emit request to make db
                        $redis =  \Redis::connection(); // Using the Redis extension provided client
                        $redis->publish('demeter', json_encode(array('command' => 'createInstanceUser', 'vm' => $inst->vmId, 'instanceId' => $inst->id, 'instanceName' => $inst->name, 'username'=>$i->name, 'password'=>$data['password'], 'netId'=>$_SESSION['AUTH_USER'])));

			if($i->save())
	                	echo "success";
		        else
                                \App::abort(500, 'User could not be created, please contact an Administrator');
		}
		catch(Exception $e)
		{
                                \App::abort(500, 'User could not be created, please contact an Administrator');
		}
	}
	else
                                \App::abort(500, 'User could not be created, please contact an Administrator');
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
        $i = instanceUser::find($id)->with('instance')->get();
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
        //
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
        if($data['password'] != null)
	{
	        $i = instanceUser::find($id);
		$inst = Instance::find($i->instanceId);
		$redis =  \Redis::connection(); // Using the Redis extension provided client
                $redis->publish('demeter', json_encode(array('command' => 'resetPassword', 'vm' => $inst->vmId, 'instanceId' => $inst->id, 'instanceName' => $inst->name, 'username'=>$i->name, 'password'=>$data['password'], 'netId'=>$_SESSION['AUTH_USER'])));

       	        echo "success";
	}
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
        $i = instanceUser::find($id);
	try
        {
                //emit request to make db
                $redis = \Redis::connection(); // Using the Redis extension provided client
		$redis->publish('demeter', json_encode(array('command' => 'deleteInstanceUser', 'vm' => $i->instance->vmId, 'instanceId' => $i->instance->id, 'instanceName' => $i->instance->name, 'username'=>$i->name, 'netId'=>$_SESSION['AUTH_USER'])));
        	if($i->delete())
	                echo "success";
        	else
                                \App::abort(500, 'User could not be deleted, please contact an Administrator');
	}
	catch(Exception $e)
	{
                                \App::abort(500, 'User could not be deleted, please contact an Administrator');
	}

    }
}
