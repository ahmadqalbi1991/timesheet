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
        Schema::create('temp_users', function (Blueprint $table) {
            $table->increments('temp_user_id');
            $table->string('truck_type')->nullable();
            $table->string('account_type')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('dial_code')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('driving_license')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('emirates_id_or_passport')->nullable();
            $table->string('emirates_id_or_passport_back')->nullable();
            $table->string('user_device_type')->nullable();
            $table->string('user_device_token')->nullable();
            $table->string('user_device_id')->nullable();
            $table->string('driving_license_number')->nullable()->unique();
            $table->date('driving_license_expiry')->nullable();
            $table->string('driving_license_issued_by')->nullable();
            $table->string('vehicle_plate_number')->nullable();
            $table->string('vehicle_plate_place')->nullable();
            $table->string('mulkiya')->nullable();
            $table->string('mulkiya_number')->nullable();
            $table->string('status')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_users');
    }
};
