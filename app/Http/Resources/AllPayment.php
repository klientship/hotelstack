<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AllPayment extends JsonResource
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
            'amount' => $this->amount,
            'reservation_id' => $this->reservation_id,
            'uid' => $this->reservation->uid,
            'advance' => $this->advance,
            'type' => $this->type,
            'created_at' => Carbon::parse( $this->created_at)->format('d-m-Y g:i a'),
        ];
    }
}
