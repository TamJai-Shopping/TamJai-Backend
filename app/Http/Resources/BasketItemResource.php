<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BasketItemResource extends JsonResource
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
            'baskets' => $this->whenLoaded('basket'),
            'product_id' => $this->product_id,
            'shop_id' => $this->shop_id,
            'quantity' => $this->quantity,
            
            
            
        ];
    }
}