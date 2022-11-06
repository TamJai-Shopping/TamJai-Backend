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
        $this->command->line("Generating 100 review");
        Review::factory(100)->create();
        foreach (Review::get() as $review) {
            $product = Product::find($review->product_id);
            $product->rating = Review::where('product_id', $product->id)->sum('rating') / Review::where('product_id', $product->id)->count();
            Log::info(Review::where('product_id', $product->id)->count());
            $product->save();
        }
    }
}
