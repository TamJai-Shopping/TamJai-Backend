<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Basket;

class BasketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line("Generating baskets");
        $basket = new Basket;
        $basket->user_id= 1;
        $basket->selectShop= 1;
        $basket->save();
    }
}
