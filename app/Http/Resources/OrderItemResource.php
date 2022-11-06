<?php

namespace App\Http\Resources;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
        'orders' => $this->whenLoaded('order'),
        'products' => $this->whenLoaded('product'),
        'name'=> Product::where('id',$this->product_id)->first()->name,
        'quantity' => $this->quantity
        ];
    }
}
