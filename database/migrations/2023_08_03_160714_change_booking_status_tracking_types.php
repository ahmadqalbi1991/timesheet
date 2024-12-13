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
            
            Schema::table('booking_status_trackings', function (Blueprint $table) {
                DB::statement("ALTER TABLE booking_status_trackings DROP CONSTRAINT booking_status_trackings_status_tracking_check");
    
                $types = ['request_created','qoutes_received','on_process','cancelled','completed'];
                $result = join( ', ', array_map(function ($value){
                    return sprintf("'%s'::character varying", $value);
                }, $types));
        
                DB::statement("ALTER TABLE booking_status_trackings ADD CONSTRAINT booking_status_trackings_status_tracking_check CHECK (status_tracking::text = ANY (ARRAY[$result]::text[]))");
            });

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_status_trackings', function (Blueprint $table) {
            //
        });
    }
};
