<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gm_id')
                ->constrained('gms')
                ->onDelete('cascade');
            $table->foreignId('buyer_id')
                ->constrained('buyers')
                ->onDelete('cascade');
            $table->string('item_name');
            $table->string('style_no');
            $table->foreignId('coordinator_id')
                ->constrained('coordinators')
                ->onDelete('cascade');
            $table->bigInteger('wash_coordinator_id');
            $table->bigInteger('finishing_coordinator_id');
            $table->bigInteger('cad_id');
            $table->string('design_no');
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
        Schema::dropIfExists('samples');
    }
}
