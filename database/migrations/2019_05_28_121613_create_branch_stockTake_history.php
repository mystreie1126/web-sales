<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchStockTakeHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_branchStockTake_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pos_stock_id');
            $table->string('name');
            $table->string('reference');
            $table->string('username');
            $table->integer('shop_id');
            $table->integer('added')->default(0);
            $table->integer('sealed')->default(0);
            $table->integer('updated_quantity');
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
        Schema::dropIfExists('sm_branchStockTake_history');
    }
}
