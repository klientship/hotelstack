<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'gst_no' => $this->gst_no,
            'address' => $this->address,
            'zipcode' => $this->zipcode,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'invoice_title' => $this->invoice_title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
