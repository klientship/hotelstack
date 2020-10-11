<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ReservationRoom as ReservationRoomResource;
use App\Http\Resources\Payment as PaymentResource;

use Carbon\Carbon;
use Helpers;


class Invoice extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $nights = Helpers::getNights($this->reservation->check_in, $this->reservation->check_out);
        $tax = Helpers::calculateTotalTax($nights, $this->reservation->rooms);

        return [
        'id' => $this->id,
        'no' => $this->no,
        'reservation_id' => $this->reservation_id,
        // reservation
        'uid' => $this->reservation->uid,
        'active' => $this->reservation->active,

        'adults' => $this->reservation->adults,
        'kids' => $this->reservation->kids,
        'created_at' => Carbon::parse( $this->reservation->created_at)->format('d-m-Y H:i'),

        'check_in' => $this->reservation->check_in,
        'check_out' => $this->reservation->check_out,

        'type' => $this->reservation->type,

        'nights' => $nights,

        'number_of_room' => $this->reservation->number_of_room,
        'sub_total' => $this->reservation->total,
        'tax' => $tax,
        'total' => $this->reservation->total + $tax,
        'discount' => $this->reservation->discount,
        'rooms' => $this->reservation->rooms,

        'status' => $this->reservation->status,

        // guest
        'name' => $this->reservation->guest->name,

        ];
    }
}
