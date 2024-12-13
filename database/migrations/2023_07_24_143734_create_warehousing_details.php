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
        Schema::create('warehousing_details', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->nullable();
            $table->enum('items_are_stockable',['yes','no'])->nullable();
            $table->string('type_of_storage')->nullable();
            $table->string('item')->nullable();
            $table->string('pallet_dimension')->nullable();
            $table->integer('weight_per_pallet')->nullable();
            $table->integer('total_weight')->nullable();
            $table->integer('total_item_cost')->nullable();
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
        Schema::dropIfExists('warehousing_details');
    }
};
