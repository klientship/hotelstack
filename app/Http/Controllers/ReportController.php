<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Report as ReportResource;

use App\Reservation;

use Carbon\Carbon;

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
