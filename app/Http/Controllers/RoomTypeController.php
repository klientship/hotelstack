<?php

namespace App\Http\Controllers;

use App\RoomType;
use Illuminate\Http\Request;
use App\Http\Resources\RoomType as RoomTypeResource;
use App\Http\Resources\HomeRoomType as HomeRoomTypeResource;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $room_types = RoomType::all();
        return RoomTypeResource::collection($room_types);
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
            'title'=>'required|max:191|unique:room_types',
            'short_code'=>'required|max:191|unique:room_types',
            'description'=>'max:500',
            'base_price'=>'required|numeric|min:0',
            'tax_1'=>'required|numeric',
            'tax_2'=>'required|numeric',
            'status'=>'required|boolean',
        ]);

        $roomType= new RoomType;
        $roomType->title = $request->title;
        $roomType->short_code = $request->short_code;
        $roomType->description = $request->description;
        $roomType->base_price = $request->base_price;
        $roomType->ac_price = $request->ac_price;
        $roomType->other_price = $request->other_price;
        $roomType->tax_1 = $request->tax_1;
        $roomType->tax_2 = $request->tax_2;
        $roomType->status = $request->status;
        $roomType->save();

        return new RoomTypeResource($roomType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function show(RoomType $roomType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomType $roomType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomType $roomType)
    {
        $this->validate($request,[
            'title'=>"required|max:191|unique:room_types,title,$roomType->id",
            'short_code'=>"required|max:191|unique:room_types,short_code,$roomType->id",
            'description'=>'max:500',
            'base_price'=>'required|numeric|min:0',
            'tax_1'=>'required|numeric',
            'tax_2'=>'required|numeric',
            'status'=>'required|boolean',
        ]);

        $roomType->title = $request->title;
        $roomType->short_code = $request->short_code;
        $roomType->description = $request->description;
        $roomType->base_price = $request->base_price;
        $roomType->ac_price = $request->ac_price;
        $roomType->other_price = $request->other_price;
        $roomType->tax_1 = $request->tax_1;
        $roomType->tax_2 = $request->tax_2;
        $roomType->status = $request->status;
        $roomType->save();

        return new RoomTypeResource($roomType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return response()->json(null,204);
    }

    public function room_types_with_rooms()
    {
        $room_types = RoomType::all();
        return HomeRoomTypeResource::collection($room_types);
    }
}
