<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
        'total_amount'=> $this->total_amount,
        'sell_amount'=> $this->sell_amount,
        'alert_amount'=> $this->alert_amount,
        'image_path'=> $this->image_path,
        'price'=> $this->price,
        'rating'=> $this->rating,
        'shop_id'=> $this->shop_id
        ];
    }
}
