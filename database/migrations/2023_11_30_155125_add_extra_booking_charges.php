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
        //
        Schema::create('booking_extra_charges', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->default(0);
            $table->integer('accepted_quote_id')->default(0);
            $table->integer('driver_id')->default(0);
            $table->integer('extra_charge_id')->default(0);
            $table->string('extra_charge_name')->nullable();
            $table->double('extra_charge_amount')->default(0);
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
        //
    }
};
