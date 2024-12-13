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
        DB::statement("ALTER TABLE warehousing_details ALTER COLUMN type_of_storage TYPE INT USING CASE WHEN type_of_storage = 'value1' THEN 0 WHEN type_of_storage = 'value2' THEN 1 ELSE 2 END");
        Schema::table('warehousing_details', function (Blueprint $table) {
            $table->integer('no_of_pallets')->nullable();
            $table->integer('type_of_storage')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehousing_details', function (Blueprint $table) {
            $table->dropColumn('no_of_pallets');
            $table->string('type_of_storage')->change();
        });
    }
};
