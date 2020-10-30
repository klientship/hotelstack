<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationColdDrink extends JsonResource
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
            "id" => $this->id,
            "name" => $this->product->product_name,
            "quantity" => $this->quantity,
            "price" => $this->product->price,
            "reservation_id" => $this->reservation_id,
            "total" => (int)$this->product->price * (int)$this->quantity,
            "created_at" => $this->created_at
        ];
    }
}
