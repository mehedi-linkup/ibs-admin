<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('slug', 30);
            $table->string('user_id');
            $table->string('user_ip');
            $table->softDeletes();
            $table->timestamps();
        });

        // create default one 
        $role = new Role();
        $role->name = 'Super Admin';
        $role->slug = 'super-admin';
        $role->user_id = 1;
        $role->user_ip = '127.0.0.1';
        $role->save();
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
}
