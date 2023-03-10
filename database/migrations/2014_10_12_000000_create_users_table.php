<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('role_id');
            $table->string('password');
            $table->string('image')->nullable();
            $table->bigInteger('factory_id')->nullable();
            $table->bigInteger('merchant_id')->nullable();
            $table->bigInteger('coordinator_id')->nullable();
            $table->bigInteger('gm')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // crate default one
        $user = new User();
        $user->name = 'mr. admin';
        $user->role_id = 1;
        $user->email = 'admin@gmail.com';
        $user->username = 'SuperAdmin';
        $user->password = Hash::make('1');
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
