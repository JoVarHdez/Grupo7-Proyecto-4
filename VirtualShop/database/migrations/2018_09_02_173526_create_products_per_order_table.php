<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsPerOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productsPerOrder', function (Blueprint $table) {
            $table->increments('idProductPerOrder');
            $table->unsignedInteger('idProduct');
            $table->unsignedInteger('idOrder');
            $table->unsignedSmallInteger('productQuantity');
            $table->foreign('idOrder')->references('idOrder')->on('orders');
            $table->foreign('idProduct')->references('idProduct')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productsPerOrder');
    }
}
