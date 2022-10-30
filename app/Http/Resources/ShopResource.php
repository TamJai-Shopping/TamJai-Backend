<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            'name'=> $this->name,
            'description'=> $this->description,
            'image_path'=> $this->image_path,
            'user_id'=> $this->user_id,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            ];
    }
}
