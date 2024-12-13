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
        Schema::table('bookings', function (Blueprint $table) {
            $table->double('total_commission_amount')->nullable();
            $table->double('total_received_amount')->default(0);
            $table->double('sub_total')->nullable();
            $table->double('grand_total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('total_commission_amount');
            $table->dropColumn('total_received_amount');
            $table->dropColumn('sub_total');
            $table->dropColumn('grand_total');

        });
    }
};
