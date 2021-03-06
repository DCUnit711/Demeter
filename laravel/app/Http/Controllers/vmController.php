<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\vm;

class vmController extends Controller
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
        $vms = vm::with('instances')->get();
	   return response()->json($vms);
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
        if($data['ipAddr'] != null && $data['type'] != null)
	{
	   //creates a new VM in middleware database. Expects ipaddress and type
	        $v = new vm();
		$v->id = \Uuid::generate(4);
		$v->ipAddr = $data['ipAddr'];
		$v->type = $data['type'];
		try
                {
                        //emit request to make vm
                        $redis = \Redis::connection(); // Using the Redis extension provided client
			$redis->publish('demeter', json_encode(array('command' => 'init', 'vm' => $v->id->string, 'type' => $v->type, 'netId'=>$_SESSION['AUTH_USER'])));
			if($v->save())
				echo "success";
			else
                                \App::abort(500, 'VM could not be created, please contact an Administrator');
		}
		catch(Exception $e)
		{
                                \App::abort(500, 'VM could not be created, please contact an Administrator');
		}
	}
	else
                                \App::abort(500, 'VM could not be created, please contact an Administrator');
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
        $v = vm::find($id)->with('instances')->get();
	   return response()->json($v);
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
        if($data['name'] != null && $data['ipAddr'] != null && $data['type'] != null)
	{
	        $v = vm::find($id);
		$v->ipAddr = $data['ipAddr'];
	        $v->type = $data['type'];
		try
                {
                        //emit request to make db
                        $redis = \Redis::connection(); // Using the Redis extension provided client
			$redis->publish('demeter', json_encode(array('command' => 'updateVm', 'vm' => $v->id,'type' => $v->type, 'netId'=>$_SESSION['AUTH_USER'])));
        		if($v->save())
	                	echo "success";
	        	else
                                \App::abort(500, 'VM could not be updated, please contact an Administrator');
		}
		catch(Exception $e)
		{
                                \App::abort(500, 'VM could not be updated, please contact an Administrator');
		}
	}
	else
                                \App::abort(500, 'VM could not be updated, please contact an Administrator');
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
        $v = vm::find($id);
	try
        {
                //emit request to make db
                $redis = Redis::connection(); // Using the Redis extension provided client
		$redis->publish('demeter', json_encode(array('command' => 'deleteVm', 'vm' => $id, 'netId'=>$_SESSION['AUTH_USER'])));
		    if($v->instances())
		    {
			foreach($instances as $i)
			{
				if($i->instanceUsers())
		                        $i->instanceUsers()->delete();
			}
			$v->instances()->delete();
		    }
		   if($v->delete())
			  echo "success";
		   else
                                \App::abort(500, 'VM could not be deleted, please contact an Administrator');
	}
        catch(Exception $e)
        {
                                \App::abort(500, 'VM could not be deleted, please contact an Administrator');
        }

    }
}
