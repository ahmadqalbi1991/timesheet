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
            $table->string('rack')->nullable()->default('');
            $table->text('storage_picture')->nullable()->default('');
            $table->string('date_of_commencement')->nullable()->default('');
            $table->string('date_of_return')->nullable()->default('');
            $table->text('instructions')->nullable()->default('');
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
            $table->dropColumn('rack');
            $table->dropColumn('storage_picture');
            $table->dropColumn('date_of_commencement');
            $table->dropColumn('date_of_return');
            $table->dropColumn('instructions');
        });
    }
};
