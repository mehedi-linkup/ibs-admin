<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_data_id')
                ->constrained('order_data')
                ->onDelete('cascade');
            $table->string('order_number', 100)->nullable();
            $table->date('shipment_date')->nullable();
            $table->foreignId('color_id')
                ->constrained('colors')
                ->onDelete('cascade');
            $table->string('size');
            $table->decimal('order_qty', 18,2)->default(0.00);
            $table->foreignId('unit_id')
                ->constrained('units')
                ->onDelete('cascade');
            $table->string('pt_received')->nullable();
            $table->date('payment_date');
            $table->date('tentative_in_house_date')->nullable();
            $table->decimal('received_qty', 18,2)->default(0.00);
            $table->decimal('remaining_qty', 18,2)->default(0.00);
            $table->date('in_house_date')->nullable();
            $table->string('task',40)->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
