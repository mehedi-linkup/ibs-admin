<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_id')
                ->constrained('samples')
                ->onDelete('cascade');
            $table->foreignId('sample_name_id')
                ->constrained('sample_names')
                ->onDelete('cascade');
            $table->string('sample_type');
            $table->string('fabric_code');
            $table->foreignId('color_id')
                ->constrained('colors')
                ->onDelete('cascade');
            $table->string('size');
            $table->float('quantity')->default(0);
            $table->dateTime('req_sent_date')->nullable();
            $table->date('sample_delivery_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('file')->nullable();
            $table->date('req_accept_date')->nullable();
            $table->date('sewing_date')->nullable();
            $table->date('actual_delivery_date')->nullable();
            $table->string('status')->default('a');
            $table->tinyInteger('active')->default(1);
            $table->integer('user_id')->nullable();
            $table->string('user_ip')->nullable();
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
        Schema::dropIfExists('sample_data');
    }
}
