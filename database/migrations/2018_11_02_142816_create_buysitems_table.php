<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuysitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buysitems', function (Blueprint $table) {
            $table->primary(['buy_id','item_id']);
            $table->integer('buy_id');
            $table->integer('item_id');
            $table->integer('item_mountbuy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buysitems');
    }
}
