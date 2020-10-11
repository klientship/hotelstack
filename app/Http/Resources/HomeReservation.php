<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeReservation extends JsonResource
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
        'uid' => $this->uid,
        'active' => $this->active,
        'checked_in' => $this->checked_in,
        'checked_out' => $this->checked_out,
        'adults' => $this->adults,
        'kids' => $this->kids,
        'check_in' => $this->check_in,
        'check_out' => $this->check_out,
        'total' => $this->total,
        'number_of_room' => $this->number_of_room,

        'name' => $this->guest->name
        ];
    }
}
