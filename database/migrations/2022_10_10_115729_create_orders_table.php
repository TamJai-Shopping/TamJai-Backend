<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->integer('total_price');
            $table->string('package_number');
            $table->string('location');
            $table->foreignIdFor(\App\Models\Shop::class);//orderร้านไหน
            $table->foreignIdFor(\App\Models\User::class);//ระบุว่าเป็นของuserคนไหน
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
