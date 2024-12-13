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
            $table->text('delivery_note')->nullable();
            $table->text('customer_signature')->nullable();
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
            $table->dropColumn('delivery_note');
            $table->dropColumn('customer_signature');
        });
    }
};
