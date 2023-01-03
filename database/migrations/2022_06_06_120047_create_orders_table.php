<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')
                ->constrained('buyers')
                ->onDelete('cascade');
            $table->string('style_description');
            $table->string('style_number');
            $table->foreignId('merchant_id')
                ->constrained('merchants')
                ->onDelete('cascade');
            $table->foreignId('factory_id')
                ->constrained('factories')
                ->onDelete('cascade');
            $table->string('gm', 20);
            $table->integer('user_id');
            $table->string('user_ip');
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
