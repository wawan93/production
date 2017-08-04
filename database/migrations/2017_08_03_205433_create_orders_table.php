<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('team_id');
            $table->text('code_name');
            $table->text('polygraphy_type');
            $table->integer('manager_id');
            $table->boolean('alert');
            $table->integer('edition_initial');
			$table->enum('status', [
            	'approved', 'invoices', 'paid', 'production', 'shipped', ''
			]);
			$table->enum('polygraphy_format', [
            	'A4', 'A3', 'vizitka', 'paper', ''
			]);
			$table->integer('edition_final');
			$table->text('manufacturer');
			$table->date('paid_date');
			$table->date('final_date');
			$table->dateTime('ship_date');
			$table->text('contact');
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
