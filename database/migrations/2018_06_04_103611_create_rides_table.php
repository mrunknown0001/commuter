<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ride_number')->unique();
            $table->integer('commuter_id')->unsigned();
            $table->foreign('commuter_id')->references('id')->on('users');
            $table->integer('driver_id')->unsigned()->nullable();
            $table->foreign('driver_id')->references('id')->on('users');
            $table->integer('pickup_loc')->unsigned();
            $table->foreign('pickup_loc')->references('id')->on('locations');
            $table->integer('drop_off_loc')->unsigned()->nullable();
            $table->foreign('drop_off_loc')->references('id')->on('locations');
            $table->integer('payment');
            $table->integer('each');
            $table->tinyInteger('finalized')->default(1);
            $table->tinyInteger('accepted')->default(0);
            $table->timestamp('accepted_at')->nullable();
            $table->tinyInteger('current')->default(0); // same as with pickup
            $table->timestamp('current_at')->nullable();
            $table->tinyInteger('drop_off')->default(0);
            $table->tinyInteger('drop_off_conrimation')->default(0);
            $table->timestamp('drop_off_at')->nullable();
            $table->tinyInteger('cancelled')->default(0);
            $table->tinyInteger('cancelled_by_commuter')->default(0);
            $table->tinyInteger('commuter_unappearance')->default(0);
            $table->tinyInteger('finished')->default(0);
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
        Schema::dropIfExists('rides');
    }
}
