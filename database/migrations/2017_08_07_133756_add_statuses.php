<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polygraphy_orders', function (Blueprint $table) {
            $table->enum('status',[
                'approved',
                'fundraise',
                'invoices',
                'paid',
                'production',
                'shipped',
                'cancelled'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polygraphy_orders', function (Blueprint $table) {
            //
        });
    }
}
