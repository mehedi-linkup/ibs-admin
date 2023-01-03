<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('cp');
            $table->foreignId('buyer_id')
                ->constrained('buyers')
                ->onDelete('cascade');
            $table->string('season');
            $table->foreignId('department_id')
                ->constrained('departments')
                ->onDelete('cascade');
            $table->string('style_no_or_name');
            $table->text('description');
            $table->string('base_top_up');
            $table->string('fty');
            $table->string('lc');
            $table->string('gm');
            $table->string('user_id');
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
        Schema::dropIfExists('products');
    }
}
