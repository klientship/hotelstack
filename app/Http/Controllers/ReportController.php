<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Report as ReportResource;

use App\Reservation;

use Carbon\Carbon;
use Helpers;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::latest()->get();
        return ReportResource::collection($reservations);
    }

    public function oyo_bookings()
    {
       
        $reservations = Reservation::where('oyo',1)->latest()->get();
        return ReportResource::collection($reservations);
    }

    public function this_month_oyo_bookings()
    {
       
        $reservations = Reservation::where('oyo',1)->where('created_at', 'like', Helpers::calculateThisMonth() .'%')->latest()->get();
        return ReportResource::collection($reservations);
    }

    public function last_month_oyo_bookings()
    {
       
        $reservations = Reservation::where('oyo',1)->where('created_at', 'like', Helpers::calculateLastMonth() .'%')->latest()->get();
        return ReportResource::collection($reservations);
    }

    public function present_checkedin_oyo_bookings()
    {
       
        $reservations = Reservation::where('oyo',1)->where('checked_in',1)->where('checked_out',0)->latest()->get();
        return ReportResource::collection($reservations);
    }

    public function oyo_card_details()
    {
       
        $total_bookings = Reservation::where('oyo',1)->count();
        $monthly_bookings = Reservation::where('oyo',1)->where('created_at', 'like', Helpers::calculateLastMonth() .'%')->count();
        $total_amount = Reservation::where('oyo',1)->sum('total') - Reservation::where('oyo',1)->sum('discount');
        $monthly_total = Reservation::where('oyo',1)->where('created_at', 'like', Helpers::calculateLastMonth() .'%')->sum('total') - Reservation::where('oyo',1)->where('created_at', 'like', Helpers::calculateLastMonth() .'%')->sum('discount');

        $todays_oyo_business_array = Reservation::where('oyo',1)->pluck('total')->toArray();
        $LastSevenOyoBusiness = Helpers::getSevenDays($todays_oyo_business_array);
        
        return [
            'total_bookings' => $total_bookings,
            'monthly_bookings' => $monthly_bookings,
            'total_amount' => $total_amount,
            'monthly_total' => $monthly_total,
            'oyo_business' => [
                'series'=> [
                  [
                    'name' => "Oyo Business",
                    'data' =>  $LastSevenOyoBusiness,
                  ],
                ],
                'analyticsData' => [
                  'orders'=> 97500,
             ],
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function this_month()
    {
        $date = Carbon::now();
        $reservations = $this->getMonthly($date);
        return ReportResource::collection($reservations);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function last_month()
    {
        $date = Carbon::now();
        $reservations = $this->getLastMonth($date);
        return ReportResource::collection($reservations);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function present_checkins()
    {
        
        $reservations = Reservation::where('checked_in', 1)->where('checked_out',0)->latest()->get();
        return ReportResource::collection($reservations);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function getMonthly($date)
    {
        $year = $date->year;
        $month = $date->month;

        if ($month < 10) {
            $month = '0' . $month;
        }

        $search = $year . '-' . $month;

        $reservations = Reservation::where('created_at', 'like', $search .'%')->latest()->get();

        return $reservations;
    }

    public function getLastMonth($date)
    {
        $year = $date->year;
        $month = $date->month - 1;

        if ($month < 10) {
            $month = '0' . $month;
        }

        $search = $year . '-' . $month;

        $reservations = Reservation::where('created_at', 'like', $search .'%')->latest()->get();

        return $reservations;
    }
}
