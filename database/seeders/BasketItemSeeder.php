<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BasketItem;

class BasketItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line("Generating basketItems");
        $basket = new BasketItem;
        $basket->basket_id= 1;
        $basket->product_id= 1;
        $basket->shop_id= 1;
        $basket->quantity= 22;
        $basket->save();
    }
}
