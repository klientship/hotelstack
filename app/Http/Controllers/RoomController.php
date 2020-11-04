<?php

namespace App\Http\Controllers;

use App\Room;
use App\Reservation;
use App\ReservationRoom;
use Carbon\Carbon;
use App\RoomType;
use App\HouseKeeping;
use Helpers;
use Illuminate\Http\Request;
use App\Http\Resources\Room as RoomResource;
use App\Http\Resources\AvailableRoom as AvailableRoomResource;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        return RoomResource::collection($rooms);
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
            'number'=>'required|integer|unique:rooms|min:1',
            'room_type_id'=>'required|integer',
            'floor_id'=>'required|integer',
            'status'=>'required',
        ]);

        $room = new Room;
        $room->number = $request->number;
        $room->room_type_id = $request->room_type_id;
        $room->floor_id = $request->floor_id;
        $room->status = $request->status;
        $room->save();
        return new RoomResource($room);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $this->validate($request,[
            'number'=>"required|integer|min:1|unique:rooms,number,$room->id",
            'room_type_id'=>'required|integer',
            'floor_id'=>'required|integer',
            'status'=>'required',
        ]);


        $room->number = $request->number;
        $room->room_type_id = $request->room_type_id;
        $room->floor_id = $request->floor_id;
        $room->status = $request->status;
        $room->save();
        return new RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(null,204);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function availableRooms(Request $request)
    {
        $this->validate($request,[
            'check_in'=>'required',
            'check_out'=>'required',
        ]);


        $dateCheckin = Carbon::createFromFormat('d-m-Y H:i', $request->check_in)->format('Y-m-d H:i');
        $dateCheckout = Carbon::createFromFormat('d-m-Y H:i', $request->check_out)->format('Y-m-d H:i');
  
        $reservations = Reservation::where('active', 1)
        ->where('no_show','=', 0)
        ->where('checked_out', 0)
        
        ->where(function($query) use ($dateCheckin, $dateCheckout){
                    $query->where([
                        ['check_in', '<=', $dateCheckin],
                        ['check_out', '>=', $dateCheckin]
                    ])
                    ->orWhere([
                        ['check_in', '<', $dateCheckout],
                        ['check_out', '>=', $dateCheckout]
                    ])
                    ->orWhere([
                        ['check_in', '>=', $dateCheckin],
                        ['check_out', '<', $dateCheckout]
                    ]);
                })
              ->orderBy('check_in')
              ->get();
             

              
              $bookedRooms = [];

              $houseKeepings = HouseKeeping::all()->pluck('room_id')->toArray();;

              

              foreach($reservations as $reservation)
              {
                foreach ($reservation->rooms as $key => $room) {
                    array_push($bookedRooms, $room->room_id);
                }
              }

              $bookedRooms = array_unique(array_merge($bookedRooms, $houseKeepings));
  
              if(empty($bookedRooms)){
                $roomTypes = RoomType::all();
              }else {      
                $availableRooms = [];
                  $availableRooms = Room::whereNotIn('id',$bookedRooms)->pluck('id')->toArray();
                 
                  $roomTypes = RoomType::with(['rooms'=> function($query) use ($availableRooms) {
                    $query->whereIn('id', $availableRooms);
                  }
                  ])->get();
              }
      
              return AvailableRoomResource::collection($roomTypes);

        
    }

    public function available_rooms_id() {
        
        $reservations = Reservation::where('active', 1)
        ->where('no_show', 0)
        ->where('checked_out', 0)
        ->get();
              
              $bookedRooms = [];

              foreach($reservations as $reservation)
              {
                foreach ($reservation->rooms as $key => $room) {
                    array_push($bookedRooms, $room->room_id);
                }
              }
              if(empty($bookedRooms)){
                $availableRooms = Room::all()->pluck('id')->toArray();
              }else {      
        
          $availableRooms = Room::whereNotIn('id', $bookedRooms)->pluck('id')->toArray();
          
            }
            return $availableRooms;
    }

    public function awaitingCheckoutId() {
        return Helpers::getAwaitingCheckout();
    }

    public function oyoCheckinId() {
        return Helpers::getOyoCheckinsRooms();
    }
    public function total_rooms() {
        return Room::all()->count();

    }

}
