<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function reservation() {
        return $this->belongsTo(Reservation::class,'reservation_id','id');
    }

}
