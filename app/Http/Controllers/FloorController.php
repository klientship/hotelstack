<?php

namespace App\Http\Controllers;

use App\Floor;
use Illuminate\Http\Request;
use App\Http\Resources\Floor as FloorResource;


class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = Floor::all();
        return FloorResource::collection($floors);
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
      
        $this->validate($request,[
            'name'=>'required|max:191|unique:floors',
            'number'=>'required|integer|unique:floors',
            'status'=>'required|boolean',
        ]);
        $floor = new Floor;
        $floor->name = $request->name;
        $floor->number = $request->number;
        $floor->description = $request->description;
        $floor->status = $request->status;
        $floor->save();

        return new FloorResource($floor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function show(Floor $floor)
    {
        return new FloorResource($floor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function edit(Floor $floor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Floor $floor)
    {

        $this->validate($request,[
            'name'=>"required|max:191|unique:floors,name,$floor->id",
            'number'=>"required|integer|unique:floors,number,$floor->id",
            'status'=>'required|boolean',
        ]);

        $floor->name = $request->name;
        $floor->number = $request->number;
        $floor->description = $request->description;
        $floor->status = $request->status;
        $floor->save();

        return new FloorResource($floor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Floor $floor)
    {
        $floor->delete();
        return response()->json(null,204);
    }
}
