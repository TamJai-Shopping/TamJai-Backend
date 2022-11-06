<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'total_price' => $this->total_price,
            'package_number' => $this->package_number,
            'location' => $this->location,
            'shop_id' => $this->shop_id,
            'user' => $this->whenLoaded('user'),
            'order_items'=>OrderItemResource::collection($this->whenLoaded('orderItems'))
        ];
    }
}
