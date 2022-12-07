<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positems', function (Blueprint $table) {
            $table->id();
            $table->string('pos_id');
            $table->string('shop_id');
            $table->string('product_id');
            $table->string('qty');
            $table->string('selling_price');
            $table->string('discount');
            $table->string('total_price');
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
        Schema::dropIfExists('positems');
    }
}
