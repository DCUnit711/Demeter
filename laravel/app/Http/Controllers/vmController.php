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
            die('fail');
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
        if($data['ipAddr'] != null && $data['type'] != null)
	{
	   //creates a new VM in middleware database. Expects ipaddress and type
	        $v = new vm();
		$v->id = \Uuid::generate(4);
		$v->ipAddr = $data['ipAddr'];
		$v->type = $data['type'];
		try
                {
                        //emit request to make db
                        $redis = \Redis::connection(); // Using the Redis extension provided client
                        //$redis->connect($v->ipAddr, '1338'); //we need to pick a port
                        $emitter = new \SocketIO\Emitter($redis);
                        $emitter->emit('init', array('vm' => $v->id, 'type' => $v->type));

			if($v->save())
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
        if($data['name'] != null && $data['ipAddr'] != null && $data['type'] != null)
	{
	        $v = vm::find($id);
		$v->ipAddr = $data['ipAddr'];
	        $v->type = $data['type'];
		try
                {
                        //emit request to make db
                        $redis = \Redis::connection(); // Using the Redis extension provided client
                        //$redis->connect($v->ipAddr, '1338'); //we need to pick a port
                        $emitter = new \SocketIO\Emitter($redis);
                        $emitter->emit('updateVm', array('vm' => $v->id,'type' => $v->type));

        		if($v->save())
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
        $v = vm::find($id);
	try
        {
                //emit request to make db
                $redis = Redis::connection(); // Using the Redis extension provided client
                //$redis->connect($v->ipAddr, '1338'); //we need to pick a port
                $emitter = new \SocketIO\Emitter($redis);
                $emitter->emit('deleteVm', array('vm' => $id));
		
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
			  echo "fail";
	}
        catch(Exception $e)
        {
                echo "fail";
        }

    }
}
