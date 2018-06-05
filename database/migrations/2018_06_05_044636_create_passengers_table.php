<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ride_id')->unsigned();
            $table->foreign('ride_id')->references('id')->on('rides');
            $table->integer('passenger1')->nullable();
            $table->integer('passenger2')->nullable();
            $table->integer('passenger3')->nullable();
            $table->integer('passenger4')->nullable();
            $table->string('passenger1_name')->nullable();
            $table->string('passenger2_name')->nullable();
            $table->string('passenger3_name')->nullable();
            $table->string('passenger4_name')->nullable();
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
        Schema::dropIfExists('passengers');
    }
}
