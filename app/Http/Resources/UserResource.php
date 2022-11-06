<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'shop_id' => ShopResource::collection($this->whenLoaded('shops')),
            'phone_number' => $this->phone_number,
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }
}
