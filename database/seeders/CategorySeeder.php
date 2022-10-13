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
        $this->command->line("Generating category");
        $category = new Category;
        $category->name = "Book";
        $category->save();

        $this->command->line("sync category to product");
        $product = Product::find(1);
        $product->categories()->sync(1);
    }
}
