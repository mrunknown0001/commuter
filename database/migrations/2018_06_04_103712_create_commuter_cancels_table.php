<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommuterCancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commuter_cancels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_number', 10);
            $table->integer('ride_id')->unsigned();
            $table->foreign('ride_id')->references('id')->on('rides');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
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
        Schema::dropIfExists('commuter_cancels');
    }
}
