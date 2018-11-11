<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_user')->unsigned();
            $table->foreign('item_user')->references('id')->on('users')->onDelete('restrict');
            $table->integer('cat_id')->unsigned();
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('restrict');
            $table->string('item_name');
            $table->text('item_desc')->nullable();
            $table->string('item_photo')->default('1.png');
            $table->string('buy_price');
            $table->string('sell_price');
            $table->string('stay_mount')->nullable();
            $table->string('sell_mount')->nullable();
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
        Schema::dropIfExists('items');
    }
}
