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
        Schema::table('users', function (Blueprint $table) {
            $table->string('password_reset_otp')->nullable();
            $table->string('password_reset_time')->nullable();
            $table->string('login_type')->default('normal');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password_reset_otp');
            $table->dropColumn('password_reset_time');
            $table->dropColumn('login_type');
        });
    }
};
