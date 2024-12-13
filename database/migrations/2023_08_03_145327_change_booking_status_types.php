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
            DB::statement("ALTER TABLE bookings DROP CONSTRAINT bookings_status_check");

            $types = ['pending','qoutes_received','on_process','cancelled','completed'];
            $result = join( ', ', array_map(function ($value){
                return sprintf("'%s'::character varying", $value);
            }, $types));
    
            DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_status_check CHECK (status::text = ANY (ARRAY[$result]::text[]))");
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
            
        });
    }
};
