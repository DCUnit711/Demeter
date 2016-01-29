<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\instanceUser;
use Illuminate\Http\Response;

class instanceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	//create a new instance user, expects name and instanceId
	$i = new instanceUser();
        $i->id = \Uuid::generate(4);
        $i->name = $request->input('name');
        $i->instanceId = $request->input('instanceId');
	if($i->save())
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
        $i = instanceUser::find($id);
        $i->name = $request->input('name');
        $i->instanceId = $request->input('instanceId');
        if($i->save())
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
         $i = instanceUser::find($id);
        if($i->delete())
                echo "success";
        else
                echo "fail";

    }
}