<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Helpers;

class Report extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $nights = Helpers::getNights($this->check_in, $this->check_out);
        return [
        'id' => $this->id,
        // reservation
        'uid' => $this->uid,
        'active' => $this->active,

        'adults' => $this->adults,
        'kids' => $this->kids,
        'created_at' => Carbon::parse( $this->created_at)->format('d-m-Y H:i'),

        'check_in' => $this->check_in,
        'check_out' => $this->check_out,

        'type' => $this->type,

        'nights' => $nights,

        'number_of_room' => $this->number_of_room,
        'total' => $this->total - $this->discount,
        'discount' => $this->discount,
        'rooms' => $this->rooms,

        'status' => $this->status,

        // guest
        'name' => $this->guest->name,

        ];
    }
}
