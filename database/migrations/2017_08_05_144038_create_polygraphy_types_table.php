<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePolygraphyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polygraphy_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('format');
            $table->string('mat_name');
            $table->string('mat_descr');
            $table->string('order_code');
            $table->string('mat_type');
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
        Schema::drop('polygraphy_types');
    }
}
