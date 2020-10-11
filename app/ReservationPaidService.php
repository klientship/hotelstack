<?php

namespace App;
use App\Reservation;
use Illuminate\Database\Eloquent\Model;

class ReservationPaidService extends Model
{
    public function reservation(){
        return $this->belongsTo(Reservation::class,'reservation_id','id');
    }
}
