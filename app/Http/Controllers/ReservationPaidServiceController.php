<?php

namespace App\Http\Controllers;

use App\ReservationPaidService;
use Illuminate\Http\Request;
use App\Http\Resources\ReservationAllPaidService as ReservationAllPaidServiceResource;
use Helpers;

class ReservationPaidServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paid_services = ReservationPaidService::latest()->get();
       return ReservationAllPaidServiceResource::collection($paid_services);
    }

    public function this_month()
    {
      $paid_services = Helpers::getThisMonth(ReservationPaidService::class);
       return ReservationAllPaidServiceResource::collection($paid_services);
    }

    public function last_month()
    {
      $paid_services = Helpers::getLastMonth(ReservationPaidService::class);
       return ReservationAllPaidServiceResource::collection($paid_services);
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
           
            'description'=>'required|max:1000',
            'price'=>'required|integer',
            'reservation_id'=>'required|integer',
        ]);

        $paidService = new ReservationPaidService;
        $paidService->description = $request->description;
        $paidService->price = $request->price;
        $paidService->reservation_id = $request->reservation_id;
        $paidService->save();

        return $paidService;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservationPaidService  $reservationPaidService
     * @return \Illuminate\Http\Response
     */
    public function show(ReservationPaidService $reservationPaidService)
    {
       
        return $reservationPaidService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservationPaidService  $reservationPaidService
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservationPaidService $reservationPaidService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservationPaidService  $reservationPaidService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservationPaidService $reservationPaidService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservationPaidService  $reservationPaidService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservationPaidService $reservationPaidService)
    {
        $reservationPaidService->delete();
        return response()->json(null,204);
    }
}
