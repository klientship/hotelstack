<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function floor(){
        return $this->belongsTo(Floor::class,'floor_id','id');
    }
    public function room_type(){
        return $this->belongsTo(RoomType::class,'room_type_id','id');
    }
    
}
