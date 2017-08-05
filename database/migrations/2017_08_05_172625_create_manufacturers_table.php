<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('short_name');
            $table->text('full_name');
            $table->text('full_name_decl');
            $table->string('inn');
            $table->string('domicile');
            $table->string('contact');
            $table->string('email');
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
        Schema::drop('manufacturers');
    }
}
