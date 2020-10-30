<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationColdDrink extends Model
{
    public function reservation() {
        return $this->belongsTo(Reservation::class,'reservation_id','id');
    }

    public function product() {
        return $this->belongsTo(ColdDrink::class,'product_id','id');
    }

}
