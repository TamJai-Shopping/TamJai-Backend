<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line("Generating orders");
        $order = new OrderItem;
        $order->order_id = "1";
        $order->product_id = "1";
        $order->quantity = 2;
        $order->save();

        $order = new OrderItem;
        $order->order_id = "1";
        $order->product_id = "2";
        $order->quantity = 4;
        $order->save();
    }
}
