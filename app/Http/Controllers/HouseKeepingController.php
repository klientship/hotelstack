<?php

namespace App\Http\Controllers;

use App\HouseKeeping;
use Illuminate\Http\Request;

class HouseKeepingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $houseKeepings = HouseKeeping::all()->pluck('room_id')->toArray();;
     return $houseKeepings;
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
        'room_id'=>"required|max:191",
    ]);
      $houseKeeping = new HouseKeeping;
      $houseKeeping->room_id = $request->room_id;
      $houseKeeping->save();
      return response()->json($houseKeeping,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function show(HouseKeeping $houseKeeping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function edit(HouseKeeping $houseKeeping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       HouseKeeping::where('room_id', $request->room_id)->delete();
       return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function destroy(HouseKeeping $houseKeeping)
    {
        $houseKeeping->delete();
        return response()->json(null, 204);
    }
}
