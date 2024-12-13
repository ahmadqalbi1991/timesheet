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
        Schema::table('booking_qoutes', function (Blueprint $table) {
            $table->enum('is_admin_approved',['no','yes'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_qoutes', function (Blueprint $table) {
            $table->dropColumn('is_admin_approved');
        });
    }
};
