<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role');
            $table->integer('is_admin_role')->default(0);
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Role::create([
                    'role'=>'Admin',
                    'status'=>'active',
                    'is_admin_role'=> '1'
                ]);
        Role::create([
                    'role'=>'Truck Driver',
                    'status'=>'active',
                ]);
        Role::create([
                    'role'=>'Customer',
                    'status'=>'active',
                ]);
        Role::create([
                    'role'=>'Company',
                    'status'=>'active',
                ]);        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
