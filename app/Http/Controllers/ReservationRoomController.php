<?php

namespace App\Http\Controllers;

use App\ReservationRoom;
use App\Reservation;
use Illuminate\Http\Request;

use App\Http\Resources\Reservation as ReservationResource;

class ReservationRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\ReservationRoom  $reservationRoom
     * @return \Illuminate\Http\Response
     */
    public function show(ReservationRoom $reservationRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservationRoom  $reservationRoom
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservationRoom $reservationRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservationRoom  $reservationRoom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservationRoom $reservationRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservationRoom  $reservationRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservationRoom $reservationRoom)
    {
       $reservationRoom->delete();
       return response()->json(null,204);
    }

    public function view_room_details($id)
    {
       $reservation_id = ReservationRoom::where('room_id', $id)->pluck('reservation_id')->toArray();
       $reservation = Reservation::whereIn('id', $reservation_id)->where('checked_in', 1)->where('checked_out', 0)->where('active', 1)->get();

       if($reservation)
       {
        return new ReservationResource($reservation[0]);
       }
       
    }
}
