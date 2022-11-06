<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    // public function basket()
    // {
    //     return $this->belongsTo(Basket::class);
    // }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function image() {
        return $this->belongsTo(Image::class);
    }

    public function productToStr() {
        // $categories = Category::where('product_id',$id);
        // foreach ($categories as $catagorie_name) {
        //     $catagories_str[] = $catagorie_name->name;
        // }
        return "ดีครับ";
    }
}
