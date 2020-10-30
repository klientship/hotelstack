<?php

namespace App\Http\Controllers;

use App\ReservationColdDrink;
use Illuminate\Http\Request;
use App\Http\Resources\ReservationColdDrink as ReservationColdDrinkResource;

class ReservationColdDrinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cold_drinks = ReservationColdDrink::latest()->get();
        return ReservationColdDrinkResource::collection($cold_drinks);
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
            'reservation_id'=>'required|integer',
            'product_id'=>'required|integer',
            'quantity'=>'required|integer',
        ]);

        $cold_drink = new ReservationColdDrink;
        $cold_drink->product_id = $request->product_id;
        $cold_drink->reservation_id = $request->reservation_id;
        $cold_drink->quantity = $request->quantity;
        $cold_drink->save();

        return new ReservationColdDrinkResource($cold_drink);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservationColdDrink  $reservationColdDrink
     * @return \Illuminate\Http\Response
     */
    public function show(ReservationColdDrink $reservationColdDrink)
    {
        return new ReservationColdDrinkResource($reservationColdDrink);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservationColdDrink  $reservationColdDrink
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservationColdDrink $reservationColdDrink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservationColdDrink  $reservationColdDrink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservationColdDrink $reservationColdDrink)
    {
        $this->validate($request,[
            'reservation_id'=>'required|integer',
            'product_id'=>'required|integer',
            'quantity'=>'required|integer',
        ]);

     
        $reservationColdDrink->product_id = $request->product_id;
        $reservationColdDrink->reservation_id = $request->reservation_id;
        $reservationColdDrink->quantity = $request->quantity;
        $reservationColdDrink->save();

        return new ReservationColdDrinkResource($reservationColdDrink);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservationColdDrink  $reservationColdDrink
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservationColdDrink $reservationColdDrink)
    {
        $reservationColdDrink->delete();
        return response()->json(null,204);
    }
}
