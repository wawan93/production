<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDirection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polygraphy_invoices', function (Blueprint $table) {
            $table->enum('direction', ['invoice', 'payment'])->default('invoice');
            $table->dropIndex('invoices_user_id_order_id_uindex');
            $table->unique(['direction', 'order_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polygraphy_invoices', function (Blueprint $table) {
            $table->dropColumn('direction');
            $table->unique(['order_id', 'user_id']);
        });
    }
}
