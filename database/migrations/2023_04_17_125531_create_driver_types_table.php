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
        Schema::create('driver_types', function (Blueprint $table) {
            $table->integer('id');
            $table->string('type');
            $table->timestamps();
        });

        DB::table('driver_types')->insert(['id' => 0, 'type' => 'Individual']);
        DB::table('driver_types')->insert(['id' => 1, 'type' => 'Company']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_types');
    }
};
