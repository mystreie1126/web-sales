<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneorderpaidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rd_order_paid', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paid_amount');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->string('shop_name');
            $table->integer('rockpos_shop_id');
            $table->integer('device_order');
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
        Schema::dropIfExists('phone_order_paid');
    }
}
