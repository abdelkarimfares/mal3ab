<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $this->firstname . ' ' . $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'adress1' => $this->adress1,
            'adress2' => $this->adress2,
            'gender' => $this->gender,
            'city' => $this->city,
            'id' => $this->id,
            'status' => $this->account_status,
            'package' => $this->package,
        ];
    }
}
