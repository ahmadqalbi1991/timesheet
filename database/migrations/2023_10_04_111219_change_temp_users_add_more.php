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
        Schema::table('temp_users', function (Blueprint $table) {
            $table->integer('role_id')->default(0);
            $table->integer('country_id')->default(0);
            $table->integer('city_id')->default(0);
            $table->integer('user_phone_otp')->default(0);
            
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
