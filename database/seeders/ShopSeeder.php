<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shop = new Shop;
        $shop->name = "shop1";
        $shop->description = "shop test";
        $shop->user_id = "1";
        $shop->save();

        $shop = new Shop;
        $shop->name = "shop2";
        $shop->description = "shop test";
        $shop->user_id = "1";
        $shop->save();
    }
}
