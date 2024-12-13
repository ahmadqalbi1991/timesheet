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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('is_collection')->nullable();
            $table->text('collection_address')->nullable();
            $table->text('deliver_address')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('deligate_id')->nullable();
            $table->string('deligate_type')->nullable();
            $table->enum('admin_response',['pending','ask_for_qoute','driver_qouted','approved_by_admin']);
            $table->integer('comission_amount')->nullable();
            $table->integer('customer_signature')->nullable();
            $table->text('delivery_note')->nullable();
            $table->enum('status',['pending','qouted','accepted','journey_started','item_collected','on_the_way','border_crossing','custom_clearance','delivered']);
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
        Schema::dropIfExists('bookings');
    }
};
