<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'user_id' => $this->user_id,
            'order_items'=>$this->whenLoaded('orderItems')
        ];
    }
}
