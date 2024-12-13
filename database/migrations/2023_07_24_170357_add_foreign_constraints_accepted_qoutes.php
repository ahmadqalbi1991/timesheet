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
        Schema::table('accepted_qoutes', function (Blueprint $table) {
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accepted_qoutes', function (Blueprint $table) {
            $table->dropForeign('accepted_qoutes_booking_id_foreign');
            $table->dropForeign('accepted_qoutes_driver_id_foreign');
        });
    }
};
