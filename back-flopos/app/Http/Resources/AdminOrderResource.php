<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'token' => $this->token,
            'total_quantity' => $this->total_quantity,
            'total_amount' => $this->total_amount,
            'courier' => $this->courier,
            'payment' => $this->payment,
            'address' => $this->address,
            'zipcode' => $this->zipcode,
            'token' => $this->token,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->locale('id')->translatedFormat('d F Y')
        ];
    }
}
