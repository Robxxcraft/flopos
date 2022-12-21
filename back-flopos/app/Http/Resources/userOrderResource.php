<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class userOrderResource extends JsonResource
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
            'total_amount' => $this->total_amount,
            'total_quantity' => $this->total_quantity,
            'courier' => $this->courier,
            'payment' => $this->payment,
            'address' => $this->address,
            'zipcode' => $this->zipcode,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->locale('id')->translatedFormat('d F Y')
        ];
    }
}