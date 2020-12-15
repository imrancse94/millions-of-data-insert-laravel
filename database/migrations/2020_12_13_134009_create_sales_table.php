<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('region',50);
            $table->string('country',50);
            $table->string('item_type',50);
            $table->string('sales_channel',50);
            $table->string('order_priority',10);
            $table->date('order_date');
            $table->integer('order_id');
            $table->date('ship_date');
            $table->integer('unit_sold');
            $table->decimal('unit_price', 8,2);
            $table->decimal('unit_cost', 8,2);
            $table->decimal('total_revenue', 10,2);
            $table->decimal('total_cost', 10,2);
            $table->decimal('total_profit', 10,2);
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
        Schema::dropIfExists('sales');
    }
}
