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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	//Creates a new demeterUser. Expects netId, email, and role ('admin' or 'client')
        $u = new demeterUser();
	$u->id = \Uuid::generate(4);
	$u->netId = $request->input('netId');
	$u->email = $request->input('email');
	$u->role = $request->input('role');
	if($u->save())
	    echo "success";
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
        $u = demeterUser::find($id);
	$u->netId = $request->input('netId');
	$u->email = $request->input('email');
	$u->role = $request->input('role');
	if($u->save())
	    echo "success";
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
        $u = demeterUser::find($id);
	if($u->delete())
	    echo "success";
	else
	    echo "fail";
    }
}
