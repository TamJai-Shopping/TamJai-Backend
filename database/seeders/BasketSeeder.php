<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        'id' => $this->id,
        'products' => ProductResource::collection($this->whenLoaded('products')),
        'quantity' => $this->quantity

    }
}
