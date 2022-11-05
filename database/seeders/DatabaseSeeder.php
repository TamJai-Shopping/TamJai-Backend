<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ShopSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderItemSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(BasketSeeder::class);
        $this->call(BasketItemSeeder::class);
        
    }
}
