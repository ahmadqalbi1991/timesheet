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
         Schema::table('bookings', function (Blueprint $table) {            
            $table->integer('statuscode')->default(0);            
            
        });
         Schema::table('booking_qoutes', function (Blueprint $table) {            
            $table->integer('statuscode')->default(0);            
            
        });
         Schema::table('accepted_qoutes', function (Blueprint $table) {            
            $table->integer('statuscode')->default(0);            
            
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
