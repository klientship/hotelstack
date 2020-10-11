<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Helpers;

class Payment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $uid = Helpers::createUid($this->reservation_id);
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'reservation_id' => $this->reservation_id,
            'uid' => $this->reservation->uid,
            'advance' => $this->advance,
            'type' => $this->type,
            'created_at' =>$this->created_at,
        ];
    }
}
