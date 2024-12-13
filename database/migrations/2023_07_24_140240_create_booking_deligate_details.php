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
        Schema::create('booking_deligate_details', function (Blueprint $table) {
            $table->id();
            $table->string('item')->nullable();
            $table->integer('booking_id')->nullable();
            $table->integer('no_of_packages')->nullable();
            $table->string('dimension_of_each_package')->nullable();
            $table->string('weight_of_each_package')->nullable();
            $table->integer('total_gross_weight')->nullable();
            $table->integer('total_volume_in_cbm')->nullable();
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
        Schema::dropIfExists('booking_deligate_details');
    }
};
