<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('idRate');
            $table->smallInteger('rate');
            $table->unsignedInteger('idUser');
            $table->unsignedInteger('idProduct');
            $table->foreign('idUser')->references('idUser')->on('users');
            $table->foreign('idProduct')->references('idProduct')->on('products');
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
        Schema::dropIfExists('rates');
    }
}
