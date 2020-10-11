<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Resources\Guest as GuestResource;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $guests = User::where("role","customer")->latest()->get();
       return GuestResource::collection($guests);
    }

    public function this_month()
    {
        $date = Carbon::now();
        $guests = $this->getMonth($date);
        return GuestResource::collection($guests);
    }

    public function present_guests()
    {
        $guests = User::where("role","customer")->with(['reservation'=> function($query)  {
            $query->where('active', '1')
            ->where('checked_in','1')
            ->where('checked_out','0');
          }
          ])->latest()->get();

          $present_guests = [];
        foreach ($guests as $key => $guest) {
            if($guest->reservation && count($guest->reservation))
            {
             array_push($present_guests, $guest);
            } 
        }
        return GuestResource::collection($present_guests);
    }

    public function last_month()
    {
        $date = Carbon::now();
        $guests = $this->getLastMonth($date);
        return GuestResource::collection($guests);
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

    public function getMonth($date)
    {
        $year = $date->year;
        $month = $date->month;

        if ($month < 10) {
            $month = '0' . $month;
        }

        $search = $year . '-' . $month;

        $guests = User::where('created_at', 'like', $search .'%')->where("role","customer")->latest()->get();

        return $guests;
    }

    public function getLastMonth($date)
    {
        $year = $date->year;
        $month = $date->month - 1;

        if ($month < 10) {
            $month = '0' . $month;
        }

        $search = $year . '-' . $month;

        $guests = User::where('created_at', 'like', $search .'%')->where("role","customer")->latest()->get();

        return $guests;
    }
}
