<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'product_id' => $this->product->id,
            'title' => $this->product->title,
            'slug' => $this->product->slug,
            'category' => $this->product->category->name,
            'price' => $this->product->price,
            'stock' => $this->product->stock,
            'photo' => $this->product->photo,
            'quantity' => $this->quantity,
        ];
    }
}