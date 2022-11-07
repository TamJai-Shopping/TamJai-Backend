<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $amount = 200;
//        $this->command->line("Generating ".$amount." reviews");
//        Review::factory($amount)->create();
//        foreach (Review::get() as $review) {
//            $product = Product::find($review->product_id);
//            $product->rating = Review::where('product_id', $product->id)->sum('rating') / Review::where('product_id', $product->id)->count();
//            $product->save();
//        }
    }
}
