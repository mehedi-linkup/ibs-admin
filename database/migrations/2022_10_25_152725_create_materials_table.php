<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('gm_id');
            $table->unsignedBigInteger('coordinator_id');
            $table->unsignedBigInteger('wash_coordinator_id');
            $table->unsignedBigInteger('wash_unit_id');
            $table->unsignedBigInteger('cad_id');
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('fabric_ref');
            $table->string('composition');
            $table->text('remarks1');
            $table->string('cw')->nullable();
            $table->string('bw')->nullable();
            $table->string('aw')->nullable();
            $table->date('fabric_sent')->nullable();
            $table->time('time')->nullable();
            $table->date('update_time')->nullable();
            $table->float('quantity')->default(0);
            $table->string('fabric_type')->nullable();
            $table->date('receive_date')->nullable();
            $table->date('receive_update_date')->nullable();
            $table->float('receive_qty')->default(0);
            $table->date('shrinkage_sent')->nullable();
            $table->time('shrinkage_time')->nullable();
            $table->date('shrinkage_update_date')->nullable();
            $table->date('return_to_section')->nullable();
            $table->dateTime('return_to_time')->nullable();
            $table->date('shrinkage_receive')->nullable();
            $table->time('shrinkage_receive_time')->nullable();
            $table->date('shrinkage_receive_update')->nullable();
            $table->string('shrinkage_length', 40)->nullable();
            $table->string('shrinkage_width', 40)->nullable();
            $table->date('sent_store')->nullable();
            $table->date('update_store')->nullable();
            $table->float('store_qty')->default(0);
            $table->date('reset_date')->nullable();
            $table->string('status', 1)->default('a');
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
        Schema::dropIfExists('materials');
    }
}
