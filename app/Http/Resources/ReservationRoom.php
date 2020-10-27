<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationRoom extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->room->room_type->title,
            'price' => $this->price,
            'ac_price' => $this->room->room_type->ac_price,
            'oyo_price' => $this->room->room_type->oyo_price,
            'other_price' => $this->room->room_type->other_price,
            'room_type_id' => $this->room->room_type->id,
            'floor' => $this->room->floor->name,
            'floor_id' => $this->room->floor->id,
            'number' => $this->room->number,
            'base_price' => $this->room->room_type->base_price,
            'tax_1' => $this->room->room_type->tax_1,
            'tax_2' => $this->room->room_type->tax_2,
            'status' => $this->room->status,
            'room_id' => $this->room->id
          
          ];
    }
}
