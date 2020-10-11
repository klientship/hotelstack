<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    
    public function guest() {
        return $this->belongsTo(User::class,'guest_id','id');
    }

    public function rooms() {
        return $this->hasMany(ReservationRoom::class, 'reservation_id','id');
    }
    public function payments() {
        return $this->hasMany(Payment::class, 'reservation_id','id');
    }
    public function paid_services() {
        return $this->hasMany(ReservationPaidService::class, 'reservation_id','id');
    }
    public function generated_invoice() {
        return $this->hasOne(Invoice::class, 'reservation_id','id');
    }

}
