<?php

namespace App\Http\Resources;

use App\Models\Review;
use App\Models\Product;
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
        foreach(CategoryResource::collection($this->category))
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
            'shop_id'=> $this->shop_id,
            'categories_str'=> Product::productToStr(),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'review_count' => Review::where('product_id', $this->id)->count(),
            'review_stat' => [
                'zero' => Review::where('product_id', $this->id)->where('rating', '0')->count(),
                'one' => Review::where('product_id', $this->id)->where('rating', '1')->count(),
                'two' => Review::where('product_id', $this->id)->where('rating', '2')->count(),
                'three' => Review::where('product_id', $this->id)->where('rating', '3')->count(),
                'four' => Review::where('product_id', $this->id)->where('rating', '4')->count(),
                'five' => Review::where('product_id', $this->id)->where('rating', '5')->count(),
            ]
        ];
    }
}
