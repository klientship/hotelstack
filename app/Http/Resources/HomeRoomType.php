<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\HomeRoomTypeRoom as HomeRoomTypeRoomResource;

class HomeRoomType extends JsonResource
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
            'id' =>$this->id,
            'title' =>$this->title,
            'rooms' => HomeRoomTypeRoomResource::collection($this->rooms)
        ];
    }
}
