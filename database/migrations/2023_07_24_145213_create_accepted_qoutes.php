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
        Schema::create('accepted_qoutes', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->integer('driver_id');
            $table->integer('hours');
            $table->double('qouted_amount')->nullable();
            $table->double('commission_amount')->nullable();
            $table->double('border_charges')->nullable();
            $table->double('shipping_charges')->nullable();
            $table->double('wating_charges')->nullable();
            $table->double('custom_charges')->nullable();
            $table->double('cost_of_truck')->nullable();
            $table->double('received_amount')->nullable();
            $table->double('total_amount')->nullable();
            $table->enum('status',['pending','qouted','accepted','journey_started','item_collected','on_the_way','border_crossing','custom_clearance','delivered']);
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
        Schema::dropIfExists('accepted_qoutes');
    }
};
