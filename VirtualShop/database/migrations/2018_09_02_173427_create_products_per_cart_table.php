<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsPerCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productsPerCart', function (Blueprint $table) {
            $table->increments('idProductPerCart');
            $table->unsignedInteger('idProduct');
            $table->unsignedInteger('idCart');
            $table->unsignedSmallInteger('productQuantity');
            $table->foreign('idCart')->references('idCart')->on('carts');
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
        Schema::dropIfExists('productsPerCart');
    }
}
