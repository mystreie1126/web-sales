<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRdPickupOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rd_pickup_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ie_customer_id');
            $table->integer('ie_order_id');
            $table->integer('pos_shop_id');
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
        Schema::dropIfExists('rd_pickup_orders');
    }
}
