<?php

namespace App\Http\Resources;

use App\Models\Product;
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
            'product_name' => Product::find($this->product_id)->name,
            'product_price' => Product::find($this->product_id)->price,
            'shop_id' => $this->shop_id,
            // 'shop_name' => Shop::find($this->shop_id)->name,
            'quantity' => $this->quantity
        ];
    }
}
