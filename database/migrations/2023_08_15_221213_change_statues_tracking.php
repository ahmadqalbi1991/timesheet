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
        Schema::table('booking_status_trackings', function (Blueprint $table) {
            DB::statement("ALTER TABLE booking_status_trackings DROP CONSTRAINT booking_status_trackings_status_tracking_check");

            $types = ['request_created','accepted','journey_started','item_collected','on_the_way','border_crossing','custom_clearance','delivered'];
            $result = join( ', ', array_map(function ($value){
                return sprintf("'%s'::character varying", $value);
            }, $types));
    
            DB::statement("ALTER TABLE booking_status_trackings ADD CONSTRAINT booking_status_trackings_status_tracking_check CHECK (status_tracking::text = ANY (ARRAY[$result]::text[]))");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
