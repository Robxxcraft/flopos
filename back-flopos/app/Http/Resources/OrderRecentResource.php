<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderRecentResource extends JsonResource
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
            'username' => $this->user->username,
            'total_amount' => $this->total_amount,
            'total_quantity' => $this->total_quantity,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->locale('id')->diffForHumans()
        ];
    }
}
