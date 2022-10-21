<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::first();
        if (!$category) {
            $this->command->line("Generating category");
            $categories = ['Book', 'Food', 'Technology'];
            collect($categories)->each(function ($category_name, $key) {
                $category = new Category;
                $category->name = $category_name;
                $category->save();
            });
        }

        $this->command->line("sync category to product");
        $products = product::get();
        $products->each(function($product, $key) {
            $n = fake()->numberBetween(1, 2);
            $category_ids = Category::inRandomOrder()->limit($n)->get()->pluck(['id'])->all();
            $product->categories()->sync($category_ids);
        });
    }
}
