<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_details_id')
                ->constrained('order_details')
                ->onDelete('cascade');
            $table->date('date');
            $table->date('receive_date');
            $table->decimal('quantity', 18,2)->default(0.00);
            $table->string('chalan_number')->nullable();
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
        Schema::dropIfExists('order_details_data');
    }
}
