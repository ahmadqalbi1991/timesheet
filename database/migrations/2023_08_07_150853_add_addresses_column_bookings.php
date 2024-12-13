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
            $table->string('collection_latitude')->nullable();
            $table->string('collection_longitude')->nullable();
            $table->string('collection_country')->nullable();
            $table->string('collection_city')->nullable();
            $table->string('collection_zipcode')->nullable();

            $table->string('deliver_latitude')->nullable();
            $table->string('deliver_longitude')->nullable();
            $table->string('deliver_country')->nullable();
            $table->string('deliver_city')->nullable();
            $table->string('deliver_zipcode')->nullable();
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
            
            $table->dropColumn('collection_latitude');
            $table->dropColumn('collection_longitude');
            $table->dropColumn('collection_country');
            $table->dropColumn('collection_city');
            $table->dropColumn('collection_zipcode');

            $table->dropColumn('deliver_latitude');
            $table->dropColumn('deliver_longitude');
            $table->dropColumn('deliver_country');
            $table->dropColumn('deliver_city');
            $table->dropColumn('deliver_zipcode');

        });
    }
};
