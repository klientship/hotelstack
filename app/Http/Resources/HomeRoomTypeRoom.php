<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeRoomTypeRoom extends JsonResource
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
            'type' => $this->room_type->title,
            'price' => $this->room_type->base_price,
            'ac_price' => $this->room_type->ac_price,
            'oyo_price' => $this->room_type->oyo_price,
            'other_price' => $this->room_type->other_price,
            'room_type_id' => $this->room_type->id,
            'floor' => $this->floor->name,
            'floor_id' => $this->floor->id,
            'number' => $this->number,
            'base_price' => $this->room_type->base_price,
            'tax_1' => $this->room_type->tax_1,
            'tax_2' => $this->room_type->tax_2,
            'status' => $this->status,
        ];
    }
}
