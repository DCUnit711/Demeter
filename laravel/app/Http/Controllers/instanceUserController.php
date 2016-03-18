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
            die('fail');
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
        if($data['name'] != null && $data['instanceId'] != null)
	{
		//check if user with same name exists in that instance
		if(instanceUser::where('name', $data['name'])->where('instanceId', $data['instanceId'])->exists()
			die("fail");
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
                        //$redis->connect($inst->vm->ipAddr, '1338'); //we need to pick a port
                        $emitter = new \SocketIO\Emitter($redis);
                        $emitter->emit('createInstanceUser', array('vm' => $inst->vmId, 'instanceName' => $inst->name, 'name'=>$i->name));

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
        if($data['name'] != null && $data['instanceId'] != null)
	{
	        $i = instanceUser::find($id);
        	$i->name = $data['name'];
	        $i->instanceId = $data['instanceId'];
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
        $i = instanceUser::find($id);
	try
        {
                //emit request to make db
                $redis = \Redis::connection(); // Using the Redis extension provided client
                //$redis->connect($inst->vm->ipAddr, '1338'); //we need to pick a port
                $emitter = new \SocketIO\Emitter($redis);
                $emitter->emit('deleteInstanceUser', array('vm' => $i->instance->vmId, 'instanceName' => $i->instance->name, 'name'=>$i->name));

        	if($i->delete())
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
