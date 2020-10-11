<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\ReservationRoom;
use App\Payment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Reservation as ReservationResource;

use Carbon\Carbon;

class CheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkins = Reservation::where('checked_in', 1)->orderBy('id', 'desc')->get();
        return ReservationResource::collection($checkins);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CheckIn  $checkIn
     * @return \Illuminate\Http\Response
     */
    public function show(CheckIn $checkIn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CheckIn  $checkIn
     * @return \Illuminate\Http\Response
     */
    public function edit(CheckIn $checkIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CheckIn  $checkIn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CheckIn $checkIn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CheckIn  $checkIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(CheckIn $checkIn)
    {
        //
    }

      /**
     * Update the specified resource in storage.
     *
     * 
     * @param  \App\CheckIn  $checkIn
     * @return \Illuminate\Http\Response
     */
    public function check_out($checkIn)
    {

   
        // $reservation->checked_in = 1;
        // $reservation->save();
        // return response()->json(null,200);
        return $checkIn;
    }
}
