<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReservationAllPaidService extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'created_at' => Carbon::parse( $this->created_at)->format('d-m-Y g:i a'),
            'uid' => $this->reservation->uid
           ];
    }
}
