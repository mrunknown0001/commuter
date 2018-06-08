<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('to')->unsigned();
            $table->foreign('to')->references('id')->on('users');
            $table->string('title')->nullable(); // request ride accepted, ride cancelled by driver or commuter, etc
            $table->integer('ride_id')->unsigned()->nullable();
            $table->foreign('ride_id')->references('id')->on('rides');
            $table->string('message')->nullable();
            $table->tinyInteger('viewed')->default(0);
            $table->string('url')->nullable(); // name of the route
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
        Schema::dropIfExists('notifications');
    }
}
