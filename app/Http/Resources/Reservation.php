<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ReservationRoom as ReservationRoomResource;
use App\Http\Resources\Payment as PaymentResource;

use Carbon\Carbon;
use Helpers;

class Reservation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      // $date_check_in = Carbon::parse($this->check_out);
      // $date_check_out = Carbon::parse($this->check_in);
      // $nights = $date_check_out->diffInDays($date_check_in);

      $nights = Helpers::getNights($this->check_in, $this->check_out);
      if($this->invoice) 
      {
        $invoice_no = $this->generated_invoice->no;
      }else{
        $invoice_no = 'NULL';
      }
 
      // awaiting checkout calculation
      $today = Carbon::now();
      $date_check_out = Carbon::parse($this->check_out);
  
      $awaiting_check_out = 0;
      if($date_check_out < $today && $this->checked_in && !$this->checked_out)
      {
        $awaiting_check_out = 1;
      }

      return [ 
        'id' => $this->id,
        'uid' => $this->uid,
        'oyo_id' => $this->oyo_id,
        'active' => $this->active,
        'checked_in' => $this->checked_in,
        'checked_out' => $this->checked_out,
        'no_show' => $this->no_show,
        'invoice' => $this->invoice,
        'adults' => $this->adults,
        'kids' => $this->kids,
        'created_at' => Carbon::parse( $this->created_at)->format('d-m-Y H:i'),
      
        'check_in' => $this->check_in,
        'check_out' => $this->check_out,

        'type' => $this->type,

        'nights' => $nights,
     
        'number_of_room' => $this->number_of_room,
        'total' => $this->total,
        'discount' => $this->discount,
        'rooms' => ReservationRoomResource::collection($this->rooms),
        'payments' => PaymentResource::collection($this->payments),
        'paid_services' => $this->paid_services,
        'date' => $this->created_at,
        'status' => $this->status,
      
        // guest
        'name' => $this->guest->name,
        'email' => $this->guest->email,
        'phone' => $this->guest->phone,
        'guest_id' => $this->guest->id,
        'address' => $this->guest->address,
        'company_name' => $this->guest->company_name,
        'gst_no' => $this->guest->gst_no,
        // awaiting checkout
        'awaiting_check_out'=>$awaiting_check_out,

        // 'invoice'
        'invoice_no' => $invoice_no

      ];
    }
}
