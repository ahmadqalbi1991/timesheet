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
        Schema::table('cart_deligate_details', function (Blueprint $table) {
            $table->integer('num_of_pallets')->default(0);
        }); 
        Schema::table('booking_deligate_details', function (Blueprint $table) {
            $table->integer('num_of_pallets')->default(0);
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
