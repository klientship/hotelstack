<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Room extends JsonResource
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
            'room_type' => $this->room_type->title,
            'room_type_id' => $this->room_type->id,
            'floor' => $this->floor->name,
            'floor_id' => $this->floor->id,
            'number' => $this->number,
            'base_price' => $this->room_type->base_price,
        
            'status' => $this->status,
          
          ];
    
    }
}
