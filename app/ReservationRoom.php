<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationRoom extends Model
{
   
    public function room(){
        return $this->belongsTo(Room::class,'room_id','id');
    }
    
    public function reservation(){
        return $this->belongsTo(Reservation::class,'reservation_id','id');
    }
}
