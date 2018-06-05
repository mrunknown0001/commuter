<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_number');
            $table->integer('complainant_id')->unsigned();
            $table->foreign('complainant_id')->references('id')->on('users');
            $table->integer('reported_user_id')->unsigned();
            $table->foreign('reported_user_id')->references('id')->on('users');
            $table->string('reason');
            $table->string('content')->nullable();
            $table->integer('driver_cancel_id')->unsigned()->nullable();
            $table->foreign('driver_cancel_id')->references('id')->on('driver_cancels');
            $table->integer('commuter_cancel_id')->unsigned()->nullable();
            $table->foreign('commuter_cancel_id')->references('id')->on('commuter_cancels');
            $table->tinyInteger('viewed')->default(0);
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
        Schema::dropIfExists('reports');
    }
}
