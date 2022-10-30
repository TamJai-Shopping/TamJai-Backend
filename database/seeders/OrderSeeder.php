<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line("Generating orders");
        $order = new Order;
        $order->status = "statusTest";
        $order->total_price = 2500;
        $order->package_number = "PAC001";
        $order->location = "Wonderland";
        $order->shop_id = "1" ;
        $order->save();

    }
}
