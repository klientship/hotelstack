<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Guest extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'role' => $this->role,
            'phone' => $this->phone,
            'address' => $this->address,
            'gst_no' => $this->gst_no,
            'created_at' => Carbon::parse( $this->created_at)->format('d-m-Y g:i a'),
        ];
    }
}
