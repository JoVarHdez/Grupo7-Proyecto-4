<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsPerCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productsPerCategory', function (Blueprint $table) {
            $table->increments('idProductPerCategory');
            $table->unsignedInteger('idProduct');
            $table->unsignedInteger('idCategory');
            $table->foreign('idCategory')->references('idCategory')->on('categories');
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
        Schema::dropIfExists('productsPerCategory');
    }
}
