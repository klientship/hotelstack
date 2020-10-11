<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AvailableRoomTypeRoom as AvailableRoomTypeRoomResource;

class AvailableRoom extends JsonResource
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
            'title' => $this->title,
            'base_price' => $this->base_price,
            'status' => $this->status,
            'rooms' => AvailableRoomTypeRoomResource::collection($this->rooms),
          ];
    }
}
